<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Saison;
use App\Models\Parcelle;
use App\Services\SaisonService;

class SaisonController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $query = Saison::with('parcelle');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $listessaisons = $query->latest()->get();
        return view('saisons.index', compact('listessaisons'));
    }

    public function create()
    {
        $userId = auth()->id();
        $query = Parcelle::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $parcelles = $query->latest()->get();
        return view('saisons.create', compact('parcelles'));
    }

    /**
     * Retourne les infos de saison (région, type, campagne, météo)
     * pour une parcelle donnée, en AJAX, pour pré-remplir le formulaire.
     */
    public function infosParcelle(Parcelle $parcelle, SaisonService $saisonService)
    {
        if (auth()->id() && $parcelle->user_id !== auth()->id()) {
            abort(403);
        }

        $infos = $saisonService->analyser(
            $parcelle->departement,
            $parcelle->lat,
            $parcelle->lng
        );

        return response()->json($infos);
    }

    public function store(Request $request, SaisonService $saisonService)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'culture' => 'nullable|string|max:255',
            'parcelle_id' => 'nullable|exists:parcelles,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'parcelle_id' => $request->parcelle_id,
            'nom' => $request->nom,
            'culture' => $request->culture,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ];

        // Auto-détection région/saison/météo si une parcelle est associée
        if ($request->parcelle_id) {
            $parcelle = Parcelle::find($request->parcelle_id);

            if ($parcelle && $parcelle->user_id === auth()->id()) {
                $infos = $saisonService->analyser(
                    $parcelle->departement,
                    $parcelle->lat,
                    $parcelle->lng
                );

                $data['region'] = $infos['region'];
                $data['type_saison'] = $infos['type_saison'];
                $data['campagne'] = $infos['campagne'];
                $data['pluies_confirmees'] = $infos['pluies_confirmees'];
                $data['cumul_pluies_mm'] = $infos['cumul_pluies_mm'];
            }
        }

        $saison = Saison::create($data);

        return redirect()
            ->route('saisons.index')
            ->with('success', 'Saison enregistrée avec succès.');
    }

    public function edit(Saison $saison)
    {
        if (auth()->id() && $saison->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        return view('saisons.edit', compact('saison'));
    }

    public function update(Request $request, Saison $saison)
    {
        if (auth()->id() && $saison->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'nom'        => 'required|string|max:100',
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after:date_debut',
        ]);

        $saison->update($request->only(['nom', 'date_debut', 'date_fin']));

        return redirect()->route('saisons.index')->with('success', 'Saison modifiée avec succès.');
    }

    public function destroy(Saison $saison)
    {
        if (auth()->id() && $saison->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        $saison->delete();
        return redirect()->route('saisons.index')->with('success', 'Saison supprimée.');
    }
}