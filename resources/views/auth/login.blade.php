@extends('layouts.guest')
@section('title', 'Connexion')

@section('contenu')
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="glass rounded-2xl p-8 shadow-2xl w-full max-w-md animate-slide-up">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo"
                class="w-16 h-16 rounded-2xl mx-auto mb-4 object-cover shadow-lg animate-float">
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Connexion</h2>
            <p class="text-slate-600">Accédez à votre espace AgriPredict AI</p>
        </div>

        {{-- Messages --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        {{-- Bouton Google --}}
        <a href="{{ route('auth.google') }}"
            class="w-full flex items-center justify-center gap-3 py-3 px-4 border-2 border-slate-200 hover:border-agri-400 hover:bg-agri-50 rounded-xl transition-all duration-300 mb-6 group">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span class="text-slate-700 font-semibold group-hover:text-agri-700 transition-colors">
                Continuer avec Google
            </span>
        </a>

        {{-- Séparateur --}}
        <div class="flex items-center gap-4 mb-6">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span class="text-slate-400 text-sm font-medium">ou</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    <i class="fas fa-envelope text-agri-600 mr-2"></i>Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all text-slate-800"
                    placeholder="votre@email.com">
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
<div class="mb-2">
    <label class="block text-sm font-semibold text-slate-700 mb-2">
        <i class="fas fa-lock text-agri-600 mr-2"></i>Mot de passe
    </label>
    <div class="relative">
        <input type="password" name="password" id="password" required
            class="w-full px-4 py-3 pr-12 border-2 border-slate-200 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all text-slate-800"
            placeholder="••••••••">
        <button type="button" onclick="togglePassword('password')"
            class="absolute right-0  text-slate-100 hover:text-agri-600 transition-colors mr-3 mt-3 " >
            <i class="fas fa-eye" id="password-eye"></i>
        </button>
    </div>
    @error('password')
        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
    @enderror
</div>
            <div class="flex items-center justify-between mb-6 mt-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 accent-agri-500">
                    <span class="text-sm text-slate-600">Se souvenir de moi</span>
                </label>
                <a href="{{ route('password.request') }}"
                    class="text-sm text-agri-600 hover:text-agri-700 font-medium transition-colors">
                    Mot de passe oublié ?
                </a>
            </div>

            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-xl shadow-lg shadow-agri-500/30 transition-all">
                <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-slate-600 text-sm">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-agri-600 hover:text-agri-700 font-semibold">
                    Créer un compte
                </a>
            </p>
        </div>

        <div class="mt-4 pt-4 border-t border-slate-200 text-center">
            <a href="{{ route('accueil') }}" class="text-slate-500 hover:text-slate-700 text-sm">
                <i class="fas fa-arrow-left mr-2"></i>Retour à l'accueil
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye   = document.getElementById(fieldId + '-eye');
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush
@endsection