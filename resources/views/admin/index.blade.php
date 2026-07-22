@extends('layouts.admin')
@section('title', 'Administration')

@section('contenu')
<div class="max-w-7xl mx-auto animate-fade-in">

    <h2 class="text-3xl font-bold text-white mb-8">
        <i class="fas fa-shield-alt text-red-400 mr-3"></i>Administration
    </h2>

    {{-- Stats globales --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="glass rounded-2xl p-5 text-center shadow-lg">
            <div class="text-3xl font-bold text-agri-600">{{ $stats['total_users'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Utilisateurs</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg">
            <div class="text-3xl font-bold text-cyan-600">{{ $stats['total_parcelles'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Parcelles</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg">
            <div class="text-3xl font-bold text-purple-600">{{ $stats['total_previsions'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Prévisions</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg">
            <div class="text-3xl font-bold text-yellow-600">{{ $stats['total_saisons'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Saisons</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg">
            <div class="text-3xl font-bold text-emerald-600">{{ $stats['avg_rendement'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Rdt moyen t/ha</div>
        </div>
        <div class="glass rounded-2xl p-5 text-center shadow-lg">
            <div class="text-3xl font-bold text-red-600">{{ $stats['admins'] }}</div>
            <div class="text-xs text-slate-500 mt-1 font-medium">Admins</div>
        </div>
    </div>

    {{-- Liste des utilisateurs --}}
    <div class="glass rounded-2xl p-8 shadow-xl mb-8">
        <h3 class="text-xl font-bold text-slate-800 mb-6">
            <i class="fas fa-users text-agri-600 mr-2"></i>Gestion des utilisateurs
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-200">
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Utilisateur</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Email</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Parcelles</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Prévisions</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Dernière connexion</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Rôle</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-agri-400 to-cyan-500 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400">Inscrit {{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-slate-500 text-xs">{{ $user->email }}</td>
                        <td class="py-3 px-4 text-center font-bold text-agri-600">{{ $user->parcelles_count }}</td>
                        <td class="py-3 px-4 text-center font-bold text-purple-600">{{ $user->previsions_count }}</td>
                        <td class="py-3 px-4 text-xs text-slate-500">
                            @if($user->last_login_at)
                                {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                            @else
                                <span class="text-slate-300">Jamais</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($user->is_admin)
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                    <i class="fas fa-shield-alt mr-1"></i>Admin
                                </span>
                            @else
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-full text-xs">
                                    Utilisateur
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex gap-2 flex-wrap">
                                {{-- Voir activité --}}
                                <a href="{{ route('admin.show_user', $user) }}"
                                    class="px-2 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg text-xs font-medium transition-colors">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Modifier --}}
                                <a href="{{ route('admin.edit_user', $user) }}"
                                    class="px-2 py-1 bg-agri-100 text-agri-700 hover:bg-agri-200 rounded-lg text-xs font-medium transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if($user->id !== auth()->id())
                                    {{-- Toggle admin --}}
                                    <form method="POST" action="{{ route('admin.toggle', $user) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-2 py-1 rounded-lg text-xs font-medium transition-colors
                                            {{ $user->is_admin ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}">
                                            <i class="fas fa-{{ $user->is_admin ? 'user-minus' : 'user-shield' }}"></i>
                                        </button>
                                    </form>

                                    {{-- Supprimer --}}
                                    <form method="POST" action="{{ route('admin.destroy', $user) }}"
                                        onsubmit="return confirm('Supprimer {{ $user->name }} et toutes ses données ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-2 py-1 bg-red-100 text-red-600 hover:bg-red-200 rounded-lg text-xs font-medium transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Dernières prévisions --}}
    <div class="glass rounded-2xl p-8 shadow-xl">
        <h3 class="text-xl font-bold text-slate-800 mb-6">
            <i class="fas fa-history text-purple-600 mr-2"></i>Dernières prévisions (tous utilisateurs)
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-200">
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Utilisateur</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Parcelle</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Culture</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">NDVI</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Rendement</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Confiance</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Date</th>
                        <th class="text-left py-3 px-4 text-slate-500 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($previsions_recentes as $prev)
                    @php
                        $cBg = $prev->confiance >= 75 ? 'bg-green-100 text-green-700' : ($prev->confiance >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                    @endphp
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-semibold text-slate-700">
                            {{ $prev->user->name ?? '—' }}
                        </td>
                        <td class="py-3 px-4 text-slate-600">
                            {{ $prev->parcelle->nom ?? '—' }}
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $prev->culture === 'Maïs' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                {{ $prev->culture }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-bold text-agri-600">{{ $prev->ndvi }}</td>
                        <td class="py-3 px-4 font-bold">{{ $prev->rendement_prevu }} t/ha</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold {{ $cBg }}">
                                {{ $prev->confiance }}%
                            </span>
                        </td>
                        <td class="py-3 px-4 text-xs text-slate-500">
                            {{ $prev->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="py-3 px-4">
                            <form method="POST" action="{{ route('admin.destroy_prevision', $prev) }}"
                                onsubmit="return confirm('Supprimer cette prévision ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 bg-red-100 text-red-600 hover:bg-red-200 rounded-lg text-xs transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection