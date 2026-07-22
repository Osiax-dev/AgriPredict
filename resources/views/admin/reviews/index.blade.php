@extends('layouts.admin')
@section('title', 'Modération des avis')

@section('contenu')
<div class="max-w-7xl mx-auto">

    {{-- En-tête --}}
    <div class="mb-8 animate-fade-in">
        <h1 class="text-3xl md:text-4xl font-black text-white mb-2">
            <i class="fas fa-star text-amber-400 mr-2"></i>
            Modération des avis
        </h1>
        <p class="text-white/60">Gérez les avis laissés par les utilisateurs de la plateforme.</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="glass rounded-2xl p-5 hover-lift">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-comments text-2xl text-blue-500"></i>
                <span class="text-xs text-slate-500">Total</span>
            </div>
            <p class="text-3xl font-black text-slate-800">{{ $stats['total'] }}</p>
        </div>
        <div class="glass rounded-2xl p-5 hover-lift">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-check-circle text-2xl text-emerald-500"></i>
                <span class="text-xs text-slate-500">Approuvés</span>
            </div>
            <p class="text-3xl font-black text-emerald-600">{{ $stats['approved'] }}</p>
        </div>
        <div class="glass rounded-2xl p-5 hover-lift">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-clock text-2xl text-amber-500"></i>
                <span class="text-xs text-slate-500">En attente</span>
            </div>
            <p class="text-3xl font-black text-amber-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="glass rounded-2xl p-5 hover-lift">
            <div class="flex items-center justify-between mb-2">
                <i class="fas fa-star text-2xl text-amber-400"></i>
                <span class="text-xs text-slate-500">Moyenne</span>
            </div>
            <p class="text-3xl font-black text-slate-800">{{ $stats['average'] }}/5</p>
        </div>
    </div>

    {{-- Liste des avis --}}
    <div class="glass rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 uppercase">Utilisateur</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 uppercase">Note</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 uppercase">Commentaire</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 uppercase">Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 uppercase">Date</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-slate-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-agri-400 to-cyan-500 flex items-center justify-center text-white font-bold text-xs">
                                        {{ $review->initials }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-800 text-sm">{{ $review->user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $review->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-300' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-4 py-3 max-w-xs">
                                @if($review->culture)
                                    <span class="inline-block px-2 py-0.5 bg-agri-100 text-agri-700 text-xs rounded-full mb-1">
                                        {{ $review->culture }}
                                    </span>
                                @endif
                                <p class="text-sm text-slate-600 line-clamp-2">{{ $review->comment }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @if($review->approved)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">
                                        <i class="fas fa-check text-[10px]"></i> Approuvé
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">
                                        <i class="fas fa-clock text-[10px]"></i> En attente
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-500">
                                {{ $review->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    @if(!$review->approved)
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center transition-colors" title="Approuver">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-amber-500 hover:bg-amber-600 text-white flex items-center justify-center transition-colors" title="Rejeter">
                                                <i class="fas fa-ban text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Supprimer définitivement cet avis ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-500 hover:bg-red-600 text-white flex items-center justify-center transition-colors" title="Supprimer">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center">
                                <i class="fas fa-inbox text-4xl text-slate-300 mb-3 block"></i>
                                <p class="text-slate-500">Aucun avis pour le moment</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($reviews->hasPages())
            <div class="px-4 py-3 border-t border-slate-200">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection