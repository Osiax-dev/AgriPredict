@extends('layouts.app')
@section('title', 'Mes Parcelles')

@section('contenu')
<div class="max-w-6xl mx-auto animate-slide-up">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-white mb-1">
                <i class="fas fa-map-marked-alt text-agri-400 mr-3"></i>Mes Parcelles
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white text-sm font-semibold">
                {{ $listesparcelles->count() }} parcelles
            </span>
        </div>
        <a href="{{ route('parcelles.create') }}" class="px-6 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-semibold rounded-xl shadow-lg shadow-agri-500/30 transition-all duration-300 flex items-center gap-2 hover-lift">
            <i class="fas fa-plus"></i> Nouvelle Parcelle
        </a>
    </div>

    @if($listesparcelles->isEmpty())
        <div class="glass rounded-2xl p-12 text-center">
            <i class="fas fa-seedling text-6xl text-agri-300 dark:text-agri-600 mb-4"></i>
            <p class="text-slate-600 dark:text-slate-300 text-lg mb-4">Aucune parcelle enregistrée</p>
            <a href="{{ route('parcelles.create') }}" class="text-agri-600 dark:text-agri-400 font-semibold hover:text-agri-700 dark:hover:text-agri-300">
                Ajouter votre première parcelle →
            </a>
        </div>
    @else
        <div class="glass rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-agri-50 to-cyan-50 dark:from-slate-800 dark:to-slate-700 border-b-2 border-agri-200 dark:border-slate-600">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">#</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Nom</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Culture</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Superficie</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Localisation</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Type de Sol</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-slate-600 dark:text-slate-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listesparcelles as $i => $parcelle)
@php
$cultureBg = 'bg-green-500/20 text-green-800 dark:bg-green-500/30 dark:text-green-100';    $cultureIcon = '🌱';
@endphp
                            <tr class="border-b border-slate-100 dark:border-slate-700 hover:bg-agri-50/50 dark:hover:bg-slate-800/50 transition-colors {{ $i % 2 == 0 ? '' : 'bg-slate-50/50 dark:bg-slate-800/30' }}">
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400 font-semibold">
#{{ $loop->iteration }}                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-100">
                                    {{ $parcelle->nom }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full {{ $cultureBg }} text-xs font-semibold">
                                        {{ $cultureIcon }} {{ $parcelle->culture }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                    {{ $parcelle->superficie }} ha
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300 text-sm">
                                    {{ $parcelle->commune ?? '—' }}
                                    @if($parcelle->departement)
                                        <br><span class="text-slate-400 dark:text-slate-500">{{ $parcelle->departement }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                    {{ ucfirst($parcelle->type_sol) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2 justify-center">
                                        <a href="{{ route('parcelles.edit', $parcelle) }}" 
                                            class="px-3 py-1.5 bg-agri-100 hover:bg-agri-200 dark:bg-agri-900/30 dark:hover:bg-agri-900/50 text-agri-700 dark:text-agri-300 rounded-lg text-xs font-semibold transition-colors">
                                            ✏️ Modifier
                                        </a>
                                        <form method="POST" action="{{ route('parcelles.destroy', $parcelle) }}" onsubmit="return confirm('Supprimer cette parcelle ?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-700 dark:text-red-300 rounded-lg text-xs font-semibold transition-colors">
                                                🗑️ Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection