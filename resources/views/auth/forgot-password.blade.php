@extends('layouts.guest')
@section('title', 'Mot de passe oublié')

@section('contenu')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 rounded-2xl mx-auto mb-4 object-cover">
            <h2 class="text-3xl font-black text-white">Mot de passe oublié</h2>
            <p class="text-white/60 mt-2">Entrez votre email pour recevoir un lien de réinitialisation</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-100 text-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="glass rounded-2xl p-8 shadow-xl">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        placeholder="votre@email.com"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-agri-500 text-slate-800">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-xl transition-all">
                    <i class="fas fa-paper-plane mr-2"></i> Envoyer le lien
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-agri-600 transition-colors">
                    ← Retour à la connexion
                </a>
            </div>
        </div>
    </div>
</div>
@endsection