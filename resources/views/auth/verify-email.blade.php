@extends('layouts.guest')
@section('title', 'Vérifier votre email')

@section('contenu')
<div class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="w-full max-w-md">
        <div class="glass rounded-2xl p-8 shadow-xl text-center">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-agri-500 to-cyan-500 flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-envelope-open-text text-white text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 mb-3">Vérifiez votre email</h2>
            <p class="text-slate-600 mb-6">
                Un lien de vérification a été envoyé à votre adresse email.
                Cliquez sur le lien pour activer votre compte.
            </p>

            @if(session('success'))
                <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-agri-500 to-cyan-500 text-white font-bold rounded-xl transition-all mb-4">
                    <i class="fas fa-paper-plane mr-2"></i>Renvoyer le lien
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-500 hover:text-red-700 transition-colors">
                    <i class="fas fa-sign-out-alt mr-1"></i>Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection