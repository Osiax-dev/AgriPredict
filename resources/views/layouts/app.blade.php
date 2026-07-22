<!DOCTYPE html>
<html lang="fr" id="html-root" class="">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgriPredict AI - @yield('title', 'Tableau de bord')</title>

    {{-- ── PWA ──────────────────────────────────────── --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#10b981">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="AgriPredict">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        .bg-agriculture {
            background-image: url('https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .bg-overlay {
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.92) 0%, rgba(5, 150, 105, 0.88) 50%, rgba(6, 145, 178, 0.85) 100%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .glass-dark {
            background: rgba(6, 78, 59, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .hover-lift { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(16, 185, 129, 0.25); }
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        .animate-slide-up { animation: slideUp 0.6s ease-out; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .leaflet-container { height: 100%; width: 100%; z-index: 1; }
        .dropdown-menu { display: none; }
        .dropdown-menu.active { display: block; }

        /* ── SIDEBAR DESKTOP ─────────────────────────── */
        .sidebar-desktop {
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

        /* Scrollbar personnalisée pour la sidebar */
        .sidebar-desktop::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-desktop::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        .sidebar-desktop::-webkit-scrollbar-thumb {
            background: rgba(16, 185, 129, 0.3);
            border-radius: 3px;
        }
        .sidebar-desktop::-webkit-scrollbar-thumb:hover {
            background: rgba(16, 185, 129, 0.5);
        }

        /* ── MOBILE SIDEBAR ─────────────────────────── */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .mobile-overlay.active { opacity: 1; visibility: visible; }

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
            box-shadow: 10px 0 40px rgba(0, 0, 0, 0.3);
        }
        .mobile-sidebar.active { left: 0; }

        .mobile-sidebar .mobile-menu-item {
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.3s ease;
        }
        .mobile-sidebar.active .mobile-menu-item { opacity: 1; transform: translateX(0); }
        .mobile-sidebar.active .mobile-menu-item:nth-child(1) { transition-delay: 0.05s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(2) { transition-delay: 0.1s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(3) { transition-delay: 0.15s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(4) { transition-delay: 0.2s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(5) { transition-delay: 0.25s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(6) { transition-delay: 0.3s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(7) { transition-delay: 0.35s; }
        .mobile-sidebar.active .mobile-menu-item:nth-child(8) { transition-delay: 0.4s; }

        /* ── PASSWORD TOGGLE EYE ────────────────────── */
        .input-password-wrapper { position: relative; }
        .input-password-wrapper input { padding-right: 3rem; }
        .password-eye-btn {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            transition: color 0.2s;
        }
        .password-eye-btn:hover { color: #10b981; }

        /* ── PWA INSTALL BUTTON ─────────────────────── */
        .pwa-install-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            animation: pulseInstall 2s infinite;
        }
        @keyframes pulseInstall {
            0%, 100% { transform: scale(1); box-shadow: 0 10px 30px rgba(16, 185, 129, 0.4); }
            50% { transform: scale(1.05); box-shadow: 0 15px 40px rgba(16, 185, 129, 0.6); }
        }
        .pwa-install-btn:hover { animation: none; transform: scale(1.1); }

        /* ── DESKTOP LAYOUT ─────────────────────────── */
        @media (min-width: 768px) {
            body { 
                padding-left: 18rem; 
                margin: 0;
                overflow-x: hidden;
            }
        }

        /* ── DARK MODE GLOBAL ───────────────────────── */
        html.dark .glass {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        html.dark .glass-dark {
            background: rgba(2, 6, 23, 0.95);
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
<body class="bg-agriculture font-sans text-slate-800 antialiased min-h-screen">

<div class="bg-overlay min-h-screen">

    {{-- ── SIDEBAR DESKTOP (md+) ───────────────────── --}}
    <aside class="sidebar-desktop w-72 glass-dark text-white hidden md:flex flex-col shadow-2xl z-50">

        {{-- Logo + Dark mode --}}
        <div class="p-6 border-b border-white/10 flex-shrink-0">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="AgriPredict AI"
                    class="w-12 h-12 rounded-xl object-cover shadow-lg animate-float">
                <div class="flex-1">
                    <h1 class="font-bold text-xl tracking-tight">
                        <span style="background: linear-gradient(90deg, #4ade80, #22d3ee, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            AgriPredict AI
                        </span>
                    </h1>
                    <p class="text-xs text-white/50">Prévision IA • Bénin 2026</p>
                </div>
                <button onclick="toggleDark()" id="dark-toggle"
                    class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all"
                    title="Mode sombre">
                    <i class="fas fa-moon text-white/70 text-sm" id="dark-icon"></i>
                </button>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('accueil') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('accueil') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                <i class="fas fa-home w-5"></i> Accueil
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                <i class="fas fa-chart-pie w-5"></i> Tableau de bord
            </a>
            <a href="{{ route('formulaire') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('formulaire') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                <i class="fas fa-brain w-5"></i> Nouvelle Prévision
            </a>
            <a href="{{ route('parcelles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('parcelles.*') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                <i class="fas fa-map-marked-alt w-5"></i> Mes Parcelles
            </a>
            <a href="{{ route('saisons.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('saisons.*') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                <i class="fas fa-calendar-alt w-5"></i> Mes Saisons
            </a>
            <a href="{{ route('historique.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('historique.*') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                <i class="fas fa-history w-5"></i> Historique IA
            </a>
            <a href="{{ route('notifications.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('notifications.*') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
                <i class="fas fa-bell w-5"></i> Notifications
                @php $nbNotifs = \App\Models\Notification::where('user_id', auth()->id())->where('lu', false)->count(); @endphp
                @if($nbNotifs > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $nbNotifs }}</span>
                @endif
            </a>
        </nav>

        {{-- Profil --}}
        <div class="p-4 border-t border-white/10 flex-shrink-0">
            <div class="relative">
                <button onclick="toggleDropdown()" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-white/10 transition-all duration-300 group">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-agri-400 to-cyan-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
                    </div>
                    <div class="flex-1 text-left overflow-hidden">
                        <p class="text-white font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                        <p class="text-white/50 text-xs truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <i class="fas fa-chevron-up text-white/50 text-xs group-hover:text-white transition-all" id="dropdown-arrow"></i>
                </button>

                <div id="user-dropdown" class="dropdown-menu absolute bottom-full left-0 right-0 mb-2 glass rounded-xl shadow-2xl overflow-hidden z-50">
                    <a href="{{ route('profil.edit') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-agri-50 transition-colors text-sm">
                        <i class="fas fa-user-edit text-agri-600 w-4"></i> Modifier mon profil
                    </a>
                    <a href="{{ route('profil.password') }}" class="flex items-center gap-3 px-4 py-3 text-slate-700 hover:bg-agri-50 transition-colors text-sm">
                        <i class="fas fa-key text-cyan-600 w-4"></i> Changer mot de passe
                    </a>
                    <div class="border-t border-slate-100"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors text-sm">
                            <i class="fas fa-sign-out-alt w-4"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-xs text-white/30 text-center mt-3">© 2026 AgriPredict AI</p>
        </div>
    </aside>

    {{-- ── CONTENU PRINCIPAL ───────────────────────── --}}
    <main class="flex flex-col min-h-screen">
        {{-- Header mobile (mobile uniquement) --}}
        <header class="md:hidden sticky top-0 z-40 px-4 py-3 glass-dark text-white flex items-center justify-between border-b border-white/10">
            <button onclick="toggleMobileSidebar()" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all">
                <i class="fas fa-bars text-white"></i>
            </button>
            <a href="{{ route('accueil') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 rounded-lg object-cover">
                <span class="font-bold text-sm" style="background: linear-gradient(90deg, #4ade80, #22d3ee, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    AgriPredict AI
                </span>
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('notifications.index') }}" class="relative w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all">
                    <i class="fas fa-bell text-white"></i>
                    @php $nbNotifsMobile = \App\Models\Notification::where('user_id', auth()->id())->where('lu', false)->count(); @endphp
                    @if($nbNotifsMobile > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                            {{ $nbNotifsMobile > 9 ? '9+' : $nbNotifsMobile }}
                        </span>
                    @endif
                </a>
                <button onclick="toggleDark()" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all">
                    <i class="fas fa-moon text-white text-sm" id="dark-icon-mobile"></i>
                </button>
            </div>
        </header>

        {{-- Contenu page --}}
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

{{-- ── MOBILE SIDEBAR (hors du flow) ─────────────── --}}
<div class="mobile-overlay" onclick="toggleMobileSidebar()"></div>

<aside class="mobile-sidebar glass-dark text-white" id="mobile-sidebar">
    <div class="p-6 border-b border-white/10 bg-gradient-to-r from-agri-500 to-cyan-500">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-lg object-cover">
                <span class="font-bold text-lg">AgriPredict AI</span>
            </div>
            <button onclick="toggleMobileSidebar()" class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="flex items-center gap-3 p-3 bg-white/10 rounded-xl">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->name)[1] ?? '', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-white/80 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    <nav class="p-4 space-y-1">
        <a href="{{ route('accueil') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('accueil') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-home w-5"></i><span class="font-medium">Accueil</span>
        </a>
        <a href="{{ route('dashboard') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-chart-pie w-5"></i><span class="font-medium">Tableau de bord</span>
        </a>
        <a href="{{ route('formulaire') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('formulaire') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-brain w-5"></i><span class="font-medium">Nouvelle Prévision</span>
        </a>
        <a href="{{ route('parcelles.index') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('parcelles.*') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-map-marked-alt w-5"></i><span class="font-medium">Mes Parcelles</span>
        </a>
        <a href="{{ route('saisons.index') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('saisons.*') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-calendar-alt w-5"></i><span class="font-medium">Mes Saisons</span>
        </a>
        <a href="{{ route('historique.index') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('historique.*') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-history w-5"></i><span class="font-medium">Historique IA</span>
        </a>
        <a href="{{ route('notifications.index') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('notifications.*') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
            <i class="fas fa-bell w-5"></i>
            <span class="font-medium">Notifications</span>
            @if(isset($nbNotifs) && $nbNotifs > 0)
                <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $nbNotifs }}</span>
            @endif
        </a>

        <hr class="border-white/10 my-3 mobile-menu-item">

        <a href="{{ route('profil.edit') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:bg-white/10 transition-all">
            <i class="fas fa-user-edit w-5"></i><span class="font-medium">Mon profil</span>
        </a>
        <a href="{{ route('profil.password') }}" class="mobile-menu-item flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:bg-white/10 transition-all">
            <i class="fas fa-key w-5"></i><span class="font-medium">Mot de passe</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mobile-menu-item w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/20 transition-all">
                <i class="fas fa-sign-out-alt w-5"></i><span class="font-medium">Déconnexion</span>
            </button>
        </form>
    </nav>

    <div class="p-4 border-t border-white/10 mt-auto">
        <p class="text-xs text-white/40 text-center">
            <i class="fas fa-leaf text-agri-400 mr-1"></i>© 2026 AgriPredict AI · Bénin
        </p>
    </div>
</aside>

{{-- ── BOUTON PWA ──────────────────────────────────── --}}
<button id="pwa-install-btn" class="pwa-install-btn hidden px-5 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-full shadow-2xl transition-all duration-300 flex items-center gap-2">
    <i class="fas fa-download"></i>
    <span class="hidden sm:inline">Installer l'app</span>
    <span class="sm:hidden">Installer</span>
</button>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// ── Dropdown profil desktop ───────────────────────────
function toggleDropdown() {
    const menu  = document.getElementById('user-dropdown');
    const arrow = document.getElementById('dropdown-arrow');
    menu.classList.toggle('active');
    arrow.classList.toggle('fa-chevron-up');
    arrow.classList.toggle('fa-chevron-down');
}
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('user-dropdown');
    const btn = e.target.closest('button[onclick="toggleDropdown()"]');
    if (!btn && dropdown && dropdown.classList.contains('active')) {
        dropdown.classList.remove('active');
        document.getElementById('dropdown-arrow').classList.add('fa-chevron-up');
        document.getElementById('dropdown-arrow').classList.remove('fa-chevron-down');
    }
});

// ── Mobile Sidebar ────────────────────────────────────
function toggleMobileSidebar() {
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.querySelector('.mobile-overlay');
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
    document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
}
document.querySelectorAll('.mobile-sidebar a').forEach(link => {
    link.addEventListener('click', () => {
        const sidebar = document.getElementById('mobile-sidebar');
        if (sidebar.classList.contains('active')) toggleMobileSidebar();
    });
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('mobile-sidebar');
        if (sidebar && sidebar.classList.contains('active')) toggleMobileSidebar();
    }
});

// ── Dark mode ─────────────────────────────────────────
function toggleDark() {
    const html = document.getElementById('html-root');
    const iconDesktop = document.getElementById('dark-icon');
    const iconMobile  = document.getElementById('dark-icon-mobile');
    html.classList.toggle('dark');
    const isDark = html.classList.contains('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    if (iconDesktop) iconDesktop.classList.replace(isDark ? 'fa-moon' : 'fa-sun', isDark ? 'fa-sun' : 'fa-moon');
    if (iconMobile)  iconMobile.classList.replace(isDark ? 'fa-moon' : 'fa-sun', isDark ? 'fa-sun' : 'fa-moon');
}
(function() {
    const theme = localStorage.getItem('theme');
    const html  = document.getElementById('html-root');
    const iconDesktop = document.getElementById('dark-icon');
    const iconMobile  = document.getElementById('dark-icon-mobile');
    if (theme === 'dark') {
        html.classList.add('dark');
        if (iconDesktop) iconDesktop.classList.replace('fa-moon', 'fa-sun');
        if (iconMobile)  iconMobile.classList.replace('fa-moon', 'fa-sun');
    }
})();

// ── Password toggle eye (global) ─────────────────────
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye   = document.getElementById(fieldId + '-eye');
    if (!field || !eye) return;
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// ── PWA Install ───────────────────────────────────────
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
        if (outcome === 'accepted') installBtn.classList.add('hidden');
        deferredPrompt = null;
    });
}
window.addEventListener('appinstalled', () => {
    if (installBtn) installBtn.classList.add('hidden');
});

// ── Service Worker ────────────────────────────────────
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('SW enregistré:', reg.scope))
            .catch(err => console.log('SW erreur:', err));
    });
}
</script>

@stack('scripts')
</body>
</html>