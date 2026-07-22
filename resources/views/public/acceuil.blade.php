@extends('layouts.guest')
@section('title', 'Accueil - AgriPredict AI')

@push('styles')
<style>
/* Animations au scroll */
.reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}
.reveal-left {
    opacity: 0;
    transform: translateX(-40px);
    transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}
.reveal-left.visible {
    opacity: 1;
    transform: translateX(0);
}
.reveal-right {
    opacity: 0;
    transform: translateX(40px);
    transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}
.reveal-right.visible {
    opacity: 1;
    transform: translateX(0);
}
.counter { transition: all 2s ease-out; }

/* Particules hero */
.particle {
    position: absolute;
    border-radius: 50%;
    background: rgba(74, 222, 128, 0.15);
    animation: particleFloat 6s ease-in-out infinite;
}
@keyframes particleFloat {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.5; }
    50% { transform: translateY(-30px) scale(1.1); opacity: 1; }
}

/* Typing effect */
.typing::after {
    content: '|';
    animation: blink 1s infinite;
}
@keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

/* Gradient text animé */
.gradient-text-animated {
    background: linear-gradient(270deg, #4ade80, #22d3ee, #a78bfa, #4ade80);
    background-size: 400% 400%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientShift 4s ease infinite;
}
@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Card hover 3D */
.card-3d {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    transform-style: preserve-3d;
}
.card-3d:hover {
    transform: translateY(-8px) rotateX(2deg);
    box-shadow: 0 20px 60px rgba(16, 185, 129, 0.2);
}

/* Timeline */
.timeline-line {
    background: linear-gradient(180deg, #10b981, #06b6d4);
}

/* Glow effect */
.glow {
    box-shadow: 0 0 30px rgba(16, 185, 129, 0.3);
}
.glow:hover {
    box-shadow: 0 0 50px rgba(16, 185, 129, 0.5);
}

/* ═══════════════════════════════════════════════════════
   SECTION AVIS - Accueil (affichage uniquement)
   ═══════════════════════════════════════════════════════ */
@keyframes pulseRating {
    0%, 100% { transform: scale(1); }
    50%      { transform: scale(1.08); }
}
.rating-pulse { animation: pulseRating 0.6s ease; }
</style>
@endpush

@section('contenu')

{{-- ── HERO ─────────────────────────────────────────────── --}}
<div class="relative min-h-screen flex items-center justify-center text-center py-20 overflow-hidden">

    {{-- Particules de fond --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="particle w-64 h-64 top-10 left-10" style="animation-delay:0s"></div>
        <div class="particle w-32 h-32 top-40 right-20" style="animation-delay:1s"></div>
        <div class="particle w-48 h-48 bottom-20 left-1/3" style="animation-delay:2s"></div>
        <div class="particle w-20 h-20 top-1/2 right-10" style="animation-delay:3s"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-4">
        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-sm font-medium mb-8 animate-fade-in">
            <span class="w-2 h-2 rounded-full bg-agri-400 animate-pulse"></span>
         Sentinel-2 · FAOSTAT · MAEP/DSA · INSAE · Open-Météo · Bénin 2026        </div>

        {{-- Titre principal --}}
        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 leading-tight">
            Prévision de rendement<br>
            <span class="gradient-text-animated">agricole par IA</span>
        </h1>

        <p class="text-xl text-white/70 max-w-3xl mx-auto mb-10 leading-relaxed">
            AgriPredict AI analyse vos parcelles via imagerie satellitaire <strong class="text-white">Sentinel-2</strong>
            et un modèle <strong class="text-white">Random Forest</strong> pour estimer vos rendements             <strong class="text-agri-400"></strong><strong class="text-cyan-400"></strong> au Bénin.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
            <a href="{{ route('register') }}"
                class="px-8 py-4 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-2xl shadow-lg glow transition-all duration-300 flex items-center justify-center gap-2 text-lg">
                <i class="fas fa-rocket"></i> Commencer gratuitement
            </a>
            <a href="{{ route('login') }}"
                class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-2xl border border-white/20 transition-all duration-300 flex items-center justify-center gap-2 text-lg backdrop-blur-sm">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </a>
        </div>

        {{-- Stats animées --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="glass rounded-2xl p-5 text-center card-3d reveal">
                <div class="text-4xl font-black text-agri-600 counter" data-target="12">0</div>
                <div class="text-sm text-slate-500 mt-1 font-medium">Cultures</div>
            </div>
            <div class="glass rounded-2xl p-5 text-center card-3d reveal" style="transition-delay:0.1s">
                <div class="text-4xl font-black text-cyan-600 counter" data-target="12269">0</div>
                <div class="text-sm text-slate-500 mt-1 font-medium">Observations totales</div>
            </div>
            <div class="glass rounded-2xl p-5 text-center card-3d reveal" style="transition-delay:0.2s">
                <div class="text-4xl font-black text-purple-600">41.6%</div>
                <div class="text-sm text-slate-500 mt-1 font-medium">R² moyen</div>
            </div>
            <div class="glass rounded-2xl p-5 text-center card-3d reveal" style="transition-delay:0.3s">
                <div class="text-4xl font-black text-agri-600 counter" data-target="80">0</div>
                <div class="text-sm text-slate-500 mt-1 font-medium">Meilleur R² (%)</div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/50 animate-bounce">
        <i class="fas fa-chevron-down text-2xl"></i>
    </div>
</div>

{{-- ── À PROPOS ──────────────────────────────────────────── --}}
<div class="py-20 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="reveal-left">
                <span class="px-3 py-1 bg-agri-500/20 text-agri-400 rounded-full text-sm font-semibold mb-4 inline-block">
                    À propos
                </span>
                <h2 class="text-4xl font-black text-white mb-6 leading-tight">
                    L'IA au service des<br>
                    <span class="gradient-text-animated">agriculteurs béninois</span>
                </h2>
                <p class="text-white/70 text-lg leading-relaxed mb-6">
                    AgriPredict AI est une plateforme développée dans le cadre d'un projet de fin d'études,
                    visant à démocratiser l'accès aux technologies de précision pour les petits agriculteurs du Bénin.
                </p>
                <p class="text-white/70 leading-relaxed mb-8">
    En combinant les données satellitaires <strong class="text-white">Sentinel-2</strong> de l'ESA,
    les données historiques <strong class="text-white">FAOSTAT</strong>, 
    <strong class="text-white">MAEP/DSA</strong> et <strong class="text-white">INSAE</strong>,
    ainsi qu'un modèle de machine learning <strong class="text-white">Random Forest</strong>,
    notre système prédit les rendements agricoles sur 
    <strong class="text-agri-400">12 cultures</strong> avec un R² moyen de
    <strong class="text-cyan-400">41,6%</strong> et un meilleur score atteignant
    <strong class="text-agri-400">80%</strong>.
</p>
                <div class="flex gap-4">
                    <div class="glass rounded-xl p-4 text-center flex-1">
                        <i class="fas fa-graduation-cap text-agri-500 text-2xl mb-2 block"></i>
                        <p class="text-xs text-slate-600 font-medium">Projet académique</p>
                    </div>
                    <div class="glass rounded-xl p-4 text-center flex-1">
                        <i class="fas fa-map-marker-alt text-cyan-500 text-2xl mb-2 block"></i>
                        <p class="text-xs text-slate-600 font-medium">Focalisé Bénin</p>
                    </div>
                    <div class="glass rounded-xl p-4 text-center flex-1">
                        <i class="fas fa-leaf text-agri-500 text-2xl mb-2 block"></i>
                        <p class="text-xs text-slate-600 font-medium">12 cultures</p>
                    </div>
                </div>
            </div>

            <div class="reveal-right">
                <div class="glass rounded-3xl p-8 card-3d">
                    <h4 class="font-bold text-slate-800 mb-6 text-lg">
                        <i class="fas fa-users text-agri-600 mr-2"></i>L'équipe
                    </h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-agri-50 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-agri-400 to-cyan-500 flex items-center justify-center text-white font-bold">ML</div>
                            <div>
                                <p class="font-bold text-slate-800">MONTCHO Lysias</p>
                                <p class="text-sm text-slate-500">Développeur Frontend</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-cyan-50 rounded-xl">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-cyan-400 to-purple-500 flex items-center justify-center text-white font-bold">TO</div>
                            <div>
                                <p class="font-bold text-slate-800">TCHEOUBI Osiax</p>
                                <p class="text-sm text-slate-500">Développeur Full Stack</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-slate-50 rounded-xl">
                        <p class="text-xs text-slate-500 text-center">
                            <i class="fas fa-university text-agri-600 mr-1"></i>
                            Projet de fin d'études · Bénin 2025–2026
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── FONCTIONNALITÉS ───────────────────────────────────── --}}
<div class="py-20 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16 reveal">
            <span class="px-3 py-1 bg-cyan-500/20 text-cyan-400 rounded-full text-sm font-semibold mb-4 inline-block">
                Fonctionnalités
            </span>
            <h2 class="text-4xl font-black text-white">Ce que fait AgriPredict AI</h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
@foreach([
    [
        'icon' => 'fa-satellite',
        'color' => 'from-cyan-500 to-cyan-600',
        'shadow' => 'cyan',
        'title' => 'NDVI Sentinel-2',
        'desc' => 'Analyse satellitaire automatique de vos parcelles via Google Earth Engine. Résolution 10m.',
        'delay' => '0s'
    ],
    [
        'icon' => 'fa-brain',
        'color' => 'from-agri-500 to-agri-600',
        'shadow' => 'agri',
        'title' => 'Random Forest IA',
        'desc' => 'Modèle entraîné sur 12 269 observations issues de FAOSTAT, MAEP/DSA et INSAE couvrant 12 cultures agricoles. Score de confiance inclus.',
        'delay' => '0.1s'
    ],
    [
        'icon' => 'fa-cloud-rain',
        'color' => 'from-blue-500 to-blue-600',
        'shadow' => 'blue',
        'title' => 'Météo temps réel',
        'desc' => 'Pluviométrie, température et humidité via Open-Météo selon vos coordonnées GPS.',
        'delay' => '0.2s'
    ],
    [
        'icon' => 'fa-map-marked-alt',
        'color' => 'from-purple-500 to-purple-600',
        'shadow' => 'purple',
        'title' => 'Carte interactive',
        'desc' => 'Gérez toutes vos parcelles sur une carte Leaflet.js centrée sur le Bénin.',
        'delay' => '0.3s'
    ],
    [
        'icon' => 'fa-robot',
        'color' => 'from-rose-500 to-rose-600',
        'shadow' => 'rose',
        'title' => 'Recommandations IA',
        'desc' => 'Conseils agronomiques personnalisés générés par Groq AI (Llama 3.3) selon vos données.',
        'delay' => '0.4s'
    ],
    [
        'icon' => 'fa-file-pdf',
        'color' => 'from-amber-500 to-amber-600',
        'shadow' => 'amber',
        'title' => 'Export PDF',
        'desc' => 'Générez un rapport complet de vos prévisions téléchargeable en un clic.',
        'delay' => '0.5s'
    ],
] as $f)
            <div class="glass rounded-2xl p-6 card-3d reveal" style="transition-delay:{{ $f['delay'] }}">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $f['color'] }} flex items-center justify-center mb-4 shadow-lg">
                    <i class="fas {{ $f['icon'] }} text-white text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">{{ $f['title'] }}</h3>
                <p class="text-slate-600 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ── COMMENT ÇA MARCHE ────────────────────────────────── --}}
<div class="py-20 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-16 reveal">
            <span class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-sm font-semibold mb-4 inline-block">
                Processus
            </span>
            <h2 class="text-4xl font-black text-white">Comment ça marche</h2>
        </div>

        <div class="relative">
            {{-- Ligne verticale --}}
            <div class="absolute left-8 top-0 bottom-0 w-0.5 timeline-line hidden md:block"></div>

            <div class="space-y-8">
              @foreach([
    [
        'num' => '1',
        'color' => 'from-agri-500 to-agri-600',
        'icon' => 'fa-map-pin',
        'title' => 'Créez votre parcelle',
        'desc' => 'Enregistrez votre parcelle agricole avec ses coordonnées GPS sur la carte interactive. Renseignez la superficie, le type de sol et la culture.'
    ],
    [
        'num' => '2',
        'color' => 'from-cyan-500 to-cyan-600',
        'icon' => 'fa-satellite',
        'title' => 'Analyse satellite automatique',
        'desc' => 'Le système contacte Google Earth Engine et calcule le NDVI réel de votre parcelle via les images Sentinel-2 à 10m de résolution.'
    ],
    [
        'num' => '3',
        'color' => 'from-blue-500 to-blue-600',
        'icon' => 'fa-cloud-sun',
        'title' => 'Récupération météo',
        'desc' => 'La pluviométrie, la température et l\'humidité sont récupérées automatiquement via Open-Météo pour votre localisation exacte.'
    ],
[
    'num' => '4',
    'color' => 'from-purple-500 to-purple-600',
    'icon' => 'fa-brain',
    'title' => 'Prévision IA + Recommandations',
    'desc' => 'Le modèle Random Forest, entraîné sur 12 269 observations issues de FAOSTAT, MAEP/DSA et INSAE pour 12 cultures agricoles, prédit votre rendement en t/ha avec un score de confiance. Groq AI génère des recommandations agronomiques personnalisées.'
],
] as $step)
                <div class="flex gap-6 items-start reveal-left">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $step['color'] }} flex items-center justify-center text-white font-black text-xl flex-shrink-0 shadow-lg z-10">
                        {{ $step['num'] }}
                    </div>
                    <div class="glass rounded-2xl p-6 flex-1 card-3d">
                        <h4 class="text-lg font-bold text-slate-800 mb-2">
                            <i class="fas {{ $step['icon'] }} text-agri-600 mr-2"></i>{{ $step['title'] }}
                        </h4>
                        <p class="text-slate-600 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



{{-- ══════════════════════════════════════════════════════════
     ── AVIS & TÉMOIGNAGES (AFFICHAGE UNIQUEMENT) ──
     ══════════════════════════════════════════════════════════ --}}
<div class="py-20 px-4" id="avis">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12 reveal">
            <span class="px-3 py-1 bg-amber-500/20 text-amber-400 rounded-full text-sm font-semibold mb-4 inline-block">
                Témoignages
            </span>
            <h2 class="text-4xl font-black text-white mb-4">Ce qu'en disent nos utilisateurs</h2>
            <p class="text-white/60 max-w-2xl mx-auto">
                Des avis authentiques laissés par les utilisateurs connectés de la plateforme.
            </p>
        </div>

        {{-- Stats globales des avis --}}
        <div class="glass rounded-3xl p-8 mb-10 reveal">
            <div class="grid md:grid-cols-3 gap-8 items-center">
                {{-- Note moyenne --}}
                <div class="text-center">
                    <div class="text-6xl font-black gradient-text-animated" id="avg-rating">
                        {{ number_format(App\Models\Review::averageRating(), 1) }}
                    </div>
                    <div class="flex justify-center gap-1 my-2" id="avg-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= round(App\Models\Review::averageRating()) ? 'text-amber-400' : 'text-slate-300' }}"></i>
                        @endfor
                    </div>
                    <p class="text-sm text-slate-500">
                        Basé sur <strong id="total-reviews" class="text-slate-700">{{ App\Models\Review::totalApproved() }}</strong> avis
                    </p>
                </div>

                {{-- Répartition par étoile --}}
                <div class="md:col-span-2 space-y-2" id="rating-distribution">
                    @foreach(App\Models\Review::ratingDistribution() as $star => $count)
                        @php $total = max(App\Models\Review::totalApproved(), 1); $pct = ($count / $total) * 100; @endphp
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-semibold text-slate-600 w-12">{{ $star }} <i class="fas fa-star text-amber-400 text-xs"></i></span>
                            <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-amber-400 to-amber-500 rounded-full transition-all duration-700"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="text-xs text-slate-500 w-10 text-right">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Bouton pour laisser/modifier un avis --}}
        @auth
            @if(!App\Models\Review::hasReviewed(auth()->id()))
                <div class="text-center mb-8 reveal">
                    <a href="{{ route('reviews.mine.page') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-2xl shadow-lg glow transition-all duration-300 text-lg">
                        <i class="fas fa-pen"></i> Laisser mon avis
                    </a>
                    <p class="text-xs text-white/50 mt-3">
                        <i class="fas fa-shield-alt mr-1"></i>
                        1 seul avis par utilisateur · Modifiable à tout moment
                    </p>
                </div>
            @else
                <div class="text-center mb-8 reveal">
                    <a href="{{ route('reviews.mine.page') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl border border-white/20 transition-all duration-300 backdrop-blur-sm">
                        <i class="fas fa-pen-to-square"></i> Modifier mon avis
                    </a>
                </div>
            @endif
        @else
            <div class="text-center mb-8 reveal">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-2xl shadow-lg glow transition-all duration-300 text-lg">
                    <i class="fas fa-sign-in-alt"></i> Connectez-vous pour laisser un avis
                </a>
                <p class="text-xs text-white/50 mt-3">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Avis authentiques · Pas de spam
                </p>
            </div>
        @endauth

        {{-- Liste des avis --}}
        <div class="grid md:grid-cols-2 gap-5" id="reviews-list">
            @forelse(App\Models\Review::approved()->with('user:id,name,email')->latest()->take(8)->get() as $review)
                <div class="glass rounded-2xl p-6 card-3d reveal">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-agri-400 to-cyan-500 flex items-center justify-center text-white font-bold flex-shrink-0">
                            {{ $review->initials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
                                <h4 class="font-bold text-slate-800">{{ $review->user->name }}</h4>
                                <span class="text-xs text-slate-400">{{ $review->created_at_formatted }}</span>
                            </div>
                            <div class="flex gap-0.5 mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-sm {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-300' }}"></i>
                                @endfor
                            </div>
                            @if($review->culture)
                                <span class="inline-block px-2 py-0.5 bg-agri-100 text-agri-700 text-xs rounded-full mb-2">
                                    <i class="fas fa-seedling mr-1"></i>{{ $review->culture }}
                                </span>
                            @endif
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 glass rounded-2xl p-12 text-center">
                    <i class="fas fa-comment-dots text-5xl text-slate-300 mb-4 block"></i>
                    <p class="text-slate-500 text-lg mb-4">Aucun avis pour le moment</p>
                    @auth
                        <a href="{{ route('reviews.mine.page') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 text-white font-bold rounded-xl shadow-lg">
                            <i class="fas fa-pen"></i> Soyez le premier !
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 text-white font-bold rounded-xl shadow-lg">
                            <i class="fas fa-sign-in-alt"></i> Connectez-vous pour laisser un avis
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ── CTA FINAL ────────────────────────────────────────── --}}
<div class="py-20 px-4">
    <div class="max-w-3xl mx-auto reveal">
        <div class="glass rounded-3xl p-12 text-center card-3d">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-agri-500 to-cyan-500 flex items-center justify-center mx-auto mb-6 shadow-lg glow animate-float">
                <i class="fas fa-seedling text-white text-3xl"></i>
            </div>
            <h3 class="text-4xl font-black text-slate-800 mb-4">Prêt à prévoir vos rendements ?</h3>
            <p class="text-slate-500 mb-8 text-lg max-w-xl mx-auto">
                Créez votre compte gratuitement et commencez à analyser vos parcelles dès aujourd'hui.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="px-8 py-4 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-2xl shadow-lg glow transition-all duration-300 flex items-center justify-center gap-2 text-lg">
                    <i class="fas fa-user-plus"></i> Créer un compte
                </a>
                <a href="{{ route('login') }}"
                    class="px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-2xl transition-all duration-300 flex items-center justify-center gap-2 text-lg">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </a>
            </div>
        </div>
    </div>
