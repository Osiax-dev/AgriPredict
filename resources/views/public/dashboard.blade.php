@extends('layouts.app')
@section('title', 'Tableau de Bord')

@section('contenu')

{{-- Bannière NDVI --}}
<div class="glass rounded-xl p-3 mb-6 shadow-lg">
    <div class="flex items-center gap-2 mb-2">
        <i class="fas fa-satellite text-agri-600 text-xs"></i>
        <span class="text-xs font-bold text-slate-700 dark:text-slate-200">Guide NDVI Sentinel-2</span>
        <span class="ml-auto text-xs font-mono text-slate-400">(NIR−Rouge)/(NIR+Rouge)</span>
    </div>
    <div class="flex gap-1">
        <div class="flex-1 rounded-lg p-2 bg-blue-50 dark:bg-blue-900/30 text-center border border-blue-100 dark:border-blue-700">
            <div class="h-1.5 rounded-full bg-blue-400 mb-1"></div>
            <p class="text-xs font-bold text-blue-600 dark:text-blue-300">-1 à 0</p>
            <p class="text-xs text-slate-400">Eau</p>
        </div>
        <div class="flex-1 rounded-lg p-2 bg-slate-50 dark:bg-slate-700/30 text-center border border-slate-100 dark:border-slate-600">
            <div class="h-1.5 rounded-full bg-slate-400 mb-1"></div>
            <p class="text-xs font-bold text-slate-500 dark:text-slate-300">0 à 0.2</p>
            <p class="text-xs text-slate-400">Sol nu</p>
        </div>
        <div class="flex-1 rounded-lg p-2 bg-yellow-50 dark:bg-yellow-900/30 text-center border border-yellow-100 dark:border-yellow-700">
            <div class="h-1.5 rounded-full bg-yellow-400 mb-1"></div>
            <p class="text-xs font-bold text-yellow-600 dark:text-yellow-300">0.2 à 0.4</p>
            <p class="text-xs text-slate-400">Sparse</p>
        </div>
        <div class="flex-1 rounded-lg p-2 bg-lime-50 dark:bg-lime-900/30 text-center border border-lime-100 dark:border-lime-700">
            <div class="h-1.5 rounded-full bg-lime-400 mb-1"></div>
            <p class="text-xs font-bold text-lime-600 dark:text-lime-300">0.4 à 0.6</p>
            <p class="text-xs text-slate-400">Modéré</p>
        </div>
        <div class="flex-1 rounded-lg p-2 bg-green-50 dark:bg-green-900/30 text-center border border-green-100 dark:border-green-700">
            <div class="h-1.5 rounded-full bg-green-500 mb-1"></div>
            <p class="text-xs font-bold text-green-600 dark:text-green-300">0.6 à 1.0</p>
            <p class="text-xs text-slate-400">Sain</p>
        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto animate-fade-in">
    <h2 class="text-3xl font-bold text-white mb-8">
        <i class="fas fa-chart-line text-agri-400 mr-3"></i>Tableau de Bord
    </h2>

    {{-- Cartes statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="glass rounded-2xl p-6 shadow-lg border-l-4 border-agri-500">
            <p class="text-slate-500 dark:text-slate-300 text-sm font-semibold uppercase tracking-wide">Mes Parcelles</p>
            <p class="text-4xl font-bold text-slate-800 dark:text-white mt-1">{{ $stats['parcelles_count'] }}</p>
        </div>
        <div class="glass rounded-2xl p-6 shadow-lg border-l-4 border-cyan-500">
            <p class="text-slate-500 dark:text-slate-300 text-sm font-semibold uppercase tracking-wide">Prévisions IA</p>
            <p class="text-4xl font-bold text-slate-800 dark:text-white mt-1">{{ $stats['previsions_count'] }}</p>
        </div>
        <div class="glass rounded-2xl p-6 shadow-lg border-l-4 border-yellow-500">
            <p class="text-slate-500 dark:text-slate-300 text-sm font-semibold uppercase tracking-wide">Rendement Moyen</p>
            <p class="text-4xl font-bold text-slate-800 dark:text-white mt-1">{{ number_format($stats['avg_rendement'], 2) }}</p>
            <p class="text-xs text-slate-400 dark:text-slate-400 mt-1">t/ha</p>
        </div>
        <div class="glass rounded-2xl p-6 shadow-lg border-l-4 border-purple-500">
            <p class="text-slate-500 dark:text-slate-300 text-sm font-semibold uppercase tracking-wide">Production Totale</p>
            <p class="text-4xl font-bold text-slate-800 dark:text-white mt-1">{{ number_format($stats['production_totale'] ?? 0, 1) }}</p>
            <p class="text-xs text-slate-400 dark:text-slate-400 mt-1">tonnes</p>
        </div>
    </div>

    {{-- Graphique --}}
    <div class="glass rounded-2xl p-8 shadow-xl mb-8">
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Évolution des dernières prévisions</h3>
        <div style="height:280px;" id="chart-container">
            @if($previsions->isNotEmpty())
                <canvas id="dashboardChart"></canvas>
            @else
                <div class="flex items-center justify-center h-full">
                    <div class="text-center text-slate-400">
                        <i class="fas fa-chart-line text-5xl mb-4 block opacity-30"></i>
                        <p class="text-lg">Aucune prévision encore.</p>
                        <a href="{{ route('formulaire') }}" class="text-agri-600 font-semibold mt-2 block hover:text-agri-700">
                            Lancez votre première analyse →
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Tableau dernières prévisions --}}
    @if($previsions->isNotEmpty())
    <div class="glass rounded-2xl p-8 shadow-xl mb-8">
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6">Dernières prévisions</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b-2 border-slate-200 dark:border-slate-600">
                        <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-300 font-semibold">Parcelle</th>
                        <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-300 font-semibold">Culture</th>
                        <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-300 font-semibold">NDVI</th>
                        <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-300 font-semibold">Rendement</th>
                        <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-300 font-semibold">Confiance</th>
                        <th class="text-left py-3 px-4 text-slate-500 dark:text-slate-300 font-semibold">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($previsions as $prev)
