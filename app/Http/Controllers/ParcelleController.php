<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcelle;

class ParcelleController extends Controller
{
    public function index()
    {
        $listesparcelles = Parcelle::where('user_id', auth()->id())
            ->with('dernierePrevision')
            ->latest()
            ->get();
        
        return view('parcelles.index', compact('listesparcelles'));
    }

    public function create()
    {
        return view('parcelles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:100',
            'departement' => 'nullable|string|max:100',
            'commune'     => 'nullable|string|max:100',
            'culture'     => 'required|in:Maïs,Riz,Coton,Tomate,Piment,Gombo,Oignon,Niebe,Arachide,Soja,Goussi,Ananas',
            'superficie'  => 'required|numeric|min:0.1|max:100',
            'type_sol' => 'required|in:argileux,sableux,limoneux,lateritique,ferrugineux,hydromorphe,sale',
            'lat'         => 'required|numeric',
            'lng'         => 'required|numeric',
            'notes'       => 'nullable|string|max:500',
        ]);

        Parcelle::create([
            'user_id'     => auth()->id(),
            'nom'         => $request->nom,
            'departement' => $request->departement,
            'commune'     => $request->commune,
            'culture'     => $request->culture,
            'superficie'  => $request->superficie,
            'type_sol'    => $request->type_sol,
            'lat'         => $request->lat,
            'lng'         => $request->lng,
            'notes'       => $request->notes,
        ]);

        return redirect()->route('parcelles.index')->with('success', 'Parcelle ajoutée avec succès.');
    }

    public function edit(Parcelle $parcelle)
    {
        if ($parcelle->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        return view('parcelles.edit', compact('parcelle'));
    }

public function update(Request $request, Parcelle $parcelle)
{
    if ($parcelle->user_id !== auth()->id()) {
        abort(403, 'Accès non autorisé');
    }

    $request->validate([
        'nom'         => 'required|string|max:100',
        'departement' => 'nullable|string|max:100',
        'commune'     => 'nullable|string|max:100',
        'culture'     => 'required|in:Maïs,Riz,Coton,Tomate,Piment,Gombo,Oignon,Niebe,Arachide,Soja,Goussi,Ananas',
        'superficie'  => 'required|numeric|min:0.1|max:100',
        'type_sol'    => 'required|in:argileux,sableux,limoneux,lateritique,ferrugineux,hydromorphe,sale',
        'lat'         => 'required|numeric',
        'lng'         => 'required|numeric',
        'notes'       => 'nullable|string|max:500',
    ]);

    $parcelle->update($request->only([
        'nom', 'departement', 'commune', 'culture',
        'superficie', 'type_sol', 'lat', 'lng', 'notes'
    ]));

    return redirect()->route('parcelles.index')->with('success', 'Parcelle modifiée avec succès.');
}

    public function destroy(Parcelle $parcelle)
    {
        if ($parcelle->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé');
        }
        $parcelle->delete();
        return redirect()->route('parcelles.index')->with('success', 'Parcelle supprimée.');
    }
}