</div>{{-- ── FOOTER ───────────────────────────────────────────── --}}
{{-- ── FOOTER ───────────────────────────────────────────── --}}
<footer class="relative mt-16">
    <div class="h-px bg-gradient-to-r from-transparent via-agri-400/40 to-transparent"></div>

    <div class="relative bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl border-t border-slate-200 dark:border-white/10 px-6 pt-14 pb-8 overflow-hidden">

        {{-- Glow décoratif discret --}}
        <div class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-agri-400/20 blur-3xl rounded-full"></div>

        <div class="relative max-w-6xl mx-auto">

            {{-- Colonnes principales --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">

                {{-- Colonne 1 : Marque --}}
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-xl object-cover shadow-md shadow-black/10 ring-1 ring-agri-400/30">
                        <span class="font-bold text-xl text-slate-900 dark:text-white tracking-tight">AgriPredict AI</span>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-white/70 max-w-sm leading-relaxed">
                        Plateforme de prévision de rendement agricole par intelligence artificielle,
                        basée sur l'analyse NDVI satellite Sentinel-2 et des données FAOSTAT, MAEP/DSA et INSAE.
                    </p>
                    <div class="inline-flex items-center gap-2 mt-5 px-3 py-1.5 rounded-full bg-agri-500/10 dark:bg-agri-400/20 border border-agri-500/20 dark:border-agri-300/20 text-xs font-semibold text-agri-700 dark:text-agri-200">
                        <i class="fas fa-satellite"></i>
                        <span>Analyse NDVI Sentinel-2 · 12 cultures couvertes</span>
                    </div>
                </div>

                {{-- Colonne 2 : Navigation --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-white/50 mb-5">
                        Plateforme
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="{{ route('formulaire') }}" class="group inline-flex items-center gap-2 text-slate-700 dark:text-white/80 hover:text-agri-600 dark:hover:text-white transition-colors">
                                <span class="w-1 h-1 rounded-full bg-agri-500 dark:bg-agri-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Nouvelle analyse
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('parcelles.create') }}" class="group inline-flex items-center gap-2 text-slate-700 dark:text-white/80 hover:text-agri-600 dark:hover:text-white transition-colors">
                                <span class="w-1 h-1 rounded-full bg-agri-500 dark:bg-agri-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Mes parcelles
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('historique.index') }}" class="group inline-flex items-center gap-2 text-slate-700 dark:text-white/80 hover:text-agri-600 dark:hover:text-white transition-colors">
                                <span class="w-1 h-1 rounded-full bg-agri-500 dark:bg-agri-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Historique
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Colonne 3 : Légal --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-white/50 mb-5">
                        Informations
                    </h4>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="{{ route('legal.cgu') }}" class="group inline-flex items-center gap-2 text-slate-700 dark:text-white/80 hover:text-agri-600 dark:hover:text-white transition-colors">
                                <span class="w-1 h-1 rounded-full bg-agri-500 dark:bg-agri-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Conditions d'utilisation
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('legal.politique') }}" class="group inline-flex items-center gap-2 text-slate-700 dark:text-white/80 hover:text-agri-600 dark:hover:text-white transition-colors">
                                <span class="w-1 h-1 rounded-full bg-agri-500 dark:bg-agri-300 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Politique de confidentialité
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Séparateur --}}
            <div class="border-t border-slate-200 dark:border-white/10 pt-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-3 text-xs">
                    <p class="text-slate-600 dark:text-white/60 font-medium">
                        &copy; {{ date('Y') }} AgriPredict AI · Bénin 2025–2026
                    </p>
                    <p class="flex items-center gap-1.5 text-slate-600 dark:text-white/60 font-medium">
                        <i class="fas fa-code text-agri-500 dark:text-agri-300"></i>
                        Développé par <span class="font-semibold text-slate-800 dark:text-white/90">MONTCHO Lysias</span>
                        &amp;
                        <span class="font-semibold text-slate-800 dark:text-white/90">TCHEOUBI Osiax</span>
                    </p>
                </div>
            </div>

        </div>
    </div>
</footer>
@push('scripts')
<script>
// ── Animations au scroll ──────────────────────────────
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
    observer.observe(el);
});

// ── Compteurs animés ──────────────────────────────────
const counters = document.querySelectorAll('.counter');
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const target = parseInt(entry.target.dataset.target);
            const suffix = entry.target.dataset.suffix || '';
            let current = 0;
            const increment = target / 60;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                entry.target.textContent = Math.floor(current) + suffix;
            }, 30);
            counterObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

counters.forEach(c => counterObserver.observe(c));

// ── Dark mode toggle ──────────────────────────────────
(function() {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        document.getElementById('html-root')?.classList.add('dark');
    }
})();
</script>
@endpush
@endsection