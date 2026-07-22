@extends('layouts.app')
@section('title', 'Modifier la saison')

@section('contenu')
<div class="max-w-2xl mx-auto animate-slide-up">
    <div class="glass rounded-2xl p-8 shadow-xl">
        <h2 class="text-2xl font-bold text-slate-800 mb-2"><i class="fas fa-edit text-cyan-600 mr-2"></i>Modifier la saison</h2>
        <p class="text-slate-500 mb-6">{{ $saison->nom }}</p>

        @if($saison->region)
        <div class="mb-6 p-4 rounded-xl bg-agri-50 border border-agri-200 text-sm">
            <div class="flex items-center gap-2 text-agri-700 font-semibold mb-1">
                <i class="fas fa-cloud-sun-rain"></i>
                {{ $saison->region === 'nord' ? ' Région Nord' : ' Région Sud' }}
            </div>
            <p class="text-slate-600">
                {{ str_replace('_', ' ', ucfirst($saison->type_saison)) }}
                @if($saison->campagne) · {{ str_replace('_', ' ', $saison->campagne) }} @endif
            </p>
            @if(!is_null($saison->pluies_confirmees))
                <p class="text-slate-500 text-xs mt-1">
                    {{ $saison->pluies_confirmees ? '✅ Pluies confirmées' : '⚠️ Pluies non confirmées' }}
                    @if($saison->cumul_pluies_mm) ({{ $saison->cumul_pluies_mm }} mm sur 15 jours) @endif
                </p>
            @endif
        </div>
        @endif

        <form method="POST" action="{{ route('saisons.update', $saison) }}">
            @csrf @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nom de la saison</label>
                <input type="text" name="nom" value="{{ old('nom', $saison->nom) }}" class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all">
                @error('nom') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">📅 Date de début</label>
                    <input type="date" name="date_debut" value="{{ old('date_debut', $saison->date_debut->format('Y-m-d')) }}" class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all">
                    @error('date_debut') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">📅 Date de fin</label>
                    <input type="date" name="date_fin" value="{{ old('date_fin', $saison->date_fin->format('Y-m-d')) }}" class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all">
                    @error('date_fin') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-xl shadow-lg shadow-agri-500/30 transition-all">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('saisons.index') }}" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-all text-center">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection