<!DOCTYPE html>
<html lang="fr" id="html-root" class="">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgriPredict AI - @yield('title', 'Accueil')</title>

    {{-- ── PWA ──────────────────────────────────────── --}}
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#10b981">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="AgriPredict">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        .bg-agriculture {
            background-image: url('https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .bg-overlay {
            background: linear-gradient(135deg, rgba(6,78,59,0.88) 0%, rgba(5,150,105,0.82) 50%, rgba(6,145,178,0.80) 100%);
        }
        html.dark .bg-overlay {
            background: linear-gradient(135deg, rgba(2,6,23,0.97) 0%, rgba(15,23,42,0.95) 50%, rgba(2,6,23,0.97) 100%) !important;
        }
        .glass .text-slate-800, .glass h3, .glass h4 { color: #1e293b; }
        .glass .text-slate-600, .glass p { color: #475569; }
        .glass .text-slate-500 { color: #64748b; }
        html.dark .glass .text-slate-800,
        html.dark .glass h3,
        html.dark .glass h4 { color: #f1f5f9 !important; }
        html.dark .glass .text-slate-600,
        html.dark .glass p { color: #94a3b8 !important; }
        html.dark .glass .text-slate-500 { color: #64748b !important; }

        /* ═══════════════════════════════════════════════════════
           MOBILE MENU & SIDEBAR
           ═══════════════════════════════════════════════════════ */
        
        /* Overlay sombre */
        .mobile-menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Sidebar mobile */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            right: -100%;
            width: 85%;
            max-width: 320px;
            height: 100vh;
            background: white;
            z-index: 999;
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.2);
        }
        .mobile-sidebar.active {
            right: 0;
        }
        html.dark .mobile-sidebar {
            background: #1e293b;
        }

        /* Animation des items du menu */
        .mobile-sidebar .menu-item {
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
        }
        .mobile-sidebar.active .menu-item {
            opacity: 1;
            transform: translateX(0);
        }
        .mobile-sidebar.active .menu-item:nth-child(1) { transition-delay: 0.1s; }
        .mobile-sidebar.active .menu-item:nth-child(2) { transition-delay: 0.15s; }
        .mobile-sidebar.active .menu-item:nth-child(3) { transition-delay: 0.2s; }
        .mobile-sidebar.active .menu-item:nth-child(4) { transition-delay: 0.25s; }
        .mobile-sidebar.active .menu-item:nth-child(5) { transition-delay: 0.3s; }

        /* Bouton hamburger */
        .hamburger-btn {
            display: none;
        }
        @media (max-width: 768px) {
            .hamburger-btn {
                display: flex;
            }
            .desktop-menu {
                display: none;
            }
        }

        /* Bouton installation PWA */
        .pwa-install-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .pwa-install-btn:hover {
            animation: none;
            transform: scale(1.1);
        }

        /* Dropdown desktop */
        .dropdown-enter {
            animation: dropdownFadeIn 0.2s ease-out;
        }
        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-agriculture font-sans text-slate-800 antialiased min-h-screen">
    <div class="bg-overlay min-h-screen">

        {{-- ══════════════════════════════════════════════════════════
             NAVBAR
             ══════════════════════════════════════════════════════════ --}}
        <nav class="fixed top-0 left-0 right-0 z-50 px-4 md:px-6 py-4 flex items-center justify-between backdrop-blur-sm bg-black/20 border-b border-white/10">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 rounded-lg object-cover">
                <span class="font-bold text-white text-base md:text-lg">
                    <span style="background: linear-gradient(90deg, #4ade80, #22d3ee, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                        AgriPredict AI
                    </span>
                </span>
            </a>

            {{-- Actions droite --}}
            <div class="flex items-center gap-2 md:gap-3">
                {{-- Bouton Dark Mode --}}
                <button onclick="toggleDark()" id="dark-toggle"
                    class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all border border-white/20"
                    title="Changer le thème">
                    <i class="fas fa-moon text-white text-sm" id="dark-icon"></i>
                </button>

                @auth
                    {{-- ═══════════════════════════════════════════
                         UTILISATEUR CONNECTÉ
                         ═══════════════════════════════════════════ --}}

                    {{-- Menu desktop --}}
                    <div class="desktop-menu flex items-center gap-3">
                        {{-- Lien rapide "Mon avis" --}}
                        <a href="{{ route('reviews.mine.page') }}"
                            class="hidden lg:flex items-center gap-2 px-4 py-2 text-white/80 hover:text-white text-sm font-medium transition-colors"
                            title="Donner ou modifier mon avis">
                            <i class="fas fa-star text-amber-400"></i>
                            <span>Mon avis</span>
                        </a>

                        {{-- Dropdown utilisateur --}}
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-3 py-2 bg-white/10 hover:bg-white/20 rounded-xl transition-all border border-white/20">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-agri-400 to-cyan-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('') }}
                                </div>
                                <span class="text-white text-sm font-medium hidden md:inline max-w-[120px] truncate">
                                    {{ Auth::user()->name }}
                                </span>
                                <i class="fas fa-chevron-down text-white/60 text-xs transition-transform group-hover:rotate-180"></i>
                            </button>

                            {{-- Menu dropdown --}}
                            <div class="absolute right-0 mt-2 w-56 glass rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-white/20 dropdown-enter overflow-hidden">
                                <div class="px-4 py-3 bg-gradient-to-r from-agri-50 to-cyan-50 border-b border-slate-200">
                                    <p class="text-xs text-slate-500 font-medium">Connecté en tant que</p>
                                    <p class="text-xs text-slate-500 font-medium">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                </div>

                                <div class="py-1">
                                    <a href="{{ url('/dashboard') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-slate-700 hover:bg-white/50 transition-colors text-sm">
                                        <i class="fas fa-tachometer-alt text-agri-600 w-5"></i>
                                        <span>Dashboard</span>
                                    </a>
                                    <a href="{{ route('reviews.mine.page') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-slate-700 hover:bg-white/50 transition-colors text-sm">
                                        <i class="fas fa-star text-amber-500 w-5"></i>
                                        <span>Mon avis</span>
                                    </a>
                                    <a href="{{ route('legal.guide') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('legal.guide') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-black shadow-lg' : 'text-black/80 hover:bg-white/10' }}">
                                     <i class="fas fa-book-open w-5"></i> <span>Guide d'utilisation</span>
</a>
                                </div>

                                <div class="border-t border-slate-200">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center gap-3 px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors text-sm">
                                            <i class="fas fa-sign-out-alt w-5"></i>
                                            <span>Déconnexion</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bouton hamburger (mobile) --}}
                    <button onclick="toggleMobileMenu()" class="hamburger-btn w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all border border-white/20">
                        <i class="fas fa-bars text-white text-sm"></i>
                    </button>

                @else
                    {{-- ═══════════════════════════════════════════
                         UTILISATEUR NON CONNECTÉ
                         ═══════════════════════════════════════════ --}}
                    <div class="desktop-menu flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-white/80 hover:text-white text-sm font-medium transition-colors">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 bg-agri-500 hover:bg-agri-600 text-white text-sm font-semibold rounded-xl transition-all">
                            Commencer
                        </a>
                    </div>

                    {{-- Bouton hamburger (mobile) --}}
                    <button onclick="toggleMobileMenu()" class="hamburger-btn w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all border border-white/20">
                        <i class="fas fa-bars text-white text-sm"></i>
                    </button>
                @endauth
            </div>
        </nav>

        {{-- ══════════════════════════════════════════════════════════
             MOBILE SIDEBAR
             ══════════════════════════════════════════════════════════ --}}
        <div class="mobile-menu-overlay" onclick="toggleMobileMenu()"></div>
        
        <div class="mobile-sidebar" id="mobile-sidebar">
            {{-- Header --}}
            <div class="p-6 bg-gradient-to-r from-agri-500 to-cyan-500 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 rounded-lg object-cover">
                        <span class="font-bold text-lg">AgriPredict AI</span>
                    </div>
                    <button onclick="toggleMobileMenu()" class="w-8 h-8 rounded-lg bg-white/20 hover:bg-white/30 flex items-center justify-center transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                @auth
                    <div class="flex items-center gap-3 p-3 bg-white/10 rounded-xl backdrop-blur-sm">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">
                            {{ collect(explode(' ', Auth::user()->name))->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('') }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-sm truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-white/80 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-white/90">Bienvenue sur AgriPredict AI</p>
                @endauth
            </div>

            {{-- Menu items --}}
            <div class="p-4 space-y-2">
                <a href="{{ url('/') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors text-slate-700 dark:text-slate-200">
                    <i class="fas fa-home text-agri-600 w-5"></i>
                    <span class="font-medium">Accueil</span>
                </a>


                <a href="{{ url('/#avis') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors text-slate-700 dark:text-slate-200">
                    <i class="fas fa-comments text-purple-600 w-5"></i>
                    <span class="font-medium">Témoignages</span>
                </a>

                @auth
                    <hr class="border-slate-200 dark:border-slate-700 my-3">
                    
                    <a href="{{ url('/dashboard') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors text-slate-700 dark:text-slate-200">
                        <i class="fas fa-tachometer-alt text-agri-600 w-5"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('reviews.mine.page') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors text-slate-700 dark:text-slate-200">
                        <i class="fas fa-star text-amber-500 w-5"></i>
                        <span class="font-medium">Mon avis</span>
                    </a>
                    <a href="{{ route('legal.guide') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('legal.guide') ? 'bg-gradient-to-r from-agri-500 to-agri-600 text-white shadow-lg' : 'text-white/80 hover:bg-white/10' }}">
    <i class="fas fa-book-open w-5"></i> <span class="font-medium">Guide d'utilisation</span>
</a>

                    <hr class="border-slate-200 dark:border-slate-700 my-3">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="menu-item w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-red-600">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span class="font-medium">Déconnexion</span>
                        </button>
                    </form>
                @else
                    <hr class="border-slate-200 dark:border-slate-700 my-3">

                    <a href="{{ route('login') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl bg-agri-500 hover:bg-agri-600 text-white transition-colors">
                        <i class="fas fa-sign-in-alt w-5"></i>
                        <span class="font-medium">Se connecter</span>
                    </a>

                    <a href="{{ route('register') }}" class="menu-item flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-agri-500 text-agri-600 dark:text-agri-400 hover:bg-agri-50 dark:hover:bg-agri-900/20 transition-colors">
                        <i class="fas fa-user-plus w-5"></i>
                        <span class="font-medium">Créer un compte</span>
                    </a>
                @endauth
            </div>

            {{-- Footer --}}
            <div class="p-4 border-t border-slate-200 dark:border-slate-700 mt-auto">
                <p class="text-xs text-slate-500 text-center">
                    <i class="fas fa-leaf text-agri-500 mr-1"></i>
                    AgriPredict AI · Bénin 2026
                </p>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════════
             CONTENU PRINCIPAL
             ══════════════════════════════════════════════════════════ --}}
        <div class="pt-16">
            @yield('contenu')
        </div>

        {{-- ══════════════════════════════════════════════════════════
             BOUTON INSTALLATION PWA
             ══════════════════════════════════════════════════════════ --}}
        <button id="pwa-install-btn" class="pwa-install-btn hidden px-6 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-full shadow-2xl transition-all duration-300 flex items-center gap-2">
            <i class="fas fa-download"></i>
            <span>Installer l'app</span>
        </button>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SCRIPTS
         ══════════════════════════════════════════════════════════ --}}

    {{-- Mobile menu toggle --}}
    <script>
    function toggleMobileMenu() {
        const sidebar = document.getElementById('mobile-sidebar');
        const overlay = document.querySelector('.mobile-menu-overlay');
        const body = document.body;

        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        
        // Empêcher le scroll quand le menu est ouvert
        if (sidebar.classList.contains('active')) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = '';
        }
    }

    // Fermer le menu quand on clique sur un lien
    document.querySelectorAll('.mobile-sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            toggleMobileMenu();
        });
    });
    </script>

    {{-- Dark mode toggle --}}
    <script>
    function toggleDark() {
        const html = document.getElementById('html-root');
        const icon = document.getElementById('dark-icon');
        html.classList.toggle('dark');
        if (html.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
            icon.classList.replace('fa-moon', 'fa-sun');
        } else {
            localStorage.setItem('theme', 'light');
            icon.classList.replace('fa-sun', 'fa-moon');
        }
    }

    (function() {
        const theme = localStorage.getItem('theme');
        const html  = document.getElementById('html-root');
        const icon  = document.getElementById('dark-icon');
        if (theme === 'dark') {
            html?.classList.add('dark');
            if (icon) icon.classList.replace('fa-moon', 'fa-sun');
        }
    })();
    </script>

    {{-- PWA Install --}}
    <script>
    let deferredPrompt;
    const installBtn = document.getElementById('pwa-install-btn');

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        installBtn.classList.remove('hidden');
    });

    installBtn.addEventListener('click', async () => {
        if (!deferredPrompt) return;
        
        deferredPrompt.prompt();
        const { outcome } = await deferredPrompt.userChoice;
        
        if (outcome === 'accepted') {
            installBtn.classList.add('hidden');
        }
        
        deferredPrompt = null;
    });

    window.addEventListener('appinstalled', () => {
        installBtn.classList.add('hidden');
        console.log('✅ PWA installée avec succès');
    });
    </script>

    {{-- Service Worker PWA --}}
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(reg => console.log('✅ Service Worker enregistré:', reg.scope))
                .catch(err => console.log('❌ Erreur Service Worker:', err));
        });
    }
    </script>

    {{-- Scripts spécifiques aux pages --}}
    @stack('scripts')
</body>
</html>