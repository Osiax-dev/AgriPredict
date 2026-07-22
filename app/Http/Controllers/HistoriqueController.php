<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prevision;
use App\Models\Parcelle;

class HistoriqueController extends Controller
{
    public function index(Request $request)
    {
        $query = Prevision::with(['parcelle', 'saison'])
            ->whereHas('parcelle', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->latest();

        // Filtre par culture
        if ($request->culture) {
            $query->where('culture', $request->culture);
        }

        // Filtre par parcelle
        if ($request->parcelle_id) {
            $query->where('parcelle_id', $request->parcelle_id);
        }

        $previsions = $query->get();

        $parcelles = Parcelle::where('user_id', auth()->id())->get();

        // Récupération automatique de toutes les cultures présentes
        // pour le graphique
        $cultures = $previsions
            ->pluck('culture')
            ->unique()
            ->values();

        return view('previsions.historique', compact(
            'previsions',
            'parcelles',
            'cultures'
        ));
    }


    public function show(Prevision $prevision)
    {
        if ($prevision->parcelle->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $prevision->load(['parcelle', 'saison']);

        return view('previsions.resultat', [
            'parcelle'          => $prevision->parcelle,
            'saison'            => $prevision->saison,
            'culture'           => $prevision->culture,
            'annee'             => $prevision->created_at->year,
            'superficie'        => $prevision->parcelle->superficie,
            'type_sol'          => $prevision->parcelle->type_sol,
            'rendement_prevu'   => $prevision->rendement_prevu,
            'production_totale' => $prevision->production_totale,
            'unite'             => 't/ha',
            'confiance'         => $prevision->confiance,
            'top_features'      => $prevision->top_features ?? [],
            'ndvi'              => $prevision->ndvi,
            'temperature'       => $prevision->temperature,
            'pluviometrie'      => $prevision->pluviometrie,
            'humidite'          => $prevision->humidite,
            'lat'               => $prevision->parcelle->lat,
            'lng'               => $prevision->parcelle->lng,
            'recommandations'   => $prevision->recommandations,
        ]);
    }
}