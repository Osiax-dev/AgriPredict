@extends('layouts.app')
@section('title', 'Prévision en cours...')

@section('contenu')
<div class="max-w-2xl mx-auto animate-fade-in">

    {{-- Card principale --}}
    <div class="glass rounded-2xl p-10 shadow-xl text-center">

        {{-- Animation --}}
        <div class="relative w-32 h-32 mx-auto mb-8">
            {{-- Cercle tournant extérieur --}}
            <div class="absolute inset-0 rounded-full border-4 border-agri-500/20 border-t-agri-500 animate-spin"></div>
            {{-- Cercle tournant intérieur (sens inverse) --}}
            <div class="absolute inset-3 rounded-full border-4 border-cyan-500/20 border-b-cyan-500 animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
            {{-- Logo au centre --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 rounded-xl object-cover">
            </div>
        </div>

        <h2 class="text-2xl font-bold text-slate-800 mb-2">Prévision en cours...</h2>
        <p class="text-slate-500 mb-8" id="etape-texte">Initialisation du pipeline IA</p>

        {{-- Barre de progression --}}
        <div class="w-full bg-slate-100 rounded-full h-2 mb-4 overflow-hidden">
            <div id="progress-bar"
                class="h-2 rounded-full bg-gradient-to-r from-agri-500 to-cyan-500 transition-all duration-1000"
                style="width: 5%">
            </div>
        </div>

        {{-- Étapes --}}
        <div class="space-y-3 text-left mt-8">
            <div class="etape flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50" id="etape-1">
                <div class="w-8 h-8 rounded-full bg-agri-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-satellite text-agri-600 text-sm etape-icon"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-slate-700">Récupération NDVI Sentinel-2</p>
                    <p class="text-xs text-slate-400">Google Earth Engine</p>
                </div>
                <div class="etape-status text-slate-300">
                    <i class="fas fa-circle-notch fa-spin"></i>
                </div>
            </div>

            <div class="etape flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 opacity-40" id="etape-2">
                <div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-cloud-sun text-cyan-600 text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-slate-700">Données météorologiques</p>
                    <p class="text-xs text-slate-400">Open-Météo</p>
                </div>
                <div class="etape-status text-slate-300">
                    <i class="fas fa-clock"></i>
                </div>
            </div>

            <div class="etape flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 opacity-40" id="etape-3">
                <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-brain text-purple-600 text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-slate-700">Prédiction Random Forest</p>
                    <p class="text-xs text-slate-400">Modèle Python / scikit-learn</p>
                </div>
                <div class="etape-status text-slate-300">
                    <i class="fas fa-clock"></i>
                </div>
            </div>

            <div class="etape flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-50 opacity-40" id="etape-4">
                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lightbulb text-amber-600 text-sm"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-slate-700">Recommandations agronomiques</p>
                    <p class="text-xs text-slate-400">Groq AI (Llama 3.3)</p>
                </div>
                <div class="etape-status text-slate-300">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        {{-- Message timeout --}}
        <div id="timeout-msg" class="hidden mt-6 p-4 rounded-xl bg-amber-50 border border-amber-200">
            <p class="text-amber-700 text-sm font-medium">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                La prévision prend plus de temps que prévu. Encore quelques instants...
            </p>
        </div>

        {{-- Annuler --}}
        <div class="mt-8">
            <a href="{{ route('formulaire') }}"
                class="text-slate-400 hover:text-slate-600 text-sm transition-colors">
                <i class="fas fa-times mr-1"></i>Annuler et revenir au formulaire
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ── Animation des étapes ────────────────────────────────────────
const etapes = [
    { id: 'etape-1', texte: 'Récupération NDVI Sentinel-2...', progress: 20, duree: 15000 },
    { id: 'etape-2', texte: 'Données météorologiques...', progress: 45, duree: 5000 },
    { id: 'etape-3', texte: 'Prédiction Random Forest...', progress: 70, duree: 5000 },
    { id: 'etape-4', texte: 'Génération des recommandations IA...', progress: 90, duree: 8000 },
];

let etapeIndex = 0;

function validerEtape(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('opacity-40');
    el.classList.add('bg-agri-50');
    const status = el.querySelector('.etape-status');
    if (status) {
        status.innerHTML = '<i class="fas fa-check-circle text-agri-500"></i>';
    }
}

function activerEtape(index) {
    if (index >= etapes.length) return;
    const etape = etapes[index];

    // Valider l'étape précédente
    if (index > 0) validerEtape(etapes[index - 1].id);

    // Activer l'étape courante
    const el = document.getElementById(etape.id);
    if (el) {
        el.classList.remove('opacity-40');
        el.classList.add('bg-blue-50', 'border', 'border-blue-200');
        const status = el.querySelector('.etape-status');
        if (status) status.innerHTML = '<i class="fas fa-circle-notch fa-spin text-blue-400"></i>';
    }

    // Mettre à jour le texte et la barre
    document.getElementById('etape-texte').textContent = etape.texte;
    document.getElementById('progress-bar').style.width = etape.progress + '%';

    // Passer à l'étape suivante
    setTimeout(() => {
        etapeIndex++;
        activerEtape(etapeIndex);
    }, etape.duree);
}

// Démarrer l'animation
activerEtape(0);

// ── Timeout warning ────────────────────────────────────────────
setTimeout(() => {
    document.getElementById('timeout-msg').classList.remove('hidden');
}, 45000); // Avertissement après 45s

// ── Soumettre le formulaire via AJAX ──────────────────────────
const formData = new FormData();
@foreach(request()->all() as $key => $value)
    @if($key !== '_token')
        formData.append('{{ $key }}', '{{ $value }}');
    @endif
@endforeach
formData.append('_token', '{{ csrf_token() }}');

fetch('{{ route("prevision.prevoir") }}', {
    method: 'POST',
    body: formData,
})
.then(async response => {
    const text = await response.text();

    console.log("Status :", response.status);
    console.log(text);

    if (!response.ok) {
        throw new Error(text);
    }

    return text;
})
.then(html => {
    // Valider la dernière étape
    validerEtape('etape-4');
    document.getElementById('progress-bar').style.width = '100%';
    document.getElementById('etape-texte').textContent = 'Prévision terminée !';

    setTimeout(() => {
        document.open();
        document.write(html);
        document.close();
    }, 800);
})
.catch(async error => {
    console.error(error);
    alert(error.message);
});
</script>
@endpush
@endsection