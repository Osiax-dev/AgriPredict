@extends('layouts.admin')
@section('title', 'Activité - ' . $user->name)

@section('contenu')
<div class="max-w-5xl mx-auto animate-fade-in">

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.index') }}" class="text-white/70 hover:text-white transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-3xl font-bold text-white">
            <i class="fas fa-user text-agri-400 mr-3"></i>Activité de {{ $user->name }}
        </h2>
    </div>

    {{-- Infos utilisateur --}}
    <div class="glass rounded-2xl p-6 mb-6 shadow-xl">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Email</p>
                <p class="font-semibold text-slate-800">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Inscrit le</p>
                <p class="font-semibold text-slate-800">{{ $user->created_at->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Dernière connexion</p>
                <p class="font-semibold text-slate-800">
                    {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Jamais' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase mb-1">Rôle</p>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $user->is_admin ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ $user->is_admin ? 'Administrateur' : 'Utilisateur' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="glass rounded-2xl p-5 text-center shadow-lg">
            <div class="text-3xl font-bold text-agri-600">{{ $user->parcelles->count() }}</div>
            <div class="text-xs text-slate-500 mt-1">Parcelles</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg">
            <div class="text-3xl font-bold text-purple-600">{{ $previsions->count() }}</div>
            <div class="text-xs text-slate-500 mt-1">Prévisions</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg">
            <div class="text-3xl font-bold text-cyan-600">{{ round($previsions->avg('rendement_prevu') ?? 0, 2) }}</div>
            <div class="text-xs text-slate-500 mt-1">Rdt moyen t/ha</div>
        </div>
    </div>

    {{-- Parcelles --}}
    <div class="glass rounded-2xl p-6 mb-6 shadow-xl">
        <h3 class="text-lg font-bold text-slate-800 mb-4">
            <i class="fas fa-map-marked-alt text-agri-600 mr-2"></i>Parcelles
        </h3>
        @if($user->parcelles->isEmpty())
            <p class="text-slate-400 text-sm">Aucune parcelle enregistrée.</p>
        @else
            <div class="grid md:grid-cols-2 gap-3">
                @foreach($user->parcelles as $parcelle)
                <div class="bg-agri-50 rounded-xl p-4">
                    <p class="font-semibold text-slate-800">{{ $parcelle->nom }}</p>
                    <p class="text-xs text-slate-500 mt-1">
                        📐 {{ $parcelle->superficie }} ha &nbsp;|&nbsp;
                        🌾 {{ $parcelle->culture ?? '—' }} &nbsp;|&nbsp;
                        📍 {{ $parcelle->commune ?? '—' }}
                    </p>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Prévisions --}}
    <div class="glass rounded-2xl p-6 shadow-xl">
        <h3 class="text-lg font-bold text-slate-800 mb-4">
            <i class="fas fa-history text-purple-600 mr-2"></i>Historique des prévisions
        </h3>
        @if($previsions->isEmpty())
            <p class="text-slate-400 text-sm">Aucune prévision effectuée.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-slate-200">
                            <th class="text-left py-2 px-3 text-slate-500">Parcelle</th>
                            <th class="text-left py-2 px-3 text-slate-500">Culture</th>
                            <th class="text-left py-2 px-3 text-slate-500">NDVI</th>
                            <th class="text-left py-2 px-3 text-slate-500">Rendement</th>
                            <th class="text-left py-2 px-3 text-slate-500">Confiance</th>
                            <th class="text-left py-2 px-3 text-slate-500">Date</th>
                            <th class="text-left py-2 px-3 text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($previsions as $prev)
                        @php
                            $cBg = $prev->confiance >= 75 ? 'bg-green-100 text-green-700' : ($prev->confiance >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <tr class="border-b border-slate-100 hover:bg-slate-50">
                            <td class="py-2 px-3 font-semibold">{{ $prev->parcelle->nom ?? '—' }}</td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $prev->culture === 'Maïs' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $prev->culture }}
                                </span>
                            </td>
                            <td class="py-2 px-3 font-bold text-agri-600">{{ $prev->ndvi }}</td>
                            <td class="py-2 px-3 font-bold">{{ $prev->rendement_prevu }} t/ha</td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-1 rounded-full text-xs font-bold {{ $cBg }}">{{ $prev->confiance }}%</span>
                            </td>
                            <td class="py-2 px-3 text-xs text-slate-500">{{ $prev->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-2 px-3">
                                <form method="POST" action="{{ route('admin.destroy_prevision', $prev) }}"
                                    onsubmit="return confirm('Supprimer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 bg-red-100 text-red-600 hover:bg-red-200 rounded-lg text-xs">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection