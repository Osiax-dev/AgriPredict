@extends('layouts.guest')
@section('title', 'Page introuvable')

@section('contenu')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="text-center animate-fade-in">

        {{-- Icône --}}
        <div class="w-32 h-32 mx-auto mb-8 relative">
            <div class="w-32 h-32 rounded-full bg-agri-500/20 flex items-center justify-center">
                <i class="fas fa-seedling text-agri-400 text-5xl animate-float"></i>
            </div>
            <div class="absolute -top-2 -right-2 w-10 h-10 rounded-full bg-red-500/80 flex items-center justify-center">
                <span class="text-white font-black text-sm">404</span>
            </div>
        </div>

        {{-- Texte --}}
        <h1 class="text-6xl font-black text-white mb-4">404</h1>
        <h2 class="text-2xl font-bold text-white/80 mb-3">Page introuvable</h2>
        <p class="text-white/50 mb-8 max-w-md mx-auto">
            Cette page n'existe pas ou a été déplacée.
            Retournez à l'accueil pour continuer.
        </p>

        {{-- Actions --}}
        <div class="flex items-center justify-center gap-4 flex-wrap">
            <a href="{{ url('/') }}"
                class="px-6 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-xl transition-all shadow-lg">
                <i class="fas fa-home mr-2"></i>Retour à l'accueil
            </a>
            <button onclick="history.back()"
                class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Page précédente
            </button>
        </div>

        {{-- Logo --}}
        <div class="mt-12 flex items-center justify-center gap-2 text-white/30">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-6 h-6 rounded-lg object-cover opacity-50">
            <span class="text-sm">AgriPredict AI</span>
        </div>
    </div>
</div>
@endsection