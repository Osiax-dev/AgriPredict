@extends('layouts.guest')
@section('title', 'Réinitialiser le mot de passe')

@section('contenu')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 rounded-2xl mx-auto mb-4 object-cover">
            <h2 class="text-3xl font-black text-white">Nouveau mot de passe</h2>
            <p class="text-white/60 mt-2">Choisissez un nouveau mot de passe sécurisé</p>
        </div>

        <div class="glass rounded-2xl p-8 shadow-xl">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Nouveau mot de passe</label>
                    <input type="password" name="password"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-agri-500 text-slate-800">
                    @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-600 mb-2">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-agri-500 text-slate-800">
                </div>

                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-agri-500 to-cyan-500 text-white font-bold rounded-xl transition-all">
                    <i class="fas fa-lock mr-2"></i> Réinitialiser le mot de passe
                </button>
            </form>
        </div>
    </div>
</div>
@endsection