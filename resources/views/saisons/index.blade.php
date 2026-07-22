@extends('layouts.app')
@section('title', 'Mes Saisons')

@section('contenu')
<div class="max-w-4xl mx-auto animate-slide-up">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-white mb-1"><i class="fas fa-calendar-alt text-cyan-400 mr-3"></i>Mes Saisons</h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 text-white text-sm font-semibold">
                {{ $listessaisons->count() }} saisons
            </span>
        </div>
        <a href="{{ route('saisons.create') }}" class="px-6 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-semibold rounded-xl shadow-lg shadow-agri-500/30 transition-all duration-300 flex items-center gap-2 hover-lift">
            <i class="fas fa-plus"></i> Nouvelle Saison
        </a>
    </div>

    @if($listessaisons->isEmpty())
        <div class="glass rounded-2xl p-12 text-center">
            <i class="fas fa-calendar text-6xl text-cyan-300 mb-4"></i>
            <p class="text-slate-600 text-lg mb-4">Aucune saison enregistrée.</p>
            <a href="{{ route('saisons.create') }}" class="text-agri-600 font-semibold hover:text-agri-700">Ajouter votre première saison →</a>
        </div>
    @else
        @foreach($listessaisons as $saison)
            @php
                $today = now();
                $debut = $saison->date_debut;
                $fin = $saison->date_fin;
                $enCours = $today >= $debut && $today <= $fin;
                $termine = $today > $fin;
                $joursEcoules = $saison->joursEcoules();
                $joursRestants = $saison->joursRestants();
                $duree = $debut->diffInDays($fin);
                $progression = $duree > 0 ? min(100, round($joursEcoules / $duree * 100)) : 0;
            @endphp
            <div class="glass rounded-2xl p-6 shadow-xl mb-4 hover-lift">
                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $saison->nom }}</h3>
                        <div class="text-sm text-slate-500">
                            <i class="fas fa-calendar-day mr-1"></i> {{ $debut->format('d/m/Y') }} → {{ $fin->format('d/m/Y') }}
                        </div>
                    </div>
                    <span class="px-4 py-1.5 rounded-full text-xs font-bold {{ $enCours ? 'bg-agri-100 text-agri-700' : ($termine ? 'bg-slate-100 text-slate-600' : 'bg-amber-100 text-amber-700') }}">
                        {{ $enCours ? '🟢 En cours' : ($termine ? '✅ Terminée' : '🟡 À venir') }}
                    </span>
                </div>

                @if($enCours)
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-slate-500 mb-2">
                            <span>{{ $joursEcoules }} jours écoulés</span>
                            <span>{{ $joursRestants }} jours restants</span>
                        </div>
                        <div class="bg-slate-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-agri-500 to-cyan-500 h-2 rounded-full" style="width: {{ $progression }}%"></div>
                        </div>
                        <div class="text-xs text-agri-600 mt-1 text-right font-semibold">{{ $progression }}% de la saison écoulée</div>
                    </div>
                @endif

                <div class="flex gap-2">
<a href="{{ route('saisons.edit', $saison) }}" 
   class="px-4 py-2 bg-green-100 hover:bg-green-200 
          dark:bg-green-700 dark:hover:bg-green-600 
          text-green-800 dark:text-white 
          rounded-lg text-sm font-semibold transition-colors">
    ✏️ Modifier
</a>
                    <form method="POST" action="{{ route('saisons.destroy', $saison) }}" onsubmit="return confirm('Supprimer cette saison ?')" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-semibold transition-colors">
                            🗑️ Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection