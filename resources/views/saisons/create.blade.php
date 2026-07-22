@extends('layouts.app')

@section('title', 'Nouvelle Saison')

@section('contenu')
<div class="max-w-3xl mx-auto animate-slide-up">
    <div class="glass rounded-2xl p-8 shadow-xl">

        <h2 class="text-2xl font-bold text-slate-800 mb-2">
            <i class="fas fa-calendar-plus text-cyan-600 mr-2"></i>
            Nouvelle Saison
        </h2>

        <p class="text-slate-500 mb-6">
            Définissez une nouvelle saison agricole.
        </p>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                @foreach($errors->all() as $error)
                    <div class="text-red-600 text-sm">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('saisons.store') }}">
            @csrf

            {{-- Nom --}}
            <div class="mb-5">
                <label class="block font-semibold text-slate-700 mb-2">
                    Nom de la saison
                </label>

                <input
                    type="text"
                    name="nom"
                    value="{{ old('nom') }}"
                    placeholder="Ex : Grande saison 2026"
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200"
                >

                @error('nom')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Parcelle --}}
            <div class="mb-5">
                <label class="block font-semibold text-slate-700 mb-2">
                    Parcelle concernée (optionnel)
                </label>

                <select
                    name="parcelle_id"
                    id="parcelle_id"
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200"
                >
                    <option value="">-- Aucune --</option>
                    @foreach($parcelles as $parcelle)
                        <option value="{{ $parcelle->id }}" {{ old('parcelle_id') == $parcelle->id ? 'selected' : '' }}>
                            {{ $parcelle->nom }} ({{ $parcelle->commune }}, {{ $parcelle->departement }})
                        </option>
                    @endforeach
                </select>

                @error('parcelle_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                {{-- Zone d'affichage de la saison détectée --}}
                <div id="saison-detectee" class="hidden mt-3 p-4 rounded-xl bg-agri-50 border border-agri-200 text-sm">
                    <div class="flex items-center gap-2 text-agri-700 font-semibold mb-1">
                        <i class="fas fa-cloud-sun-rain"></i>
                        <span id="saison-region-label"></span>
                    </div>
                    <p class="text-slate-600" id="saison-type-label"></p>
                    <p class="text-slate-500 text-xs mt-1" id="saison-meteo-label"></p>
                </div>
            </div>

            {{-- Culture --}}
            <div class="mb-5">
                <label class="block font-semibold text-slate-700 mb-2">
                    Culture (optionnel)
                </label>

                <select
                    name="culture"
                    class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200"
                >
                    <option value="">-- Aucune --</option>

                    <option value="Maïs">Maïs</option>
                    <option value="Riz">Riz</option>
                    <option value="Niébé">Niébé</option>
                    <option value="Arachide">Arachide</option>
                    <option value="Soja">Soja</option>
                    <option value="Goussi">Goussi</option>
                    <option value="Tomate">Tomate</option>
                    <option value="Piment">Piment</option>
                    <option value="Gombo">Gombo</option>
                    <option value="Oignon">Oignon</option>
                    <option value="Ananas">Ananas</option>
                    <option value="Coton">Coton</option>
                </select>

                @error('culture')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Dates --}}
            <div class="grid grid-cols-2 gap-4 mb-6">

                <div>
                    <label class="block font-semibold text-slate-700 mb-2">
                        Date de début
                    </label>

                    <input
                        type="date"
                        name="date_debut"
                        value="{{ old('date_debut') }}"
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200"
                    >

                    @error('date_debut')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-2">
                        Date de fin
                    </label>

                    <input
                        type="date"
                        name="date_fin"
                        value="{{ old('date_fin') }}"
                        class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200"
                    >

                    @error('date_fin')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- Boutons --}}
            <div class="flex gap-3">

                <button
                    type="submit"
                    class="flex-1 py-4 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-xl transition"
                >
                    Enregistrer la saison
                </button>

                <a href="{{ route('saisons.index') }}" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-center transition" >
                    Annuler
                </a>

            </div>

        </form>

    </div>
</div>

@push('scripts')
<script>
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

document.getElementById('parcelle_id').addEventListener('change', function() {
    const parcelleId = this.value;
    const zone = document.getElementById('saison-detectee');

    if (!parcelleId) {
        zone.classList.add('hidden');
        return;
    }

    zone.classList.remove('hidden');
    document.getElementById('saison-region-label').textContent = 'Détection en cours...';
    document.getElementById('saison-type-label').textContent = '';
    document.getElementById('saison-meteo-label').textContent = '';

    fetch(`/saisons/infos-parcelle/${parcelleId}`)
        .then(r => r.json())
        .then(data => {
            const regionLabel = data.region === 'nord' ? '🌵 Région Nord' : '🌴 Région Sud';
            document.getElementById('saison-region-label').textContent = regionLabel;
            document.getElementById('saison-type-label').textContent =
                (labelsType[data.type_saison] || data.type_saison) + ' · ' + (labelsCampagne[data.campagne] || data.campagne);

            if (data.pluies_confirmees !== null) {
                const meteoTxt = data.pluies_confirmees
                    ? `✅ Pluies confirmées (${data.cumul_pluies_mm} mm sur 15 jours)`
                    : `⚠️ Pluies pas encore confirmées (${data.cumul_pluies_mm ?? 0} mm sur 15 jours)`;
                document.getElementById('saison-meteo-label').textContent = meteoTxt;
            }
        })
        .catch(() => {
            document.getElementById('saison-region-label').textContent = '⚠️ Détection impossible';
        });
});
</script>
@endpush
@endsection