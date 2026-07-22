<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Prevision;
use App\Models\Parcelle;
use App\Models\Saison;
use App\Services\NotificationService;

class PrevisionController extends Controller
{
    // ── PAGE ACCUEIL PUBLIQUE ─────────────────────────
    public function accueil()
    {
        return view('public.acceuil');
    }

    // ── DASHBOARD UTILISATEUR ─────────────────────────
public function dashboard()
{
    $user = auth()->user();

    $previsionsUser = Prevision::whereHas('parcelle', fn($q) => $q->where('user_id', $user->id));

    $stats = [
        'parcelles_count'   => Parcelle::where('user_id', $user->id)->count(),
        'previsions_count'  => (clone $previsionsUser)->count(),
        'avg_rendement'     => round((clone $previsionsUser)->avg('rendement_prevu') ?? 0, 2),
        'production_totale' => round(
            Prevision::whereHas('parcelle', fn($q) => $q->where('user_id', $user->id))
                ->join('parcelles', 'previsions.parcelle_id', '=', 'parcelles.id')
                ->sum(DB::raw('previsions.rendement_prevu * parcelles.superficie')) ?? 0,
            1
        ),
    ];

    $previsions = Prevision::with('parcelle')
        ->whereHas('parcelle', fn($q) => $q->where('user_id', $user->id))
        ->latest()
        ->take(10)
        ->get()
        ->reverse();

    return view('public.dashboard', compact('stats', 'previsions'));
}

    // ── FORMULAIRE DE PREVISION ───────────────────────
    public function index()
    {
        $parcelles = Parcelle::where('user_id', auth()->id())->latest()->get();
        $saisons   = Saison::where('user_id', auth()->id())->latest()->get();
        return view('previsions.formulaire', compact('parcelles', 'saisons'));
    }

    // ── BUFFER DYNAMIQUE SELON SUPERFICIE ─────────────
    private function calculerBuffer(float $superficie_ha): int
    {
        $rayon = sqrt($superficie_ha * 10000 / pi()) * 1.1;
        return max(50, min(500, intval($rayon)));
    }

    // ── NDVI VIA SCRIPT PYTHON ────────────────────────
// ── NDVI VIA SCRIPT PYTHON (VERSION AMÉLIORÉE) ─────────────────────────
private function getNdvi(float $lat, float $lng, int $buffer): float
{
    $scriptPath = storage_path('app/get_ndvi.py');

    // Vérifie si le script existe
    if (!file_exists($scriptPath)) {
        \Log::error("❌ Script get_ndvi.py introuvable : {$scriptPath}");
        return 0.35;
    }

    // Journalisation des paramètres reçus
    \Log::info('========== DEMANDE NDVI ==========', [
        'user_id' => auth()->id(),
        'lat'     => $lat,
        'lng'     => $lng,
        'buffer'  => $buffer,
    ]);

    // Construction sécurisée de la commande
    $command = sprintf(
        'py -3.11 %s %s %s %s 2>&1',
        escapeshellarg($scriptPath),
        escapeshellarg((string) $lat),
        escapeshellarg((string) $lng),
        escapeshellarg((string) $buffer)
    );

    \Log::info('Commande exécutée', [
        'command' => $command
    ]);

    // Exécution du script Python
    $output = shell_exec($command);

    \Log::info('Réponse brute du script Python', [
        'output' => $output
    ]);

    if ($output === null || trim($output) === '') {

        \Log::error('Le script Python n\'a retourné aucune sortie.');

        return 0.35;
    }

    // Décodage JSON
    $data = json_decode(trim($output), true);

    if (json_last_error() !== JSON_ERROR_NONE) {

        \Log::error('JSON invalide retourné par Python', [
            'json_error' => json_last_error_msg(),
            'output'     => $output,
        ]);

        return 0.35;
    }

    // Earth Engine a renvoyé une erreur
    if (!($data['success'] ?? false)) {

        \Log::error('Erreur Google Earth Engine', [
            'erreur' => $data['erreur'] ?? 'Erreur inconnue',
            'data'   => $data,
        ]);

        return 0.35;
    }

    // NDVI absent
    if (!array_key_exists('ndvi', $data) || $data['ndvi'] === null) {

        \Log::warning('NDVI absent dans la réponse Python', [
            'data' => $data,
        ]);

        return 0.35;
    }

    $ndvi = round((float) $data['ndvi'], 4);

    \Log::info('NDVI récupéré avec succès', [
        'user_id' => auth()->id(),
        'ndvi'    => $ndvi,
        'images'  => $data['images'] ?? 'Inconnu',
        'buffer'  => $buffer,
    ]);

    return $ndvi;
}

    // ── METEO VIA OPEN-METEO ──────────────────────────
    private function getMeteo(float $lat, float $lng): array
    {
        try {
            $response = Http::timeout(30)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude'      => $lat,
                'longitude'     => $lng,
                'daily'         => 'precipitation_sum,temperature_2m_mean,relative_humidity_2m_mean',
                'timezone'      => 'auto',
                'forecast_days' => 7,
            ]);

            if (!$response->successful()) {
                throw new \Exception('Open-Meteo non disponible');
            }

            $daily = $response->json()['daily'];
            $pluie = array_filter($daily['precipitation_sum'], fn($v) => $v !== null);
            $temp  = array_filter($daily['temperature_2m_mean'], fn($v) => $v !== null);
            $hum   = array_filter($daily['relative_humidity_2m_mean'], fn($v) => $v !== null);

            return [
                'pluviometrie' => round(array_sum($pluie), 2),
                'temperature'  => count($temp)  ? round(array_sum($temp)  / count($temp),  2) : 27.0,
                'humidite'     => count($hum)   ? round(array_sum($hum)   / count($hum),   2) : 75.0,
            ];

        } catch (\Exception $e) {
            \Log::warning('Open-Meteo erreur : ' . $e->getMessage() . ' — valeurs par defaut');
            return ['pluviometrie' => 120.0, 'temperature' => 27.0, 'humidite' => 75.0];
        }
    }

    // ── RECOMMANDATIONS VIA GROQ API ──────────────────
    private function getRecommandations(
        string  $culture,
        string  $type_sol,
        float   $ndvi,
        float   $temperature,
        float   $pluviometrie,
        float   $humidite,
        float   $superficie,
        float   $rendement_prevu,
        float   $production_totale,
        ?string $notes  = null,
        $saison = null
    ): string {
        $apiKey = config('services.groq.api_key');

        if (!$apiKey) {
            return 'Recommandations non disponibles — cle GROQ_API_KEY manquante dans .env';
        }

        // Section notes de l'agriculteur
        $notes_section = '';
        if ($notes && strlen(trim($notes)) > 3) {
            $notes_section = "\n📝 OBSERVATIONS DE L'AGRICULTEUR : {$notes}\n(Adresse en priorite les points mentionnes dans ces notes)";
        }

        // Infos saison
        $infos_saison = '';
        if ($saison) {
            $jours = $saison->joursRestants();
            $infos_saison = "\n- Saison : {$saison->nom}"
                . "\n- Periode : {$saison->date_debut->format('d/m/Y')} -> {$saison->date_fin->format('d/m/Y')}"
                . "\n- Jours restants : {$jours} jours";
        }

        $prompt = "Tu es un expert agronome specialise dans l'agriculture au Benin.
Un agriculteur beninois vient de recevoir une prevision de rendement pour sa parcelle.
Voici les donnees reelles de sa parcelle :

🌾 CULTURE : {$culture}
📏 SUPERFICIE : {$superficie} hectares
🪨 TYPE DE SOL : {$type_sol}
🛰️ NDVI (sante vegetation via satellite Sentinel-2) : {$ndvi}
🌡️ TEMPERATURE MOYENNE : {$temperature}°C
🌧️ PLUVIOMETRIE CETTE SEMAINE : {$pluviometrie} mm
💧 HUMIDITE : {$humidite}%
📊 RENDEMENT PREVU : {$rendement_prevu} t/ha
📦 PRODUCTION TOTALE ESTIMEE : {$production_totale} tonnes
{$notes_section}
{$infos_saison}

Donne des recommandations pratiques, claires et simples pour un agriculteur.
Si l'agriculteur a mentionne des problemes specifiques, adresse-les en priorite.
Pour les engrais et pesticides, recommande des produits accessibles au Benin avec doses precises.

Structure ta reponse en 5 sections avec des emojis :
1. 🌱 Analyse de ta parcelle (etat actuel, points forts et faibles)
2. 🧪 Engrais et fertilisants recommandes (doses precises, quand et comment appliquer)
3. 🐛 Maladies et ravageurs a surveiller (avec produits de traitement si necessaire)
4. 🌦️ Conseils selon la meteo et la saison actuelle
5. 🌿 Cultures a associer et conseils de rotation

Sois direct, pratique et bienveillant. Reponds en francais uniquement.";

        try {
            $response = Http::timeout(120)->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'      => 'openai/gpt-oss-120b',
                'messages'   => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => 1500,
            ]);

            if ($response->successful()) {
                return $response->json('choices.0.message.content') ?? 'Recommandations non disponibles.';
            }

            \Log::error('Groq API erreur : ' . $response->status() . ' — ' . $response->body());
            return 'Erreur API Groq (' . $response->status() . '). Veuillez reessayer.';

        } catch (\Exception $e) {
            \Log::error('Groq exception : ' . $e->getMessage());
            return 'Recommandations temporairement indisponibles.';
        }
    }

    // ── METHODE PRINCIPALE DE PREVISION ──────────────
    public function prevoir(Request $request)
    {
        set_time_limit(300);

        $request->validate([
            'parcelle_id' => 'required|exists:parcelles,id',
            'saison_id'   => 'required|exists:saisons,id',
            'annee'       => 'required|integer|min:2000|max:2030',
            'culture'     => 'required|in:Maïs,Riz,Coton,Tomate,Piment,Gombo,Oignon,Niebe,Arachide,Soja,Goussi,Ananas',
            'superficie'  => 'required|numeric|min:0.1|max:100',
            'type_sol'    => 'required|in:argileux,sableux,limoneux,lateritique,ferrugineux,hydromorphe,sale',
            'lat'         => 'required|numeric',
            'lng'         => 'required|numeric',
            'notes'       => 'nullable|string|max:500',
        ]);

        $parcelle   = Parcelle::findOrFail($request->parcelle_id);
        $saison     = Saison::findOrFail($request->saison_id);
        $lat        = floatval($request->lat);
        $lng        = floatval($request->lng);
        $superficie = floatval($request->superficie);
        $buffer     = $this->calculerBuffer($superficie);

        // ── 1. NDVI + METEO ───────────────────────────
        $ndvi  = $this->getNdvi($lat, $lng, $buffer);
        $meteo = $this->getMeteo($lat, $lng);

        // ── 2. ENCODAGE CULTURE ───────────────────────
        $culture_map = [
            'Tomate'   => 0,  'Piment'   => 1,
            'Gombo'    => 2,  'Oignon'   => 3,
            'Niebe'    => 4,  'Arachide' => 5,
            'Soja'     => 6,  'Goussi'   => 7,
            'Ananas'   => 8,  'Coton'    => 9,
            'Maïs'     => 10, 'Riz'      => 11,
        ];

        $type_sol_map = [
            'argileux'    => 0, 'sableux'     => 1,
            'limoneux'    => 2, 'lateritique' => 3,
            'ferrugineux' => 4, 'hydromorphe' => 5,
            'sale'        => 6,
        ];

        $culture_code  = $culture_map[$request->culture]  ?? 0;
        $type_sol_code = $type_sol_map[$request->type_sol] ?? 2;

        // Mois saison selon calendrier Benin
        $mois_saison_map = [
            'Tomate'   => 4,  'Piment'   => 4,
            'Gombo'    => 5,  'Oignon'   => 11,
            'Niebe'    => 5,  'Arachide' => 5,
            'Soja'     => 6,  'Goussi'   => 6,
            'Ananas'   => 4,  'Coton'    => 6,
            'Maïs'     => 5,  'Riz'      => 6,
        ];
        $mois_saison = $mois_saison_map[$request->culture] ?? 5;

        // ── 3. PREVISION VIA SCRIPT PYTHON ────────────
        $scriptPath = storage_path('app/predict.py');

        if (!file_exists($scriptPath)) {
            return back()->with('error', 'Script de prevision introuvable. Contactez l\'administrateur.');
        }

        $command = "py -3.11 " . escapeshellarg($scriptPath)
            . " {$culture_code}"
            . " {$type_sol_code}"
            . " {$request->annee}"
            . " {$ndvi}"
            . " {$mois_saison}"
            . " 2>&1";

        $output = shell_exec($command);
        $data   = json_decode($output, true);

        if (!$data || !isset($data['success']) || !$data['success']) {
            \Log::error('Prevision Python erreur : ' . ($output ?? 'vide'));
            return back()->with('error', 'Erreur lors de la prevision IA. Veuillez reessayer.');
        }

        $rendement_prevu   = round(floatval($data['rendement_prevu']), 3);
        $production_totale = round($rendement_prevu * $superficie, 2);
        $top_features      = $data['top_features'] ?? [];
        $confiance         = $data['confiance'] ?? 75;

        // ── 4. RECOMMANDATIONS GROQ ───────────────────
        $recommandations = $this->getRecommandations(
            $request->culture,
            $request->type_sol,
            $ndvi,
            $meteo['temperature'],
            $meteo['pluviometrie'],
            $meteo['humidite'],
            $superficie,
            $rendement_prevu,
            $production_totale,
            $request->notes ?? $parcelle->notes,
            $saison
        );

        // ── 5. SAUVEGARDE EN BASE ─────────────────────
        $prevision = Prevision::create([
            'user_id'           => auth()->id(),
            'parcelle_id'       => $parcelle->id,
            'saison_id'         => $saison->id,
            'culture'           => $request->culture,
            'superficie'        => $superficie,
            'type_sol'          => $request->type_sol,
            'ndvi'              => $ndvi,
            'temperature'       => $meteo['temperature'],
            'pluviometrie'      => $meteo['pluviometrie'],
            'humidite'          => $meteo['humidite'],
            'annee'             => $request->annee,
            'rendement_prevu'   => $rendement_prevu,
            'production_totale' => $production_totale,
            'confiance'         => $confiance,
            'top_features'      => json_encode($top_features),
            'recommandations'   => $recommandations,
        ]);

        // ── 6. NOTIFICATIONS ──────────────────────────
        if (class_exists(NotificationService::class)) {
            NotificationService::apresPrevision($prevision, auth()->id());
            NotificationService::alerteSaison($saison, auth()->id());
        }

        // ── 7. RETOUR VUE RESULTAT ────────────────────
        return view('previsions.resultat', [
            'prevision'         => $prevision,
            'parcelle'          => $parcelle,
            'saison'            => $saison,
            'culture'           => $request->culture,
            'annee'             => $request->annee,
            'superficie'        => $superficie,
            'type_sol'          => $request->type_sol,
            'rendement_prevu'   => $rendement_prevu,
            'production_totale' => $production_totale,
            'unite'             => $data['unite'] ?? 't/ha',
            'confiance'         => $confiance,
            'top_features'      => $top_features,
            'ndvi'              => $ndvi,
            'temperature'       => $meteo['temperature'],
            'pluviometrie'      => $meteo['pluviometrie'],
            'humidite'          => $meteo['humidite'],
            'lat'               => $lat,
            'lng'               => $lng,
            'recommandations'   => $recommandations,
        ]);
    }

    // ── HISTORIQUE DES PREVISIONS ─────────────────────
    public function historique()
    {
        $previsions = Prevision::with(['parcelle', 'saison'])
            ->whereHas('parcelle', fn($q) => $q->where('user_id', auth()->id()))
            ->latest()
            ->paginate(15);

        return view('previsions.historique', compact('previsions'));
    }

    // ── DETAIL D'UNE PREVISION ────────────────────────
    public function show(Prevision $prevision)
    {
        $this->authorize('view', $prevision);
        return view('previsions.show', compact('prevision'));
    }

    // ── SUPPRIMER UNE PREVISION ───────────────────────
    public function destroy(Prevision $prevision)
    {
        $this->authorize('delete', $prevision);
        $prevision->delete();
        return redirect()->route('previsions.historique')
            ->with('success', 'Prevision supprimee avec succes.');
    }
    // Afficher la page de chargement d'abord
public function chargement(Request $request)
{
    // Valider rapidement les données avant d'afficher le chargement
    $request->validate([
        'parcelle_id' => 'required|exists:parcelles,id',
        'saison_id'   => 'required|exists:saisons,id',
        'annee'       => 'required|integer|min:2000|max:2030',
        'culture' => 'required|in:Tomate,Piment,Gombo,Oignon,Niebe,Arachide,Soja,Goussi,Ananas,Coton,Maïs,Riz',
        'superficie'  => 'required|numeric|min:0.1|max:100',
        'type_sol'    => 'required|in:argileux,sableux,limoneux,lateritique,ferrugineux,hydromorphe',
        'lat'         => 'required|numeric',
        'lng'         => 'required|numeric',
    ]);

    return view('previsions.chargement');
}
}