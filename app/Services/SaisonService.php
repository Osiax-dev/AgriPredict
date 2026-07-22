<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class SaisonService
{
    protected array $departementsNord = ['Alibori', 'Atacora', 'Borgou', 'Donga'];

    /**
     * Détermine si un département est au Nord ou au Sud
     */
    public function region(string $departement): string
    {
        return in_array($departement, $this->departementsNord) ? 'nord' : 'sud';
    }

    /**
     * Détermine le type de saison + campagne en fonction du département et de la date
     */
    public function saisonActuelle(string $departement, ?Carbon $date = null): array
    {
        $date = $date ?? Carbon::now();
        $region = $this->region($departement);
        $mois = (int) $date->format('n');

        if ($region === 'nord') {
            $enSaisonDesPluies = $mois >= 4 && $mois <= 10;

            return [
                'region' => 'nord',
                'type_saison' => $enSaisonDesPluies ? 'saison_pluies' : 'saison_seche',
                'campagne' => 'unique',
            ];
        }

        // Sud : régime bimodal à 4 saisons
        if ($mois >= 3 && $mois <= 7) {
            $type = 'grande_saison_pluies';
            $campagne = '1ere_campagne';
        } elseif ($mois == 8 || $mois == 9) {
            $type = 'petite_saison_seche';
            $campagne = 'transition';
        } elseif ($mois >= 9 && $mois <= 10) {
            $type = 'petite_saison_pluies';
            $campagne = '2eme_campagne';
        } else {
            $type = 'grande_saison_seche';
            $campagne = 'hors_saison';
        }

        return [
            'region' => 'sud',
            'type_saison' => $type,
            'campagne' => $campagne,
        ];
    }

    /**
     * Vérifie via Open-Meteo si les pluies ont réellement démarré
     * (cumul des 15 derniers jours sur la position donnée)
     */
    public function pluiesOntDemarre(float $lat, float $lng): array
    {
        $dateDebut = Carbon::now()->subDays(15)->format('Y-m-d');
        $dateFin = Carbon::now()->format('Y-m-d');

        try {
            $response = Http::timeout(10)->get('https://archive-api.open-meteo.com/v1/archive', [
                'latitude' => $lat,
                'longitude' => $lng,
                'start_date' => $dateDebut,
                'end_date' => $dateFin,
                'daily' => 'precipitation_sum',
                'timezone' => 'Africa/Porto-Novo',
            ]);

            if (!$response->successful()) {
                return ['confirmees' => false, 'cumul_mm' => null];
            }

            $data = $response->json();
            $cumul = array_sum($data['daily']['precipitation_sum'] ?? []);

            return [
                'confirmees' => $cumul >= 20,
                'cumul_mm' => round($cumul, 2),
            ];
        } catch (\Exception $e) {
            return ['confirmees' => false, 'cumul_mm' => null];
        }
    }

    /**
     * Analyse complète : région + saison calendaire + confirmation météo
     */
    public function analyser(string $departement, ?float $lat = null, ?float $lng = null): array
    {
        $base = $this->saisonActuelle($departement);

        $base['pluies_confirmees'] = null;
        $base['cumul_pluies_mm'] = null;

        if ($lat && $lng && str_contains($base['type_saison'], 'pluies')) {
            $meteo = $this->pluiesOntDemarre($lat, $lng);
            $base['pluies_confirmees'] = $meteo['confirmees'];
            $base['cumul_pluies_mm'] = $meteo['cumul_mm'];
        }

        return $base;
    }
}