@php
    $confiance = $prev->confiance;

    $cStyle = $confiance >= 75
        ? 'background:rgba(34,197,94,0.15); color:#16a34a;'
        : ($confiance >= 50
            ? 'background:rgba(234,179,8,0.15); color:#ca8a04;'
            : 'background:rgba(239,68,68,0.15); color:#dc2626;');

    $cultures_config = [
        'Tomate'   => ['style' => 'background:rgba(239,68,68,0.15);color:#dc2626;',    'icon' => '🍅'],
        'Piment'   => ['style' => 'background:rgba(249,115,22,0.15);color:#ea580c;',   'icon' => '🌶️'],
        'Gombo'    => ['style' => 'background:rgba(34,197,94,0.15);color:#16a34a;',    'icon' => '🌿'],
        'Oignon'   => ['style' => 'background:rgba(168,85,247,0.15);color:#9333ea;',   'icon' => '🧅'],
        'Niébé'    => ['style' => 'background:rgba(132,204,22,0.15);color:#65a30d;',   'icon' => '🫘'],
        'Arachide' => ['style' => 'background:rgba(245,158,11,0.15);color:#d97706;',   'icon' => '🥜'],
        'Soja'     => ['style' => 'background:rgba(234,179,8,0.15);color:#ca8a04;',    'icon' => '🌱'],
        'Goussi'   => ['style' => 'background:rgba(20,184,166,0.15);color:#0d9488;',   'icon' => '🎃'],
        'Ananas'   => ['style' => 'background:rgba(251,191,36,0.15);color:#b45309;',   'icon' => '🍍'],
        'Coton'    => ['style' => 'background:rgba(100,116,139,0.15);color:#94a3b8;',  'icon' => '☁️'],
    ];
    $cfg = $cultures_config[$prev->culture] ?? ['style' => 'background:rgba(107,114,128,0.15);color:#6b7280;', 'icon' => '🌾'];
@endphp
                    <tr class="border-b border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="py-3 px-4 font-semibold text-slate-800 dark:text-white">
                            {{ $prev->parcelle->nom ?? '—' }}
                            @if($prev->parcelle && $prev->parcelle->commune)
                                <span class="block text-xs text-slate-400 dark:text-slate-400 font-normal">{{ $prev->parcelle->commune }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            {{-- Culture --}}
<span class="px-2 py-1 rounded-full text-xs font-semibold" style="{{ $cfg['style'] }}">
    {{ $cfg['icon'] }} {{ $prev->culture }}
</span>
                        </td>
                        <td class="py-3 px-4 font-bold text-agri-600 dark:text-agri-400">{{ $prev->ndvi }}</td>
                        <td class="py-3 px-4 font-bold text-slate-800 dark:text-white">{{ $prev->rendement_prevu }} t/ha</td>
                        <td class="py-3 px-4">
                            {{-- Confiance --}}
<span class="px-2 py-1 rounded-full text-xs font-bold" style="{{ $cStyle }}">
    {{ $prev->confiance }}%
</span>
                        </td>
                        <td class="py-3 px-4 text-slate-500 dark:text-slate-400 text-xs">
                            {{ $prev->created_at->format('d/m/Y') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Actions rapides --}}
    <div class="grid md:grid-cols-2 gap-6">
        <a href="{{ route('formulaire') }}" class="glass p-6 rounded-2xl flex items-center gap-4 hover-lift group">
            <div class="w-12 h-12 rounded-xl bg-agri-100 dark:bg-agri-900/50 text-agri-600 dark:text-agri-300 flex items-center justify-center text-xl group-hover:bg-agri-600 group-hover:text-white transition-all">
                <i class="fas fa-brain"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800 dark:text-white">Nouvelle analyse</p>
                <p class="text-sm text-slate-500 dark:text-slate-300">Lancer une prévision par satellite</p>
            </div>
        </a>
        <a href="{{ route('parcelles.create') }}" class="glass p-6 rounded-2xl flex items-center gap-4 hover-lift group">
            <div class="w-12 h-12 rounded-xl bg-cyan-100 dark:bg-cyan-900/50 text-cyan-600 dark:text-cyan-300 flex items-center justify-center text-xl group-hover:bg-cyan-600 group-hover:text-white transition-all">
                <i class="fas fa-plus"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800 dark:text-white">Ajouter une parcelle</p>
                <p class="text-sm text-slate-500 dark:text-slate-300">Enregistrer un nouveau terrain</p>
            </div>
        </a>
        <a href="{{ route('saisons.create') }}" class="glass p-6 rounded-2xl flex items-center gap-4 hover-lift group">
            <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900/50 text-yellow-600 dark:text-yellow-300 flex items-center justify-center text-xl group-hover:bg-yellow-600 group-hover:text-white transition-all">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800 dark:text-white">Nouvelle saison</p>
                <p class="text-sm text-slate-500 dark:text-slate-300">Définir une période de culture</p>
            </div>
        </a>
        <a href="{{ route('historique.index') }}" class="glass p-6 rounded-2xl flex items-center gap-4 hover-lift group">
            <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-300 flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition-all">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800 dark:text-white">Historique</p>
                <p class="text-sm text-slate-500 dark:text-slate-300">Voir toutes les prévisions</p>
            </div>
        </a>
    </div>
</div>

@push('scripts')
<script>
@if($previsions->isNotEmpty())
const isDark    = document.getElementById('html-root').classList.contains('dark');
const textColor = isDark ? '#e2e8f0' : '#475569';
const gridColor = isDark ? 'rgba(255,255,255,0.07)' : 'rgba(0,0,0,0.05)';

const ctx  = document.getElementById('dashboardChart').getContext('2d');
const data = @json($previsions->values());

// Couleurs par culture
const CULTURE_COLORS = {
    'Tomate'   : '#ef4444',
    'Piment'   : '#f97316',
    'Gombo'    : '#22c55e',
    'Oignon'   : '#a855f7',
    'Niébé'    : '#84cc16',
    'Arachide' : '#f59e0b',
    'Soja'     : '#eab308',
    'Goussi'   : '#14b8a6',
    'Ananas'   : '#fbbf24',
    'Coton'    : isDark ? '#94a3b8' : '#64748b',
};

const CULTURE_ICONS = {
    'Tomate'   : '🍅', 'Piment'   : '🌶️', 'Gombo'    : '🌿',
    'Oignon'   : '🧅', 'Niébé'    : '🫘', 'Arachide' : '🥜',
    'Soja'     : '🌱', 'Goussi'   : '🎃', 'Ananas'   : '🍍',
    'Coton'    : '☁️',
};

// Identifier les cultures présentes dans les données
const cultures_presentes = [...new Set(data.map(p => p.culture))];

const labels   = data.map(p => new Date(p.created_at).toLocaleDateString('fr-FR'));
const datasets = cultures_presentes.map(culture => {
    const color = CULTURE_COLORS[culture] || '#10b981';
    const icon  = CULTURE_ICONS[culture]  || '🌾';
    return {
        label           : icon + ' ' + culture + ' (t/ha)',
        data            : data.map(p => p.culture === culture ? p.rendement_prevu : null),
        borderColor     : color,
        backgroundColor : color + '20',
        fill            : true,
        tension         : 0.4,
        pointRadius     : 5,
        pointBackgroundColor: color,
        spanGaps        : true,
        borderWidth     : 2,
    };
});

new Chart(ctx, {
    type: 'line',
    data: { labels, datasets },
    options: {
        responsive          : true,
        maintainAspectRatio : false,
        plugins: {
            legend: {
                display  : true,
                position : 'bottom',
                labels   : {
                    padding   : 16,
                    color     : textColor,
                    font      : { size: 12, weight: '600' },
                    boxWidth  : 20,
                    usePointStyle: true,
                }
            },
            tooltip: {
                backgroundColor : 'rgba(15, 23, 42, 0.92)',
                padding         : 12,
                titleFont       : { size: 13 },
                bodyFont        : { size: 12 },
                titleColor      : '#f1f5f9',
                bodyColor       : '#cbd5e1',
                borderColor     : 'rgba(16,185,129,0.3)',
                borderWidth     : 1,
                callbacks: {
                    label: ctx => ctx.dataset.label + ' : ' + ctx.parsed.y + ' t/ha'
                }
            }
        },
        scales: {
            y: {
                beginAtZero : false,
                title: {
                    display : true,
                    text    : 'Rendement (t/ha)',
                    color   : textColor,
                    font    : { size: 12, weight: '600' }
                },
                ticks : { color: textColor },
                grid  : { color: gridColor }
            },
            x: {
                grid  : { display: false },
                ticks : { color: textColor, maxRotation: 30 },
                title: {
                    display : true,
                    text    : 'Date de prévision',
                    color   : textColor,
                    font    : { size: 12, weight: '600' }
                }
            }
        }
    }
});
@endif
</script>
@endpush
@endsection