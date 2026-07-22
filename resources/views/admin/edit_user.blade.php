@extends('layouts.admin')
@section('title', 'Modifier - ' . $user->name)

@section('contenu')
<div class="max-w-xl mx-auto animate-fade-in">

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.index') }}" class="text-white/70 hover:text-white transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-3xl font-bold text-white">
            <i class="fas fa-user-edit text-agri-400 mr-3"></i>Modifier {{ $user->name }}
        </h2>
    </div>

    <div class="glass rounded-2xl p-8 shadow-xl">
        <form method="POST" action="{{ route('admin.update_user', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Nom complet</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-agri-500 text-slate-800">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-agri-500 text-slate-800">
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 py-3 bg-gradient-to-r from-agri-500 to-agri-600 text-white font-semibold rounded-xl transition-all">
                    <i class="fas fa-save mr-2"></i> Enregistrer
                </button>
                <a href="{{ route('admin.index') }}"
                    class="flex-1 py-3 bg-slate-100 text-slate-700 font-semibold rounded-xl text-center transition-all hover:bg-slate-200">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection