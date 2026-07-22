@extends('layouts.app')
@section('title', 'Notifications')

@section('contenu')
<div class="max-w-3xl mx-auto animate-fade-in">

    <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold text-white">
            <i class="fas fa-bell text-agri-400 mr-3"></i>Notifications
        </h2>
        @if($notifications->isNotEmpty())
        <form method="POST" action="{{ route('notifications.vider') }}"
            onsubmit="return confirm('Supprimer toutes les notifications ?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="px-4 py-2 bg-red-500/20 text-red-300 hover:bg-red-500/30 rounded-xl text-sm font-medium transition-all border border-red-500/30">
                <i class="fas fa-trash mr-2"></i>Tout supprimer
            </button>
        </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="glass rounded-2xl p-16 text-center shadow-xl">
            <i class="fas fa-bell-slash text-5xl text-slate-300 mb-4 block"></i>
            <p class="text-slate-500 text-lg">Aucune notification pour le moment.</p>
            <p class="text-slate-400 text-sm mt-2">Les alertes apparaîtront ici après vos prévisions.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($notifications as $notif)
            @php
                $colors = [
                    'success' => ['bg' => 'bg-emerald-50 border-emerald-200', 'icon' => 'text-emerald-600', 'badge' => 'bg-emerald-100 text-emerald-700'],
                    'warning' => ['bg' => 'bg-yellow-50 border-yellow-200',  'icon' => 'text-yellow-600',  'badge' => 'bg-yellow-100 text-yellow-700'],
                    'danger'  => ['bg' => 'bg-red-50 border-red-200',        'icon' => 'text-red-600',     'badge' => 'bg-red-100 text-red-700'],
                    'info'    => ['bg' => 'bg-blue-50 border-blue-200',      'icon' => 'text-blue-600',    'badge' => 'bg-blue-100 text-blue-700'],
                ];
                $c = $colors[$notif->type] ?? $colors['info'];
            @endphp
            <div class="glass rounded-2xl p-5 shadow-lg border {{ $notif->lu ? 'opacity-60' : '' }} transition-all">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl {{ $c['badge'] }} flex items-center justify-center flex-shrink-0">
                        <i class="fas {{ $notif->icone }} {{ $c['icon'] }}"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-bold text-slate-800 text-sm">{{ $notif->titre }}</p>
                                <p class="text-slate-600 text-sm mt-1 leading-relaxed">{{ $notif->message }}</p>
                                <p class="text-slate-400 text-xs mt-2">
                                    <i class="fas fa-clock mr-1"></i>{{ $notif->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @if(!$notif->lu)
                                    <span class="w-2 h-2 rounded-full bg-agri-500"></span>
                                @endif
                                @if($notif->lien)
                                    <a href="{{ $notif->lien }}"
                                        class="px-3 py-1 bg-agri-100 text-agri-700 hover:bg-agri-200 rounded-lg text-xs font-medium transition-colors">
                                        Voir →
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection