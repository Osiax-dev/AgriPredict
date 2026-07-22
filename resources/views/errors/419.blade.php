@extends('layouts.guest')
@section('title', 'Session expirée')

@section('contenu')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="text-center animate-fade-in">

        <div class="w-32 h-32 mx-auto mb-8 relative">
            <div class="w-32 h-32 rounded-full bg-cyan-500/20 flex items-center justify-center">
                <i class="fas fa-clock text-cyan-400 text-5xl"></i>
            </div>
            <div class="absolute -top-2 -right-2 w-10 h-10 rounded-full bg-cyan-500/80 flex items-center justify-center">
                <span class="text-white font-black text-xs">419</span>
            </div>
        </div>

        <h1 class="text-6xl font-black text-white mb-4">419</h1>
        <h2 class="text-2xl font-bold text-white/80 mb-3">Session expirée</h2>
        <p class="text-white/50 mb-8 max-w-md mx-auto">
            Votre session a expiré pour des raisons de sécurité.
            Veuillez actualiser la page et réessayer.
        </p>

        <div class="flex items-center justify-center gap-4 flex-wrap">
            <button onclick="location.reload()"
                class="px-6 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 text-white font-bold rounded-xl transition-all shadow-lg">
                <i class="fas fa-redo mr-2"></i>Actualiser la page
            </button>
            <a href="{{ route('login') }}"
                class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all">
                <i class="fas fa-sign-in-alt mr-2"></i>Se reconnecter
            </a>
        </div>

        <div class="mt-12 flex items-center justify-center gap-2 text-white/30">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-6 h-6 rounded-lg object-cover opacity-50">
            <span class="text-sm">AgriPredict AI</span>
        </div>
    </div>
</div>
@endsection