@extends('layouts.app')
@section('title', 'Nouvelle Prévision')

@section('contenu')
<div class="max-w-3xl mx-auto animate-slide-up">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-white mb-2">
            <i class="fas fa-brain text-agri-400 mr-3"></i>Nouvelle Prévision
        </h2>
        <p class="text-white/70">Choisissez une parcelle et une saison pour lancer l'analyse IA.</p>
    </div>

    @if($parcelles->isEmpty())
        <div class="glass rounded-2xl p-12 text-center">
            <i class="fas fa-seedling text-6xl text-agri-300 mb-4"></i>
            <p class="text-slate-600 text-lg mb-4">Aucune parcelle enregistrée.</p>
            <a href="{{ route('parcelles.create') }}" class="text-agri-600 font-semibold hover:text-agri-700">
                Ajouter une parcelle d'abord →
            </a>
        </div>
    @else
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif
        @if(request('error'))
    <div class="mb-6 p-4 rounded-xl bg-red-500/20 border border-red-500/30 text-red-100">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        La prévision a échoué. Vérifiez votre connexion et réessayez.
    </div>
@endif

<form method="GET" action="{{ route('prevision.chargement') }}" id="form-prevision">
            @csrf

            {{-- Sélection parcelle --}}
            <div class="mb-6">
                <label class="block font-semibold text-slate-700 mb-3">
                    <i class="fas fa-map-marker-alt text-agri-600 mr-2"></i>Parcelle
                </label>
                <select name="parcelle_id" id="select-parcelle" onchange="chargerParcelle()"
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all text-slate-700 font-medium">
                    <option value="">-- Choisir une parcelle --</option>
                    @foreach($parcelles as $parcelle)
                        <option value="{{ $parcelle->id }}"
                            data-superficie="{{ $parcelle->superficie }}"
                            data-type_sol="{{ $parcelle->type_sol }}"
                            data-lat="{{ $parcelle->lat }}"
                            data-lng="{{ $parcelle->lng }}"
                            data-culture="{{ $parcelle->culture }}"
                            data-commune="{{ $parcelle->commune }}"
                            data-notes="{{ $parcelle->notes }}"
                            {{ old('parcelle_id', request('parcelle_id')) == $parcelle->id ? 'selected' : '' }}>
                            {{ $parcelle->nom }}@if($parcelle->commune) — {{ $parcelle->commune }}@endif
                        </option>
                    @endforeach
                </select>
                @error('parcelle_id')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Aperçu parcelle --}}
            <div id="apercu-parcelle" class="bg-gradient-to-r from-agri-50 to-cyan-50 rounded-xl p-6 mb-6 hidden border border-agri-200">
                <h4 class="text-agri-700 font-bold mb-4 text-sm uppercase tracking-wider">
                    <i class="fas fa-info-circle mr-2"></i>Informations de la parcelle
                </h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-slate-600 text-sm">Superficie : <strong id="info-superficie" class="text-slate-800"></strong></div>
                    <div class="text-slate-600 text-sm">Culture : <strong id="info-culture" class="text-slate-800"></strong></div>
                    <div class="text-slate-600 text-sm">Sol : <strong id="info-sol" class="text-slate-800"></strong></div>
                    <div class="text-slate-600 text-sm">GPS : <strong id="info-gps" class="text-slate-800"></strong></div>
                </div>
            </div>

            {{-- Aperçu saison détectée (région/climat) --}}
            <div id="apercu-saison-climat" class="hidden mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-sm">
                <div class="flex items-center gap-2 text-amber-700 font-semibold mb-1">
                    <i class="fas fa-cloud-sun-rain"></i>
                    <span id="climat-region-label"></span>
                </div>
                <p class="text-slate-600" id="climat-type-label"></p>
                <p class="text-slate-500 text-xs mt-1" id="climat-meteo-label"></p>
            </div>

            {{-- Champs cachés auto-remplis depuis la parcelle --}}
            <input type="hidden" name="superficie" id="h-superficie">
            <input type="hidden" name="type_sol"   id="h-type_sol">
            <input type="hidden" name="lat"         id="h-lat">
            <input type="hidden" name="lng"         id="h-lng">
            <input type="hidden" name="culture"     id="h-culture">

            {{-- Sélection saison --}}
            <div class="mb-6">
                <label class="block font-semibold text-slate-700 mb-3">
                    <i class="fas fa-calendar-alt text-cyan-600 mr-2"></i>Saison
                </label>
                @if($saisons->isEmpty())
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-amber-700 text-sm">
                        ⚠️ Aucune saison enregistrée.
                        <a href="{{ route('saisons.create') }}" class="font-semibold text-agri-600 ml-1">Créer une saison</a>
                    </div>
                @else
                    <select name="saison_id" id="select-saison"
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all text-slate-700 font-medium">
                        <option value="">-- Choisir une saison --</option>
                        @foreach($saisons as $saison)
                            @php
                                $today   = now();
                                $enCours = $today >= $saison->date_debut && $today <= $saison->date_fin;
                            @endphp
                            <option value="{{ $saison->id }}"
                                data-parcelle-id="{{ $saison->parcelle_id }}"
                                data-en-cours="{{ $enCours ? '1' : '0' }}"
                                {{ old('saison_id', $enCours ? $saison->id : '') == $saison->id ? 'selected' : '' }}>
                                {{ $saison->nom }}
                                ({{ $saison->date_debut->format('d/m/Y') }} → {{ $saison->date_fin->format('d/m/Y') }})
                                {{ $enCours ? '🟢 En cours' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <p id="saison-auto-note" class="text-xs text-agri-600 mt-1 hidden">
                        <i class="fas fa-magic mr-1"></i>Saison liée à cette parcelle sélectionnée automatiquement.
                    </p>
                    @error('saison_id')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                @endif
            </div>

            {{-- Année --}}
            <div class="mb-6">
                <label class="block font-semibold text-slate-700 mb-3">
                    <i class="fas fa-calendar text-amber-600 mr-2"></i>Année de prévision
                </label>
                <input type="number" name="annee"
                    value="{{ old('annee', date('Y')) }}"
                    min="2000" max="2030"
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all text-slate-700 font-medium">
                @error('annee')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Notes / Observations --}}
            <div class="mb-8">
                <label class="block font-semibold text-slate-700 mb-3">
                    <i class="fas fa-comment-alt text-purple-500 mr-2"></i>
                    Observations (optionnel)
                </label>
                <textarea name="notes" id="h-notes" rows="3"
                    placeholder="Décrivez l'état actuel de votre parcelle, problèmes observés, traitements appliqués..."
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-400 focus:ring-2 focus:ring-purple-200 transition-all text-slate-700 resize-none">{{ old('notes') }}</textarea>
                <p class="text-xs text-slate-400 mt-1">
                    <i class="fas fa-info-circle mr-1"></i>
                    Ces informations sont transmises à l'IA pour personnaliser les recommandations agronomiques.
                </p>
                @error('notes')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Bouton soumettre --}}
            <button type="submit" id="btn-submit" disabled
                class="w-full py-4 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 disabled:from-slate-300 disabled:to-slate-400 disabled:cursor-not-allowed text-white font-bold rounded-xl shadow-lg shadow-agri-500/30 transition-all duration-300 text-lg">
                <i class="fas fa-sparkles mr-2"></i> Lancer la prévision IA
            </button>

            <p class="text-center text-slate-500 text-sm mt-4">
                <i class="fas fa-clock mr-1"></i> L'analyse satellite prend environ 30–60 secondes
            </p>
        </form>
    @endif
</div>

@push('scripts')
<script>
function chargerParcelle() {
    const select  = document.getElementById('select-parcelle');
    const option  = select.options[select.selectedIndex];
    const apercu  = document.getElementById('apercu-parcelle');
    const btn     = document.getElementById('btn-submit');
    const climatBox = document.getElementById('apercu-saison-climat');

    if (!option.value) {
        apercu.classList.add('hidden');
        climatBox.classList.add('hidden');
        btn.disabled = true;
        return;
    }

    document.getElementById('h-superficie').value = option.dataset.superficie;
    document.getElementById('h-type_sol').value   = option.dataset.type_sol;
    document.getElementById('h-lat').value         = option.dataset.lat;
    document.getElementById('h-lng').value         = option.dataset.lng;
    document.getElementById('h-culture').value     = option.dataset.culture;

    const notesField = document.getElementById('h-notes');
    if (notesField && !notesField.value && option.dataset.notes) {
        notesField.value = option.dataset.notes;
    }

    document.getElementById('info-superficie').textContent = option.dataset.superficie + ' ha';
    document.getElementById('info-culture').textContent    = option.dataset.culture;
    document.getElementById('info-sol').textContent        = option.dataset.type_sol;
    document.getElementById('info-gps').textContent        =
        parseFloat(option.dataset.lat).toFixed(4) + ', ' + parseFloat(option.dataset.lng).toFixed(4);

    apercu.classList.remove('hidden');
    btn.disabled = false;

    // 1. Auto-sélection de la saison liée à cette parcelle si elle existe
    selectionnerMeilleureSaison(option.value);

    // 2. Affichage de la région/saison climatique détectée
    afficherClimatParcelle(option.value);
}

function selectionnerMeilleureSaison(parcelleId) {
    const selectSaison = document.getElementById('select-saison');
    if (!selectSaison) return;

    const note = document.getElementById('saison-auto-note');
    let saisonParcelle = null;
    let saisonEnCours = null;

    for (const opt of selectSaison.options) {
        if (opt.dataset.parcelleId === parcelleId) {
            saisonParcelle = opt;
        }
        if (opt.dataset.enCours === '1' && !saisonEnCours) {
            saisonEnCours = opt;
        }
    }

    if (saisonParcelle) {
        selectSaison.value = saisonParcelle.value;
        note.classList.remove('hidden');
    } else {
        note.classList.add('hidden');
        if (saisonEnCours) {
            selectSaison.value = saisonEnCours.value;
        }
    }
}

const labelsType = {
    'saison_pluies': 'Saison des pluies',
    'saison_seche': 'Saison sèche',
    'grande_saison_pluies': 'Grande saison des pluies',
    'petite_saison_seche': 'Petite saison sèche',
    'petite_saison_pluies': 'Petite saison des pluies',
    'grande_saison_seche': 'Grande saison sèche',
};

const labelsCampagne = {
    'unique': 'Campagne unique',
    '1ere_campagne': '1ère campagne',
    '2eme_campagne': '2ème campagne',
    'transition': 'Période de transition',
    'hors_saison': 'Hors saison',
};

function afficherClimatParcelle(parcelleId) {
    const box = document.getElementById('apercu-saison-climat');
    box.classList.remove('hidden');
    document.getElementById('climat-region-label').textContent = 'Détection en cours...';
    document.getElementById('climat-type-label').textContent = '';
    document.getElementById('climat-meteo-label').textContent = '';

    fetch(`/saisons/infos-parcelle/${parcelleId}`)
        .then(r => r.json())
        .then(data => {
            const regionLabel = data.region === 'nord' ? '🌵 Région Nord' : '🌴 Région Sud';
            document.getElementById('climat-region-label').textContent = regionLabel;
            document.getElementById('climat-type-label').textContent =
                (labelsType[data.type_saison] || data.type_saison) + ' · ' + (labelsCampagne[data.campagne] || data.campagne);

            if (data.pluies_confirmees !== null) {
                const meteoTxt = data.pluies_confirmees
                    ? `✅ Pluies confirmées (${data.cumul_pluies_mm} mm sur 15 jours)`
                    : `⚠️ Pluies pas encore confirmées (${data.cumul_pluies_mm ?? 0} mm sur 15 jours)`;
                document.getElementById('climat-meteo-label').textContent = meteoTxt;
            }
        })
        .catch(() => {
            document.getElementById('climat-region-label').textContent = '⚠️ Détection climat impossible';
        });
}

document.getElementById('form-prevision').addEventListener('submit', function() {
    const btn = document.getElementById('btn-submit');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Analyse en cours...';
});

window.onload = function() {
    const select = document.getElementById('select-parcelle');
    if (select && select.value) chargerParcelle();
};
</script>
@endpush
@endsection