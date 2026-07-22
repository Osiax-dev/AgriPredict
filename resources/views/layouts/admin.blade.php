<!DOCTYPE html>
<html lang="fr" id="html-root" class="">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgriPredict AI — Admin — @yield('title', 'Administration')</title>

    {{-- ── PWA ──────────────────────────────────────── --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#ef4444">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="AgriPredict">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .bg-admin {
            background-image: url('https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=2074&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .bg-overlay-admin {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.92) 50%, rgba(15, 23, 42, 0.95) 100%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .glass-admin {
            background: rgba(15, 23, 42, 0.90);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(239, 68, 68, 0.2); }
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .dropdown-menu { display: none; }
        .dropdown-menu.active { display: block; }

        /* ═══════════════════════════════════════════════════════
           SIDEBAR DESKTOP — Pleine hauteur
           ═══════════════════════════════════════════════════════ */
        .sidebar-admin {
            height: 100vh !important;
            min-height: 100vh !important;
            max-height: 100vh !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            bottom: 0 !important;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Scrollbar personnalisée pour la sidebar admin */
        .sidebar-admin::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-admin::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        .sidebar-admin::-webkit-scrollbar-thumb {
            background: rgba(239, 68, 68, 0.3);
            border-radius: 3px;
        }
        .sidebar-admin::-webkit-scrollbar-thumb:hover {
            background: rgba(239, 68, 68, 0.5);
        }

        /* ═══════════════════════════════════════════════════════
           MOBILE SIDEBAR
           ═══════════════════════════════════════════════════════ */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 85%;
            max-width: 320px;
            height: 100vh;
            z-index: 999;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: 10px 0 40px rgba(0, 0, 0, 0.4);
        }
        .mobile-sidebar.active {
            left: 0;
        }

        /* Animation des items */
        .mobile-sidebar .mobile-menu-item {
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.3s ease;
        }
        .mobile-sidebar.active .mobile-menu-item {
            opacity: 1;
            transform: translateX(0);
        }
        .mobile-sidebar.active .mobile-menu-item:nth-child(1) { transition-delay: 0.05s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(2) { transition-delay: 0.1s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(3) { transition-delay: 0.15s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(4) { transition-delay: 0.2s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(5) { transition-delay: 0.25s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(6) { transition-delay: 0.3s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(7) { transition-delay: 0.35s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(8) { transition-delay: 0.4s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(9) { transition-delay: 0.45s; }

        /* Bouton PWA */
        .pwa-install-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            animation: pulseInstall 2s infinite;
        }
        @keyframes pulseInstall {
            0%, 100% { transform: scale(1); box-shadow: 0 10px 30px rgba(239, 68, 68, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 15px 40px rgba(239, 68, 68, 0.6); }
        }
        .pwa-install-btn:hover {
            animation: none;
            transform: scale(1.1);
        }

        /* Badge admin pulsant */
        @keyframes adminPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
        }
        .admin-badge-pulse {
            animation: adminPulse 2s infinite;
        }

        /* ═══════════════════════════════════════════════════════
           DESKTOP LAYOUT
           ═══════════════════════════════════════════════════════ */
        @media (min-width: 768px) {
            body {
                padding-left: 18rem;
                margin: 0;
                overflow-x: hidden;
            }
        }

        /* ═══════════════════════════════════════════════════════
           DARK MODE GLOBAL
           ═══════════════════════════════════════════════════════ */
        html.dark .glass {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        html.dark .glass p,
        html.dark .glass span,
        html.dark .glass td,
        html.dark .glass th,
        html.dark .glass label,
        html.dark .glass h1,
        html.dark .glass h2,
        html.dark .glass h3,
        html.dark .glass h4 {
            color: #e2e8f0;
        }

        html.dark .glass .text-slate-500,
        html.dark .glass .text-slate-400 {
            color: #94a3b8 !important;
        }

        html.dark .glass table tr {
            border-color: rgba(255, 255, 255, 0.08);
        }

        html.dark .glass .bg-slate-200 {
            background-color: rgba(255, 255, 255, 0.1);
        }

        html.dark .glass input,
        html.dark .glass select,
        html.dark .glass textarea {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.15);
            color: #e2e8f0;
        }

        html.dark .glass input::placeholder,
        html.dark .glass select::placeholder,
        html.dark .glass textarea::placeholder {
            color: #64748b;
        }

        /* Textes en mode sombre */
        html.dark body {
            color: #e2e8f0;
        }
        html.dark .text-slate-800 { color: #f1f5f9; }
        html.dark .text-slate-700 { color: #e2e8f0; }
        html.dark .text-slate-600 { color: #cbd5e1; }
        html.dark .text-slate-500 { color: #94a3b8; }
        html.dark .text-slate-400 { color: #64748b; }
    </style>
    @stack('styles')
</head>
<body class="bg-admin font-sans text-slate-800 antialiased min-h-screen">

<div class="bg-overlay-admin min-h-screen">
    {{-- ══════════════════════════════════════════════════════════
         SIDEBAR DESKTOP (visible sur md+)
         ══════════════════════════════════════════════════════════ --}}
    <aside class="sidebar-admin w-72 glass-admin text-white hidden md:flex flex-col shadow-2xl border-r border-white/5 z-50">
        {{-- Logo --}}
        <div class="p-6 border-b border-white/10 flex-shrink-0">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="AgriPredict AI"
                    class="w-12 h-12 rounded-xl object-cover shadow-lg animate-float">
                <div class="flex-1">
                    <h1 class="font-bold text-xl tracking-tight">
                        <span style="background: linear-gradient(90deg, #f87171, #fb923c, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            AgriPredict AI
                        </span>
                    </h1>
                    <p class="text-xs text-white/50">Administration • Bénin 2026</p>
                </div>
                <button onclick="toggleDark()" id="dark-toggle"
                    class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all"
                    title="Mode sombre">
                    <i class="fas fa-moon text-white/70 text-sm" id="dark-icon"></i>
                </button>
            </div>
            {{-- Badge admin --}}
            <div class="mt-3 flex items-center gap-2 px-3 py-2 rounded-lg bg-red-500/20 border border-red-500/30 admin-badge-pulse">
                <i class="fas fa-shield-alt text-red-400 text-xs"></i>
                <span class="text-red-300 text-xs font-semibold">Panneau Administrateur</span>
            </div>
        </div>

        {{-- Navigation Admin --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <p class="text-xs text-white/30 px-4 mb-3 uppercase tracking-wider">Navigation</p>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                <i class="fas fa-tachometer-alt w-5"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.index') ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                <i class="fas fa-users w-5"></i> Utilisateurs
            </a>

            <div class="pt-3 border-t border-white/10 mt-3">
                <p class="text-xs text-white/30 px-4 mb-3 uppercase tracking-wider">Statistiques</p>
                <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-white/80 hover:bg-white/10">
                    <i class="fas fa-chart-bar w-5"></i> Prévisions globales
                </a>
                <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-white/80 hover:bg-white/10">
                    <i class="fas fa-map-marked-alt w-5"></i> Toutes les parcelles
                </a>
            </div>

            <div class="pt-3 border-t border-white/10 mt-3">
                <p class="text-xs text-white/30 px-4 mb-3 uppercase tracking-wider">Modération</p>
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.reviews.*') ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                    <i class="fas fa-star w-5 text-amber-400"></i> Avis utilisateurs
                    @php $nbAvisNonLus = \App\Models\Review::where('approved', false)->count(); @endphp
                    @if($nbAvisNonLus > 0)
                        <span class="ml-auto bg-amber-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $nbAvisNonLus }}
                        </span>
                    @endif
                </a>
            </div>
        </nav>

        {{-- Profil Admin --}}
        <div class="p-4 border-t border-white/10 flex-shrink-0">
            <div class="relative">
                <button onclick="toggleDropdown()" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-orange-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
                    </div>
                    <div class="flex-1 text-left overflow-hidden">
                        <p class="text-white font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                        <p class="text-red-300/70 text-xs">Administrateur</p>
                    </div>
                    <i class="fas fa-chevron-up text-white/50 text-xs group-hover:text-white transition-all" id="dropdown-arrow"></i>
                </button>

                <div id="user-dropdown" class="dropdown-menu absolute bottom-full left-0 right-0 mb-2 glass rounded-xl shadow-2xl overflow-hidden z-50">
                    <a href="{{ route('profil.edit') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-agri-50 transition-colors text-sm">
                        <i class="fas fa-user-edit text-agri-600 w-4"></i>
                        Modifier mon profil
                    </a>
                    <a href="{{ route('reviews.mine.page') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-agri-50 transition-colors text-sm">
                        <i class="fas fa-star text-amber-500 w-4"></i>
                        Mon avis
                    </a>
                    <div class="border-t border-slate-100"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors text-sm">
                            <i class="fas fa-sign-out-alt w-4"></i>
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-xs text-white/20 text-center mt-3">© 2026 AgriPredict AI</p>
        </div>
    </aside>

    {{-- ══════════════════════════════════════════════════════════
         CONTENU PRINCIPAL
         ══════════════════════════════════════════════════════════ --}}
    <main class="flex flex-col min-h-screen">
        {{-- ══════════════════════════════════════════════════════
             HEADER MOBILE (visible uniquement sur mobile)
             ══════════════════════════════════════════════════════ --}}
        <header class="md:hidden sticky top-0 z-40 px-4 py-3 glass-admin text-white flex items-center justify-between border-b border-white/10">
            {{-- Bouton hamburger --}}
            <button onclick="toggleMobileSidebar()" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all" title="Menu">
                <i class="fas fa-bars text-white"></i>
            </button>

            {{-- Logo + Badge --}}
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 rounded-lg object-cover">
                <div>
                    <span class="font-bold text-sm block" style="background: linear-gradient(90deg, #f87171, #fb923c, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        Admin Panel
                    </span>
                </div>
            </a>

            {{-- Actions --}}
            <div class="flex items-center gap-2">
                {{-- Dark mode --}}
                <button onclick="toggleDark()" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all">
                    <i class="fas fa-moon text-white text-sm" id="dark-icon-mobile"></i>
                </button>
            </div>
        </header>

        {{-- Contenu de la page --}}
        <div class="flex-1 overflow-y-auto p-4 md:p-8">

            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-100 flex items-center gap-3 backdrop-blur-sm animate-fade-in">
                    <i class="fas fa-check-circle text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-100 flex items-center gap-3 backdrop-blur-sm animate-fade-in">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('contenu')
        </div>
    </main>
</div>

{{-- ══════════════════════════════════════════════════════════
     MOBILE SIDEBAR
     ══════════════════════════════════════════════════════════ --}}
<div class="mobile-overlay" onclick="toggleMobileSidebar()"></div>

<aside class="mobile-sidebar glass-admin text-white" id="mobile-sidebar">
    {{-- Header --}}
    <div class="p-6 border-b border-white/10 bg-gradient-to-r from-red-600 to-orange-500">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-lg object-cover animate-float">
                <div>
                    <span class="font-bold text-lg block" style="background: linear-gradient(90deg, #fef3c7, #fde68a); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        Admin Panel
                    </span>
                    <p class="text-xs text-white/80">AgriPredict AI</p>
                </div>
            </div>
            <button onclick="toggleMobileSidebar()" class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Badge admin --}}
        <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-white/10 border border-white/20 backdrop-blur-sm mb-3">
            <i class="fas fa-shield-alt text-amber-300 text-xs"></i>
            <span class="text-amber-100 text-xs font-semibold">Accès Administrateur</span>
        </div>

        {{-- Info utilisateur --}}
        <div class="flex items-center gap-3 p-3 bg-white/10 rounded-xl backdrop-blur-sm">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-red-400 to-orange-500 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-white/80 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="p-4 space-y-1">
        <p class="mobile-menu-item text-xs text-white/40 px-4 mb-2 uppercase tracking-wider">Navigation</p>

        <a href="{{ route('admin.dashboard') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-tachometer-alt w-5"></i>
            <span class="font-medium">Tableau de bord</span>
        </a>

        <a href="{{ route('admin.index') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.index') ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-users w-5"></i>
            <span class="font-medium">Utilisateurs</span>
        </a>

        <a href="{{ route('admin.index') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-white/80 hover:bg-white/10">
            <i class="fas fa-chart-bar w-5"></i>
            <span class="font-medium">Prévisions globales</span>
        </a>

        <a href="{{ route('admin.index') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-white/80 hover:bg-white/10">
            <i class="fas fa-map-marked-alt w-5"></i>
            <span class="font-medium">Toutes les parcelles</span>
        </a>

        {{-- Séparateur --}}
        <hr class="border-white/10 my-3 mobile-menu-item">

        <p class="mobile-menu-item text-xs text-white/40 px-4 mb-2 uppercase tracking-wider">Modération</p>

        <a href="{{ route('admin.reviews.index') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.reviews.*') ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-star w-5 text-amber-400"></i>
            <span class="font-medium">Avis utilisateurs</span>
            @if(isset($nbAvisNonLus) && $nbAvisNonLus > 0)
                <span class="ml-auto bg-amber-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $nbAvisNonLus }}
                </span>
            @endif
        </a>

        {{-- Séparateur --}}
        <hr class="border-white/10 my-3 mobile-menu-item">

        <p class="mobile-menu-item text-xs text-white/40 px-4 mb-2 uppercase tracking-wider">Compte</p>

        <a href="{{ route('profil.edit') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:bg-white/10 transition-all">
            <i class="fas fa-user-edit w-5"></i>
            <span class="font-medium">Mon profil</span>
        </a>

        <a href="{{ route('reviews.mine.page') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:bg-white/10 transition-all">
            <i class="fas fa-star w-5 text-amber-400"></i>
            <span class="font-medium">Mon avis</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mobile-menu-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/20 transition-all">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="font-medium">Déconnexion</span>
            </button>
        </form>
    </nav>

    {{-- Footer --}}
    <div class="p-4 border-t border-white/10 mt-auto">
        <p class="text-xs text-white/40 text-center">
            <i class="fas fa-shield-alt text-red-400 mr-1"></i>
            © 2026 AgriPredict AI · Admin
        </p>
    </div>
</aside>

{{-- ══════════════════════════════════════════════════════════
     BOUTON INSTALLATION PWA
     ══════════════════════════════════════════════════════════ --}}
<button id="pwa-install-btn" class="pwa-install-btn hidden px-5 py-3 bg-gradient-to-r from-red-500 to-orange-500 hover:from-red-600 hover:to-orange-600 text-white font-bold rounded-full shadow-2xl transition-all duration-300 flex items-center gap-2">
    <i class="fas fa-download"></i>
    <span class="hidden sm:inline">Installer l'app</span>
    <span class="sm:hidden">Installer</span>
</button>

<script>
// ═══════════════════════════════════════════════════════
// DROPDOWN PROFIL (desktop)
// ═══════════════════════════════════════════════════════
function toggleDropdown() {
    const menu  = document.getElementById('user-dropdown');
    const arrow = document.getElementById('dropdown-arrow');
    menu.classList.toggle('active');
    arrow.classList.toggle('fa-chevron-up');
    arrow.classList.toggle('fa-chevron-down');
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('user-dropdown');
    const btn      = e.target.closest('button[onclick="toggleDropdown()"]');
    if (!btn && dropdown && dropdown.classList.contains('active')) {
        dropdown.classList.remove('active');
        document.getElementById('dropdown-arrow').classList.add('fa-chevron-up');
        document.getElementById('dropdown-arrow').classList.remove('fa-chevron-down');
    }
});

// ═══════════════════════════════════════════════════════
// MOBILE SIDEBAR
// ═══════════════════════════════════════════════════════
function toggleMobileSidebar() {
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.querySelector('.mobile-overlay');
    const body = document.body;

    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');

    if (sidebar.classList.contains('active')) {
        body.style.overflow = 'hidden';
    } else {
        body.style.overflow = '';
    }
}

// Fermer le menu quand on clique sur un lien
document.querySelectorAll('.mobile-sidebar a').forEach(link => {
    link.addEventListener('click', () => {
        const sidebar = document.getElementById('mobile-sidebar');
        if (sidebar.classList.contains('active')) {
            toggleMobileSidebar();
        }
    });
});

// Fermer avec ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('mobile-sidebar');
        if (sidebar && sidebar.classList.contains('active')) {
            toggleMobileSidebar();
        }
    }
});

// ═══════════════════════════════════════════════════════
// DARK MODE
// ═══════════════════════════════════════════════════════
function toggleDark() {
    const html = document.getElementById('html-root');
    const iconDesktop = document.getElementById('dark-icon');
    const iconMobile = document.getElementById('dark-icon-mobile');
    
    html.classList.toggle('dark');

    if (html.classList.contains('dark')) {
        localStorage.setItem('theme', 'dark');
        if (iconDesktop) iconDesktop.classList.replace('fa-moon', 'fa-sun');
        if (iconMobile) iconMobile.classList.replace('fa-moon', 'fa-sun');
    } else {
        localStorage.setItem('theme', 'light');
        if (iconDesktop) iconDesktop.classList.replace('fa-sun', 'fa-moon');
        if (iconMobile) iconMobile.classList.replace('fa-sun', 'fa-moon');
    }
}

(function() {
    const theme = localStorage.getItem('theme');
    const html  = document.getElementById('html-root');
    const iconDesktop = document.getElementById('dark-icon');
    const iconMobile = document.getElementById('dark-icon-mobile');
    
    if (theme === 'dark') {
        html.classList.add('dark');
        if (iconDesktop) iconDesktop.classList.replace('fa-moon', 'fa-sun');
        if (iconMobile) iconMobile.classList.replace('fa-moon', 'fa-sun');
    }
})();

// ═══════════════════════════════════════════════════════
// PWA INSTALL
// ═══════════════════════════════════════════════════════
let deferredPrompt;
const installBtn = document.getElementById('pwa-install-btn');

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    if (installBtn) installBtn.classList.remove('hidden');
});

if (installBtn) {
    installBtn.addEventListener('click', async () => {
        if (!deferredPrompt) return;
        
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        
        if (outcome === 'accepted') {
            installBtn.classList.add('hidden');
        }
        
        deferredPrompt = null;
    });
}

window.addEventListener('appinstalled', () => {
    if (installBtn) installBtn.classList.add('hidden');
    console.log('✅ PWA installée avec succès');
});

// ═══════════════════════════════════════════════════════
// SERVICE WORKER
// ═══════════════════════════════════════════════════════
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('✅ Service Worker enregistré:', reg.scope))
            .catch(err => console.log('❌ Erreur Service Worker:', err));
    });
}
</script>

@stack('scripts')
</body>
</html>