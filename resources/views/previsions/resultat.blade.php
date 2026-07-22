@extends('layouts.app')
@section('title', 'Rapport de Prévision IA')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@section('contenu')

{{-- Bouton retour + imprimer --}}
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 animate-fade-in">
    <a href="{{ route('historique.index') }}" class="flex items-center gap-2 text-white/80 hover:text-white transition-colors">
        <i class="fas fa-arrow-left"></i> Retour à l'historique
    </a>
    <button onclick="window.print()"
        class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl border border-white/20 transition-all flex items-center gap-2">
        <i class="fas fa-print"></i> Imprimer / PDF
    </button>
</div>

{{-- EN-TÊTE --}}
<div class="glass rounded-3xl p-8 mb-8 shadow-2xl relative overflow-hidden animate-slide-up">
    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-agri-500/20 to-cyan-500/20 rounded-full blur-3xl -mr-16 -mt-16"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-br from-gold-500/10 to-agri-500/10 rounded-full blur-3xl -ml-12 -mb-12"></div>

    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-agri-500 to-cyan-500 text-white text-xs font-bold uppercase tracking-wider mb-3 shadow-lg shadow-agri-500/30">
                <i class="fas fa-robot"></i> Analyse IA Complète
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-white mb-2">
                Rapport de Prévision
            </h1>
            <p class="text-slate-600 dark:text-slate-300 text-lg">
                <span class="font-semibold text-agri-700 dark:text-agri-300">{{ $culture }}</span>
                • Parcelle "{{ $parcelle->nom }}" • Année {{ $annee }}
            </p>
            <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">
                Généré le {{ now()->format('d/m/Y à H:i') }}
            </p>
        </div>

        <div class="text-center p-6 bg-gradient-to-br from-agri-500 via-cyan-500 to-agri-600 rounded-2xl text-white shadow-xl shadow-agri-500/30 min-w-[220px]">
            <p class="text-agri-100 text-sm font-medium uppercase tracking-wider mb-1">Rendement Prévu</p>
            <div class="text-5xl font-bold mb-1">{{ $rendement_prevu }}</div>
            <div class="text-xl font-medium text-agri-100">{{ $unite }}</div>
        </div>
    </div>
</div>

{{-- KPIs --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    {{-- Production totale --}}
    <div class="glass rounded-2xl p-5 text-center shadow-lg animate-slide-up" style="animation-delay:.1s">
        <i class="fas fa-weight-hanging text-3xl text-cyan-500 mb-3"></i>
        <p class="text-sm text-slate-500 dark:text-slate-300 font-medium">Production Totale</p>
        <p class="text-2xl font-bold text-slate-800 dark:text-white mt-1">
            {{ $production_totale }} <span class="text-sm font-normal text-slate-500">tonnes</span>
        </p>
        <p class="text-xs text-slate-400 mt-1">{{ $superficie }} ha × {{ $rendement_prevu }} t/ha</p>
    </div>

    {{-- Confiance --}}
    <div class="glass rounded-2xl p-5 text-center shadow-lg animate-slide-up" style="animation-delay:.2s">
        <i class="fas fa-percentage text-3xl text-agri-500 mb-3"></i>
        <p class="text-sm text-slate-500 dark:text-slate-300 font-medium">Confiance du modèle</p>
        <p class="text-2xl font-bold text-slate-800 dark:text-white mt-1">
            {{ $confiance }}<span class="text-sm font-normal text-slate-500">%</span>
        </p>
        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2 mt-3">
            <div class="bg-gradient-to-r from-agri-500 to-cyan-500 h-2 rounded-full" style="width:{{ $confiance }}%"></div>
        </div>
    </div>

    {{-- NDVI --}}
    <div class="glass rounded-2xl p-5 text-center shadow-lg animate-slide-up" style="animation-delay:.3s">
        <i class="fas fa-satellite text-3xl text-amber-500 mb-3"></i>
        <p class="text-sm text-slate-500 dark:text-slate-300 font-medium">NDVI Sentinel-2</p>
        <p class="text-2xl font-bold text-slate-800 dark:text-white mt-1">{{ $ndvi }}</p>
        <p class="text-xs font-semibold mt-1
            {{ $ndvi > 0.6 ? 'text-agri-600 dark:text-agri-400' : ($ndvi > 0.4 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400') }}">
            {{ $ndvi > 0.6 ? '🟢 Végétation saine' : ($ndvi > 0.4 ? '🟡 Stress modéré' : '🔴 Stress élevé') }}
        </p>
    </div>

    {{-- Météo --}}
    <div class="glass rounded-2xl p-5 text-center shadow-lg animate-slide-up" style="animation-delay:.4s">
        <i class="fas fa-cloud-sun-rain text-3xl text-cyan-500 mb-3"></i>
        <p class="text-sm text-slate-500 dark:text-slate-300 font-medium">Météo (7 jours)</p>
        <p class="text-2xl font-bold text-slate-800 dark:text-white mt-1">{{ $temperature }}°C</p>
        <p class="text-xs text-slate-500 mt-1">{{ $pluviometrie }} mm • {{ $humidite }}% hum.</p>
    </div>
</div>

{{-- FEATURES + CARTE --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

    {{-- Importance des features --}}
    <div class="glass rounded-2xl p-6 shadow-xl lg:col-span-1 animate-slide-up" style="animation-delay:.5s">
        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
            <i class="fas fa-chart-bar text-agri-600"></i> Facteurs clés (Random Forest)
        </h3>
@php
    $top_features = is_string($top_features) ? json_decode($top_features, true) : $top_features;
@endphp

@if(!empty($top_features))
    <div class="space-y-5">
        @foreach($top_features as $f)
        <div>
            <div class="flex justify-between mb-1">
                <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">
                    {{ $f['feature'] ?? '-' }}
                </span>
                <span class="font-bold text-agri-600 dark:text-agri-400 text-sm">
                    {{ $f['importance'] ?? 0 }}%
                </span>
            </div>
            <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-3">
                <div class="bg-gradient-to-r from-agri-500 to-cyan-500 h-3 rounded-full"
                    style="width:{{ min($f['importance'] ?? 0, 100) }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <p class="text-slate-400 text-sm text-center py-4">Données non disponibles</p>
@endif
        <div class="mt-6 p-4 bg-gradient-to-r from-cyan-50 to-agri-50 dark:from-cyan-900/20 dark:to-agri-900/20 border border-cyan-200 dark:border-cyan-700 rounded-xl">
            <p class="text-xs text-cyan-800 dark:text-cyan-300 flex gap-2">
                <i class="fas fa-info-circle mt-0.5"></i>
                Ces pourcentages indiquent l'influence de chaque variable sur la décision du modèle.
            </p>
        </div>
    </div>

    {{-- Carte Leaflet --}}
    <div class="glass rounded-2xl shadow-xl overflow-hidden lg:col-span-2 flex flex-col animate-slide-up" style="animation-delay:.6s">
        <div class="p-6 border-b border-slate-200/60 dark:border-slate-700">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <i class="fas fa-map text-agri-600"></i> Localisation de la parcelle
            </h3>
        </div>
        <div id="map" class="flex-1 min-h-[350px] w-full z-0"></div>
    </div>
</div>

{{-- RECOMMANDATIONS GROQ --}}
<div class="glass rounded-2xl shadow-2xl overflow-hidden border-2 border-agri-500/20 animate-slide-up mb-8" style="animation-delay:.7s">
    <div class="bg-gradient-to-r from-agri-800 via-agri-700 to-cyan-700 p-6 flex items-center justify-between">
        <h3 class="text-xl font-bold text-white flex items-center gap-3">
            <i class="fas fa-robot text-agri-400"></i> Recommandations Agronomiques IA
        </h3>
        <span class="px-3 py-1 rounded-full bg-white/10 text-white/80 text-xs font-mono border border-white/20">
            <i class="fas fa-bolt text-amber-400 mr-1"></i> Groq • Llama 3.3 70B
        </span>
    </div>
    <div class="p-8 bg-gradient-to-br from-agri-50/50 to-cyan-50/50 dark:from-agri-900/20 dark:to-cyan-900/20">
        @if($recommandations && !str_starts_with($recommandations, 'Recommandations non disponibles'))
            <div id="recommandations-content" class="prose prose-emerald max-w-none text-slate-700 dark:text-slate-200 leading-relaxed"></div>
        @else
            <div class="text-center py-8 text-slate-400">
                <i class="fas fa-exclamation-circle text-3xl mb-3"></i>
                <p>{{ $recommandations ?? 'Recommandations non disponibles.' }}</p>
            </div>
        @endif
    </div>
</div>

{{-- Actions --}}
<div class="flex flex-col sm:flex-row gap-4 justify-center pb-8">
    <a href="{{ route('formulaire') }}"
        class="px-8 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 text-white font-bold rounded-xl shadow-lg text-center transition-all hover:opacity-90">
        <i class="fas fa-plus mr-2"></i> Nouvelle prévision
    </a>
    <a href="{{ route('historique.index') }}"
        class="px-8 py-3 bg-white/10 border border-white/20 text-white font-semibold rounded-xl text-center transition-all hover:bg-white/20">
        <i class="fas fa-history mr-2"></i> Voir l'historique
    </a>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    // ── CARTE ──────────────────────────────────────────
    const map = L.map('map', { zoomControl: false }).setView([{{ $lat }}, {{ $lng }}], 14);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '© CARTO',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    L.control.zoom({ position: 'bottomright' }).addTo(map);

    const icon = L.divIcon({
        className: '',
        html: '<div style="background:#16a34a;color:#fff;padding:6px 10px;border-radius:8px;font-weight:700;font-size:12px;white-space:nowrap;box-shadow:0 2px 8px rgba(0,0,0,.2)">📍 {{ addslashes($parcelle->nom) }}</div>',
        anchor: [0, 20]
    });

    L.marker([{{ $lat }}, {{ $lng }}], { icon })
        .addTo(map)
        .bindPopup(`
            <div style="font-family:sans-serif;min-width:180px">
                <strong style="color:#15803d">{{ addslashes($parcelle->nom) }}</strong><br>
                <span style="font-size:13px;color:#555">{{ $culture }} — {{ $superficie }} ha</span><br>
                <span style="font-size:12px;color:#888">NDVI : {{ $ndvi }}</span>
            </div>
        `)
        .openPopup();

    // ── RECOMMANDATIONS MARKDOWN ───────────────────────
    const recommandationsText = @json($recommandations ?? '');
    const contentEl = document.getElementById('recommandations-content');

    if (contentEl && recommandationsText) {
        contentEl.innerHTML = marked.parse(recommandationsText);

        // Styles des titres
        contentEl.querySelectorAll('h1, h2, h3').forEach(el => {
            el.classList.add('font-bold', 'mt-6', 'mb-3', 'border-b', 'pb-2', 'text-agri-800', 'border-agri-200');
        });

        // Styles des listes
        contentEl.querySelectorAll('ul').forEach(el => {
            el.classList.add('list-disc', 'pl-5', 'space-y-1', 'mb-4', 'text-slate-700');
        });

        contentEl.querySelectorAll('ol').forEach(el => {
            el.classList.add('list-decimal', 'pl-5', 'space-y-1', 'mb-4', 'text-slate-700');
        });

        // Styles des paragraphes
        contentEl.querySelectorAll('p').forEach(el => {
            el.classList.add('mb-3', 'text-slate-700', 'leading-relaxed');
        });

        // Styles bold
        contentEl.querySelectorAll('strong').forEach(el => {
            el.classList.add('text-agri-800');
        });
    }
</script>
@endpush
@endsection