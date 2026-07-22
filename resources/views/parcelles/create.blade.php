@extends('layouts.app')
@section('title', 'Nouvelle Parcelle')

@section('contenu')
<div class="max-w-6xl mx-auto animate-slide-up">
    <h2 class="text-3xl font-bold text-white mb-8 drop-shadow-lg">
        <i class="fas fa-seedling text-agri-400 mr-3"></i>Nouvelle Parcelle
    </h2>

    <div class="grid lg:grid-cols-2 gap-6">
        {{-- ══════════ FORMULAIRE ══════════ --}}
        <div class="glass rounded-2xl p-8 shadow-xl">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                <i class="fas fa-edit text-agri-500"></i> Informations générales
            </h4>

            <form method="POST" action="{{ route('parcelles.store') }}">
                @csrf

                {{-- Nom de la parcelle --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                         Nom de la parcelle
                    </label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                        placeholder="Ex: Parcelle C - Parakou"
                        class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all">
                    @error('nom') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Type de culture --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                         Type de culture cible
                    </label>
                    <select name="culture" class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all">
                        <option value="">-- Choisir une culture --</option>
                        <optgroup label="🌽 Céréales">
                            <option value="Maïs" {{ old('culture') == 'Maïs' ? 'selected' : '' }}>🌽 Maïs</option>
                            <option value="Riz" {{ old('culture') == 'Riz' ? 'selected' : '' }}>🍚 Riz</option>
                            <option value="Niébé" {{ old('culture') == 'Niébé' ? 'selected' : '' }}>🫛 Niébé</option>
                            <option value="Arachide" {{ old('culture') == 'Arachide' ? 'selected' : '' }}>🥜 Arachide</option>
                            <option value="Soja" {{ old('culture') == 'Soja' ? 'selected' : '' }}>🫘 Soja</option>
                            <option value="Goussi" {{ old('culture') == 'Goussi' ? 'selected' : '' }}>🫘 Goussi</option>
                        </optgroup>
                        <optgroup label="🍅 Maraîchage">
                            <option value="Tomate" {{ old('culture') == 'Tomate' ? 'selected' : '' }}>🍅 Tomate</option>
                            <option value="Piment" {{ old('culture') == 'Piment' ? 'selected' : '' }}>🌶️ Piment</option>
                            <option value="Gombo" {{ old('culture') == 'Gombo' ? 'selected' : '' }}>🥬 Gombo</option>
                            <option value="Oignon" {{ old('culture') == 'Oignon' ? 'selected' : '' }}>🧅 Oignon</option>
                        </optgroup>
                        <optgroup label="🍍 Fruits & Cultures de rente">
                            <option value="Ananas" {{ old('culture') == 'Ananas' ? 'selected' : '' }}>🍍 Ananas</option>
                            <option value="Coton" {{ old('culture') == 'Coton' ? 'selected' : '' }}>☁️ Coton</option>
                        </optgroup>
                     
                    </select>
                    @error('culture') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Superficie --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                         Superficie (hectares)
                    </label>
                    <input type="number" name="superficie" step="0.1" min="0.1" max="100"
                        value="{{ old('superficie') }}" placeholder="2.5"
                        class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all">
                    @error('superficie') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Département + Commune --}}
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                            📍 Département
                        </label>
                        <select name="departement" id="departement" onchange="filtrerCommunes()"
                            class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all">
                            <option value="">-- Choisir --</option>
                            @foreach(['Alibori','Atacora','Atlantique','Borgou','Collines','Couffo','Donga','Littoral','Mono','Ouémé','Plateau','Zou'] as $dep)
                                <option value="{{ $dep }}" {{ old('departement') == $dep ? 'selected' : '' }}>{{ $dep }}</option>
                            @endforeach
                        </select>
                        @error('departement') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                             Commune
                        </label>
                        <select name="commune" id="commune"
                            class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all">
                            <option value="">-- Choisir d'abord un département --</option>
                        </select>
                        @error('commune') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                                <div class="mt-4 text-center">
                <button type="button" onclick="localisermoi()" id="btn-gps"
                    class="px-4 py-2 bg-agri-100 dark:bg-agri-900/30 hover:bg-agri-200 dark:hover:bg-agri-900/50 text-agri-700 dark:text-agri-300 border-2 border-agri-500 dark:border-agri-600 rounded-xl font-semibold transition-all">
                    📡 Utiliser ma position GPS
                </button>
                <span id="gps-status" class="block text-xs text-slate-500 dark:text-slate-400 mt-2"></span>
            </div>
                </div>

                {{-- Lat + Lng --}}
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                            🌐 Latitude
                        </label>
                        <input type="number" name="lat" step="any" id="lat"
                            value="{{ old('lat') }}" placeholder="9.337089"
                            class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all">
                        @error('lat') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                            🌐 Longitude
                        </label>
                        <input type="number" name="lng" step="any" id="lng"
                            value="{{ old('lng') }}" placeholder="2.620893"
                            class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all">
                        @error('lng') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Type de sol --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                         Type de sol
                    </label>
                    <select name="type_sol" class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all">
                        <option value="">-- Choisir un type de sol --</option>
                        <option value="argileux" {{ old('type_sol') == 'argileux' ? 'selected' : '' }}>🟤 Argileux</option>
                        <option value="sableux" {{ old('type_sol') == 'sableux' ? 'selected' : '' }}>🟡 Sableux</option>
                        <option value="limoneux" {{ old('type_sol') == 'limoneux' ? 'selected' : '' }}>🟠 Limoneux</option>
                        <option value="lateritique" {{ old('type_sol') == 'lateritique' ? 'selected' : '' }}>🔴 Latéritique</option>
                        <option value="ferrugineux" {{ old('type_sol') == 'ferrugineux' ? 'selected' : '' }}>🟤 Ferrugineux</option>
                        <option value="hydromorphe" {{ old('type_sol') == 'hydromorphe' ? 'selected' : '' }}>💧 Hydromorphe (zones inondables)</option>
                        <option value="sale" {{ old('type_sol') == 'sale' ? 'selected' : '' }}>🧂 Salé (zones côtières)</option>
                    </select>
                    @error('type_sol') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Notes / Observations --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                         Notes / Observations
                    </label>
                    <textarea name="notes" rows="3" placeholder="Ex: Parcelle irriguée par canal, sol bien drainé..."
                        class="w-full px-4 py-3 border-2 border-slate-200 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all resize-vertical">{{ old('notes') }}</textarea>
                </div>

                {{-- Boutons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 py-3 bg-gradient-to-r from-agri-500 to-agri-600 hover:from-agri-600 hover:to-agri-700 text-white font-bold rounded-xl shadow-lg shadow-agri-500/30 transition-all">
                        💾 Enregistrer la parcelle
                    </button>
                    <a href="{{ route('parcelles.index') }}"
                        class="flex-1 py-3 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-white font-semibold rounded-xl transition-all text-center">
                        Annuler
                    </a>
                </div>
            </form>
        </div>

        {{-- ══════════ CARTE ══════════ --}}
        <div class="glass rounded-2xl p-8 shadow-xl">
            <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-map text-cyan-500"></i> Localisation sur la carte
            </h4>
            <div id="carte" class="h-80 rounded-xl overflow-hidden border-2 border-slate-200 dark:border-slate-600"></div>



            <div class="mt-4 bg-gradient-to-r from-agri-50 to-cyan-50 dark:from-slate-800 dark:to-slate-700 rounded-xl p-4 text-sm text-slate-600 dark:text-slate-300 border border-agri-200 dark:border-slate-600">
                <i class="fas fa-info-circle text-agri-600 dark:text-agri-400 mr-2"></i>
                Cliquez sur la carte ou utilisez le GPS. Le département et la commune seront détectés automatiquement.
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ══════════ CARTE LEAFLET ══════════
var map = L.map('carte').setView([9.3077, 2.3158], 7);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);
var marker = null;

map.on('click', function(e) {
    var lat = e.latlng.lat.toFixed(6);
    var lng = e.latlng.lng.toFixed(6);
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
    if (marker) marker.setLatLng(e.latlng);
    else marker = L.marker(e.latlng).addTo(map);
    recupererLocalisation(lat, lng);
});

// ══════════ GPS ══════════
function localisermoi() {
    var status = document.getElementById('gps-status');
    var btn = document.getElementById('btn-gps');
    status.textContent = '🔄 Localisation en cours...';
    status.className = 'block text-xs text-blue-600 dark:text-blue-400 mt-2';
    btn.disabled = true;
    btn.textContent = '🔄 Localisation...';

    if (!navigator.geolocation) {
        status.textContent = '❌ Géolocalisation non supportée.';
        status.className = 'block text-xs text-red-600 dark:text-red-400 mt-2';
        btn.disabled = false;
        btn.textContent = '📡 Utiliser ma position GPS';
        return;
    }

    navigator.geolocation.getCurrentPosition(function(pos) {
        var lat = pos.coords.latitude.toFixed(6);
        var lng = pos.coords.longitude.toFixed(6);
        document.getElementById('lat').value = lat;
        document.getElementById('lng').value = lng;
        var latlng = [pos.coords.latitude, pos.coords.longitude];
        map.setView(latlng, 14);
        if (marker) marker.setLatLng(latlng);
        else marker = L.marker(latlng).addTo(map);
        status.textContent = '✅ Position détectée. Détection du département...';
        status.className = 'block text-xs text-green-600 dark:text-green-400 mt-2';
        recupererLocalisation(lat, lng, true);
        btn.disabled = false;
        btn.textContent = '📡 Utiliser ma position GPS';
    }, function() {
        status.textContent = '❌ Impossible de détecter la position.';
        status.className = 'block text-xs text-red-600 dark:text-red-400 mt-2';
        btn.disabled = false;
        btn.textContent = '📡 Utiliser ma position GPS';
    });
}

// ══════════ COMMUNES DU BÉNIN ══════════
var communesParDepartement = {
    'Alibori':     ['Banikoara','Gogounou','Kandi','Karimama','Malanville','Ségbana'],
    'Atacora':     ['Boukoumbé','Cobly','Kérou','Kouandé','Matéri','Natitingou','Tanguiéta','Toucountouna'],
    'Atlantique':  ['Abomey-Calavi','Allada','Kpomassè','Ouidah','Sô-Ava','Toffo','Tori-Bossito','Zè'],
    'Borgou':      ['Bembèrèkè','Kalalé','N\'Dali','Nikki','Parakou','Pèrèrè','Sinendé','Tchaourou'],
    'Collines':    ['Bantè','Dassa-Zoumé','Glazoué','Ouessè','Savalou','Savè'],
    'Couffo':      ['Aplahoué','Djidja','Klouékanmè','Lalo','Dogbo','Toviklin'],
    'Donga':       ['Copargo','Djougou','Ouaké','Péhunco','Bassila'],
    'Littoral':    ['Cotonou'],
    'Mono':        ['Athiémé','Bopa','Comè','Grand-Popo','Houéyogbé','Lokossa'],
    'Ouémé':       ['Adjarra','Adjohoun','Aguégué','Akpro-Missérété','Avrankou','Bonou','Dangbo','Porto-Novo','Sèmè-Kpodji'],
    'Plateau':     ['Adja-Ouèrè','Ifangni','Kétou','Pobè','Sakété'],
    'Zou':         ['Abomey','Agbangnizoun','Bohicon','Covè','Ouinhi','Zagnanado','Zogbodomey']
};

function filtrerCommunes() {
    var dep = document.getElementById('departement').value;
    var selectCom = document.getElementById('commune');
    selectCom.innerHTML = '<option value="">-- Choisir une commune --</option>';

    if (dep && communesParDepartement[dep]) {
        communesParDepartement[dep].forEach(function(c) {
            var opt = document.createElement('option');
            opt.value = c;
            opt.textContent = c;
            selectCom.appendChild(opt);
        });
    }
}

// ══════════ NOMINATIM ══════════
function recupererLocalisation(lat, lng, isGps) {
    var status = document.getElementById('gps-status');
    if (!isGps) {
        status.textContent = '🔍 Détection du département et de la commune...';
        status.className = 'block text-xs text-blue-600 dark:text-blue-400 mt-2';
    }

    fetch('https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lng + '&format=json&accept-language=fr')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data && data.address) {
                var state = data.address.state || '';
                var city = data.address.city || data.address.town || data.address.village || data.address.county || '';

                var selectDep = document.getElementById('departement');
                for (var i = 0; i < selectDep.options.length; i++) {
                    if (selectDep.options[i].value === state) {
                        selectDep.selectedIndex = i;
                        break;
                    }
                }

                filtrerCommunes();

                setTimeout(function() {
                    var selectCom = document.getElementById('commune');
                    for (var i = 0; i < selectCom.options.length; i++) {
                        if (selectCom.options[i].value === city) {
                            selectCom.selectedIndex = i;
                            break;
                        }
                    }
                    status.textContent = '✅ Détecté : ' + state + ' - ' + city;
                    status.className = 'block text-xs text-green-600 dark:text-green-400 mt-2';
                }, 100);
            } else {
                status.textContent = '⚠️ Localisation non trouvée. Sélectionnez manuellement.';
                status.className = 'block text-xs text-orange-600 dark:text-orange-400 mt-2';
            }
        })
        .catch(function(err) {
            console.error(err);
            status.textContent = '⚠️ Erreur de connexion. Sélectionnez manuellement.';
            status.className = 'block text-xs text-orange-600 dark:text-orange-400 mt-2';
        });
}

// ══════════ RESTAURATION OLD ══════════
document.addEventListener('DOMContentLoaded', function() {
    var oldDep = '{{ old("departement") }}';
    if (oldDep) {
        document.getElementById('departement').value = oldDep;
        filtrerCommunes();
        var oldCom = '{{ old("commune") }}';
        if (oldCom) document.getElementById('commune').value = oldCom;
    }
});
</script>
@endpush
@endsection