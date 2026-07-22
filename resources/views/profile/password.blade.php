@extends('layouts.app')
@section('title', 'Changer mot de passe')

@section('contenu')
<div class="max-w-xl mx-auto animate-fade-in">
    <h2 class="text-3xl font-bold text-white mb-8">
        <i class="fas fa-key text-cyan-400 mr-3"></i>Changer le mot de passe
    </h2>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass rounded-2xl p-8 shadow-xl">
        <form method="POST" action="{{ route('profil.password.update') }}">
            @csrf
            @method('PUT')

            {{-- Mot de passe actuel --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Mot de passe actuel</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password"
                        class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 text-slate-800">
          <button type="button" onclick="togglePassword('password')"
            class="absolute right-0  text-slate-100 hover:text-agri-600 transition-colors mr-3 mt-3 " >
            <i class="fas fa-eye" id="password-eye"></i>
        </button>
                </div>
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nouveau mot de passe --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Nouveau mot de passe</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 text-slate-800">
                          <button type="button" onclick="togglePassword('password')"
            class="absolute right-0  text-slate-100 hover:text-agri-600 transition-colors mr-3 mt-3 " >
            <i class="fas fa-eye" id="password-eye"></i>
        </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirmer mot de passe --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-600 mb-2">Confirmer le nouveau mot de passe</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 text-slate-800">
        <button type="button" onclick="togglePassword('password')"
            class="absolute right-0  text-slate-100 hover:text-agri-600 transition-colors mr-3 mt-3 " >
            <i class="fas fa-eye" id="password-eye"></i>
        </button>
                </div>
            </div>

            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-semibold rounded-xl transition-all">
                <i class="fas fa-lock mr-2"></i> Changer le mot de passe
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('profil.edit') }}" class="text-sm text-slate-500 hover:text-slate-700 font-medium">
                ← Retour au profil
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