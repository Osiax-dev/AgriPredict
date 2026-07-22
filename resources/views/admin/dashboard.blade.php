@extends('layouts.admin')
@section('title', 'Tableau de bord Admin')

@section('contenu')
<div class="max-w-6xl mx-auto animate-fade-in">

    <h2 class="text-3xl font-bold text-white mb-2">
        <i class="fas fa-shield-alt text-red-400 mr-3"></i>Tableau de bord Admin
    </h2>
    <p class="text-white/60 mb-8">Bienvenue, {{ auth()->user()->name }}</p>

    {{-- Stats globales --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="glass rounded-2xl p-5 text-center shadow-lg border-l-4 border-agri-500">
            <div class="text-3xl font-bold text-agri-600">{{ $stats['total_users'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Utilisateurs</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg border-l-4 border-cyan-500">
            <div class="text-3xl font-bold text-cyan-600">{{ $stats['total_parcelles'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Parcelles</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg border-l-4 border-purple-500">
            <div class="text-3xl font-bold text-purple-600">{{ $stats['total_previsions'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Prévisions</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg border-l-4 border-yellow-500">
            <div class="text-3xl font-bold text-yellow-600">{{ $stats['total_saisons'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Saisons</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg border-l-4 border-emerald-500">
            <div class="text-3xl font-bold text-emerald-600">{{ $stats['avg_rendement'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Rdt moyen t/ha</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg border-l-4 border-red-500">
            <div class="text-3xl font-bold text-red-600">{{ $stats['admins'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Admins</div>
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <a href="{{ route('admin.index') }}" class="glass p-6 rounded-2xl flex items-center gap-4 hover-lift group">
            <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl group-hover:bg-red-600 group-hover:text-white transition-all">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800">Gérer les utilisateurs</p>
                <p class="text-sm text-slate-500">Voir, modifier, supprimer les comptes</p>
            </div>
        </a>
        <a href="{{ route('admin.index') }}#previsions" class="glass p-6 rounded-2xl flex items-center gap-4 hover-lift group">
            <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition-all">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800">Toutes les prévisions</p>
                <p class="text-sm text-slate-500">Consulter l'activité des utilisateurs</p>
            </div>
        </a>
    </div>

{{-- Dernières prévisions --}}
<div class="glass rounded-2xl p-8 shadow-xl">
    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">
        <i class="fas fa-history text-purple-600 dark:text-purple-400 mr-2"></i>Activité récente
    </h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-slate-200 dark:border-slate-700">
                    <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-400 font-semibold">Utilisateur</th>
                    <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-400 font-semibold">Parcelle</th>
                    <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-400 font-semibold">Culture</th>
                    <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-400 font-semibold">Rendement</th>
                    <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-400 font-semibold">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($previsions_recentes as $prev)
                <tr class="border-b border-slate-100 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/50">
                    <td class="py-3 px-4 font-semibold text-slate-800 dark:text-slate-100">{{ $prev->user->name ?? '—' }}</td>
                    <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $prev->parcelle->nom ?? '—' }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $prev->culture === 'Maïs' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-300' : 'bg-green-100 text-green-700 dark:bg-green-500/20 dark:text-green-300' }}">
                            {{ $prev->culture }}
                        </span>
                    </td>
                    <td class="py-3 px-4 font-bold text-agri-600 dark:text-agri-400">{{ $prev->rendement_prevu }} t/ha</td>
                    <td class="py-3 px-4 text-xs text-slate-500 dark:text-slate-400">{{ $prev->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection