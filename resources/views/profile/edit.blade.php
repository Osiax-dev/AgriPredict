@extends('layouts.app')
@section('title', 'Modifier mon profil')

@section('contenu')
<div class="max-w-xl mx-auto animate-fade-in">
    <h2 class="text-3xl font-bold text-white mb-8">
        <i class="fas fa-user-edit text-agri-400 mr-3"></i>Modifier mon profil
    </h2>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass rounded-2xl p-8 shadow-xl">
        <form method="POST" action="{{ route('profil.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Nom complet</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-agri-500 text-slate-800">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-agri-500 text-slate-800">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Membre depuis</label>
                <p class="text-slate-500 text-sm">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
            </div>

            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-agri-500 to-agri-600 hover:from-agri-600 hover:to-agri-700 text-white font-semibold rounded-xl transition-all">
                <i class="fas fa-save mr-2"></i> Enregistrer
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('profil.password') }}" class="text-sm text-agri-600 hover:text-agri-700 font-medium">
                <i class="fas fa-key mr-1"></i> Changer mon mot de passe →
            </a>
        </div>
    </div>
</div>
@endsection