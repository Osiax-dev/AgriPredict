@extends('layouts.app')
@section('title', "Guide d'Utilisation")

@section('contenu')
<div class="max-w-4xl mx-auto animate-fade-in pb-12">

    {{-- En-tête --}}
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-agri-500 to-cyan-500 mb-5 shadow-xl">
            <i class="fas fa-book-open text-white text-2xl"></i>
        </div>
        <h1 class="text-4xl font-black text-white mb-3">Guide d'Utilisation</h1>
        <p class="text-white/60">Tout ce que vous devez savoir pour utiliser AgriPredict AI efficacement.</p>
    </div>

    {{-- Navigation rapide --}}
    <div class="glass rounded-2xl p-6 mb-8 shadow-xl">
        <p class="text-sm font-bold text-slate-600 uppercase tracking-wider mb-4 flex items-center gap-2">
            <i class="fas fa-list text-agri-500"></i> Sommaire
        </p>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
            <a href="#etape1" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-agri-50 text-slate-600 hover:text-agri-700 transition-colors text-sm">
                <span class="w-6 h-6 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-xs font-bold flex-shrink-0">1</span>
                Créer un compte
            </a>
            <a href="#etape2" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-agri-50 text-slate-600 hover:text-agri-700 transition-colors text-sm">
                <span class="w-6 h-6 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-xs font-bold flex-shrink-0">2</span>
                Tableau de bord
            </a>
            <a href="#etape3" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-agri-50 text-slate-600 hover:text-agri-700 transition-colors text-sm">
                <span class="w-6 h-6 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-xs font-bold flex-shrink-0">3</span>
                Mes parcelles
            </a>
            <a href="#etape4" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-agri-50 text-slate-600 hover:text-agri-700 transition-colors text-sm">
                <span class="w-6 h-6 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-xs font-bold flex-shrink-0">4</span>
                Mes saisons
            </a>
            <a href="#etape5" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-agri-50 text-slate-600 hover:text-agri-700 transition-colors text-sm">
                <span class="w-6 h-6 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-xs font-bold flex-shrink-0">5</span>
                Faire une prévision
            </a>
            <a href="#etape6" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-agri-50 text-slate-600 hover:text-agri-700 transition-colors text-sm">
                <span class="w-6 h-6 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-xs font-bold flex-shrink-0">6</span>
                Comprendre les résultats
            </a>
            <a href="#etape7" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-agri-50 text-slate-600 hover:text-agri-700 transition-colors text-sm">
                <span class="w-6 h-6 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-xs font-bold flex-shrink-0">7</span>
                Historique IA
            </a>
            <a href="#etape8" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-agri-50 text-slate-600 hover:text-agri-700 transition-colors text-sm">
                <span class="w-6 h-6 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-xs font-bold flex-shrink-0">8</span>
                Notifications
            </a>
            <a href="#etape9" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-agri-50 text-slate-600 hover:text-agri-700 transition-colors text-sm">
                <span class="w-6 h-6 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-xs font-bold flex-shrink-0">9</span>
                Mon profil
            </a>
        </div>
    </div>

    {{-- Bannière intro --}}
    <div class="glass rounded-2xl p-6 mb-8 shadow-xl border-l-4 border-agri-400">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-agri-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-seedling text-agri-600 text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 mb-1">Bienvenue sur AgriPredict AI 🌾</h3>
                <p class="text-slate-600 text-sm leading-relaxed">
                    AgriPredict AI est votre assistant intelligent pour prévoir les rendements agricoles au Bénin.
                    En combinant vos données de terrain avec des données satellitaires et climatiques,
                    notre modèle IA vous fournit des estimations de rendement  <strong></strong> <strong></strong>.
                    Ce guide vous explique pas à pas comment utiliser toutes les fonctionnalités.
                </p>
            </div>
        </div>
    </div>

    <div class="space-y-8">

        {{-- ÉTAPE 1 --}}
        <div id="etape1" class="glass rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-agri-500 to-agri-600 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">1</div>
                <div>
                    <h2 class="text-white font-bold text-lg">Créer un compte</h2>
                    <p class="text-white/70 text-sm">Inscription et vérification de votre email</p>
                </div>
                <i class="fas fa-user-plus text-white/40 text-3xl ml-auto"></i>
            </div>
            <div class="p-6 space-y-4 text-slate-600">
                <div class="flex items-start gap-4">
                    <span class="w-7 h-7 rounded-full bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-bold flex-shrink-0">a</span>
                    <div>
                        <p class="font-semibold text-slate-700">Rendez-vous sur la page d'inscription</p>
                        <p class="text-sm mt-1">Cliquez sur <strong>"S'inscrire"</strong> depuis la page d'accueil ou la page de connexion.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <span class="w-7 h-7 rounded-full bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-bold flex-shrink-0">b</span>
                    <div>
                        <p class="font-semibold text-slate-700">Remplissez le formulaire</p>
                        <p class="text-sm mt-1">Entrez votre <strong>nom complet</strong>, votre <strong>adresse email</strong> et un <strong>mot de passe</strong> sécurisé (minimum 8 caractères).</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <span class="w-7 h-7 rounded-full bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-bold flex-shrink-0">c</span>
                    <div>
                        <p class="font-semibold text-slate-700">Vérifiez votre email</p>
                        <p class="text-sm mt-1">Un email de confirmation vous sera envoyé. Cliquez sur le lien dans cet email pour activer votre compte. <span class="text-amber-600 font-medium">⚠️ Sans cette vérification, vous ne pourrez pas accéder aux fonctionnalités.</span></p>
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-sm text-blue-800 flex items-start gap-2">
                    <i class="fab fa-google mt-1 flex-shrink-0"></i>
                    <span>Vous pouvez aussi vous connecter directement avec votre compte <strong>Google</strong> en cliquant sur le bouton "Continuer avec Google" — aucune vérification email supplémentaire nécessaire.</span>
                </div>
            </div>
        </div>

        {{-- ÉTAPE 2 --}}
        <div id="etape2" class="glass rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">2</div>
                <div>
                    <h2 class="text-white font-bold text-lg">Le Tableau de bord</h2>
                    <p class="text-white/70 text-sm">Vue d'ensemble de votre activité</p>
                </div>
                <i class="fas fa-chart-pie text-white/40 text-3xl ml-auto"></i>
            </div>
            <div class="p-6 space-y-4 text-slate-600">
                <p>Après connexion, vous arrivez sur votre <strong>tableau de bord</strong> qui affiche :</p>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="bg-agri-50 rounded-xl p-4 text-center border border-agri-100">
                        <i class="fas fa-map-marked-alt text-2xl text-agri-500 mb-2 block"></i>
                        <p class="font-semibold text-slate-700 text-sm">Nombre de parcelles</p>
                        <p class="text-xs text-slate-500 mt-1">Toutes vos parcelles enregistrées.</p>
                    </div>
                    <div class="bg-cyan-50 rounded-xl p-4 text-center border border-cyan-100">
                        <i class="fas fa-brain text-2xl text-cyan-500 mb-2 block"></i>
                        <p class="font-semibold text-slate-700 text-sm">Prévisions IA</p>
                        <p class="text-xs text-slate-500 mt-1">Nombre total de prédictions effectuées.</p>
                    </div>
                    <div class="bg-yellow-50 rounded-xl p-4 text-center border border-yellow-100">
                        <i class="fas fa-chart-bar text-2xl text-yellow-500 mb-2 block"></i>
                        <p class="font-semibold text-slate-700 text-sm">Rendement moyen</p>
                        <p class="text-xs text-slate-500 mt-1">Moyenne de vos rendements prévus (t/ha).</p>
                    </div>
                </div>
                <p class="text-sm">Le tableau de bord affiche aussi un <strong>guide de lecture NDVI</strong> pour interpréter l'indice de végétation de vos parcelles.</p>
            </div>
        </div>

        {{-- ÉTAPE 3 --}}
        <div id="etape3" class="glass rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">3</div>
                <div>
                    <h2 class="text-white font-bold text-lg">Gérer mes parcelles</h2>
                    <p class="text-white/70 text-sm">Enregistrer et organiser vos champs</p>
                </div>
                <i class="fas fa-map-marked-alt text-white/40 text-3xl ml-auto"></i>
            </div>
            <div class="p-6 space-y-4 text-slate-600">
                <p>Les parcelles représentent vos <strong>champs agricoles</strong>. Vous devez les enregistrer avant de faire une prévision.</p>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-plus-circle text-emerald-500 mt-1 flex-shrink-0"></i>
                        <div>
                            <p class="font-semibold text-slate-700 text-sm">Créer une parcelle</p>
                            <p class="text-sm mt-1">Allez dans <strong>Mes Parcelles → Nouvelle parcelle</strong>. Renseignez le nom, la superficie (ha), la région, et les <strong>coordonnées GPS</strong> (latitude/longitude). Les coordonnées serviront à récupérer automatiquement le NDVI et la météo de votre zone.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-edit text-emerald-500 mt-1 flex-shrink-0"></i>
                        <div>
                            <p class="font-semibold text-slate-700 text-sm">Modifier une parcelle</p>
                            <p class="text-sm mt-1">Cliquez sur l'icône ✏️ à côté de la parcelle pour mettre à jour ses informations.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-trash-alt text-red-400 mt-1 flex-shrink-0"></i>
                        <div>
                            <p class="font-semibold text-slate-700 text-sm">Supprimer une parcelle</p>
                            <p class="text-sm mt-1">Cliquez sur l'icône 🗑️. <span class="text-red-600">Attention : la suppression est définitive.</span></p>
                        </div>
                    </div>
                </div>
                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-sm text-amber-800 flex items-start gap-2">
                    <i class="fas fa-lightbulb mt-1 flex-shrink-0"></i>
                    <span><strong>Astuce :</strong> Pour trouver les coordonnées GPS de votre parcelle, utilisez Google Maps : faites un clic droit sur votre champ et copiez les coordonnées affichées.</span>
                </div>
            </div>
        </div>

        {{-- ÉTAPE 4 --}}
        <div id="etape4" class="glass rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">4</div>
                <div>
                    <h2 class="text-white font-bold text-lg">Gérer mes saisons</h2>
                    <p class="text-white/70 text-sm">Organiser vos cycles de culture</p>
                </div>
                <i class="fas fa-calendar-alt text-white/40 text-3xl ml-auto"></i>
            </div>
            <div class="p-6 space-y-4 text-slate-600">
                <p>Les saisons vous permettent d'organiser vos <strong>cycles de culture</strong> par période.</p>
                <div class="flex items-start gap-3">
                    <i class="fas fa-plus-circle text-violet-500 mt-1 flex-shrink-0"></i>
                    <div>
                        <p class="font-semibold text-slate-700 text-sm">Créer une saison</p>
                        <p class="text-sm mt-1">Allez dans <strong>Mes Saisons → Nouvelle saison</strong>. Associez-la à une parcelle, choisissez la culture (<strong>Maïs</strong> ou <strong>Autres</strong>), la date de début et la date de fin prévisionnelle.</p>
                    </div>
                </div>
                <p class="text-sm">Une saison bien renseignée vous permettra de suivre l'évolution de vos rendements d'une année à l'autre.</p>
            </div>
        </div>

        {{-- ÉTAPE 5 --}}
        <div id="etape5" class="glass rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-agri-500 to-cyan-500 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">5</div>
                <div>
                    <h2 class="text-white font-bold text-lg">Faire une prévision IA</h2>
                    <p class="text-white/70 text-sm">L'étape principale de la plateforme</p>
                </div>
                <i class="fas fa-brain text-white/40 text-3xl ml-auto"></i>
            </div>
            <div class="p-6 space-y-4 text-slate-600">
                <p>La prévision est le cœur d'AgriPredict AI. Voici comment procéder :</p>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <span class="w-7 h-7 rounded-full bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-0.5">1</span>
                        <div>
                            <p class="font-semibold text-slate-700">Accédez au formulaire de prévision</p>
                            <p class="text-sm mt-1">Cliquez sur <strong>Nouvelle Prévision</strong> dans le menu de gauche.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="w-7 h-7 rounded-full bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-0.5">2</span>
                        <div>
                            <p class="font-semibold text-slate-700">Sélectionnez votre parcelle</p>
                            <p class="text-sm mt-1">Choisissez la parcelle concernée dans le menu déroulant. Les coordonnées GPS seront utilisées automatiquement.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="w-7 h-7 rounded-full bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-0.5">3</span>
                        <div>
                            <p class="font-semibold text-slate-700">Choisissez la culture et l'année</p>
                            <p class="text-sm mt-1">Sélectionnez <strong>Culture</strong>, puis l'année de culture.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="w-7 h-7 rounded-full bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-0.5">4</span>
                        <div>
                            <p class="font-semibold text-slate-700">Récupération automatique des données</p>
                            <p class="text-sm mt-1">La plateforme va automatiquement récupérer :</p>
                            <ul class="mt-2 space-y-1 text-sm ml-4">
                                <li class="flex items-center gap-2"><i class="fas fa-satellite text-agri-400 w-4"></i> Le <strong>NDVI</strong> de votre parcelle via Google Earth Engine</li>
                                <li class="flex items-center gap-2"><i class="fas fa-thermometer-half text-orange-400 w-4"></i> La <strong>température</strong> moyenne (°C)</li>
                                <li class="flex items-center gap-2"><i class="fas fa-cloud-rain text-blue-400 w-4"></i> La <strong>pluviométrie</strong> (mm)</li>
                                <li class="flex items-center gap-2"><i class="fas fa-tint text-cyan-400 w-4"></i> L'<strong>humidité</strong> relative (%)</li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="w-7 h-7 rounded-full bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-0.5">5</span>
                        <div>
                            <p class="font-semibold text-slate-700">Lancez la prévision</p>
                            <p class="text-sm mt-1">Vérifiez les valeurs pré-remplies (vous pouvez les ajuster si besoin), puis cliquez sur <strong>"Lancer la prévision"</strong>. Le modèle IA analyse les données et retourne un résultat en quelques secondes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ÉTAPE 6 --}}
        <div id="etape6" class="glass rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">6</div>
                <div>
                    <h2 class="text-white font-bold text-lg">Comprendre les résultats</h2>
                    <p class="text-white/70 text-sm">Interpréter la prévision de rendement</p>
                </div>
                <i class="fas fa-chart-line text-white/40 text-3xl ml-auto"></i>
            </div>
            <div class="p-6 space-y-4 text-slate-600">
                <p>La page de résultat affiche votre <strong>rendement prévu en tonnes par hectare (t/ha)</strong>. Voici comment interpréter ce chiffre :</p>

                <div class="space-y-3">
                    <div class="flex items-center gap-4 bg-red-50 border border-red-100 rounded-xl p-4">
                        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-red-700">Rendement faible</p>
                            <p class="text-sm text-red-600">Maïs : &lt; 1 t/ha · Riz : &lt; 1.5 t/ha</p>
                            <p class="text-xs text-slate-500 mt-1">Conditions défavorables. Envisagez des mesures correctives (irrigation, engrais).</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-yellow-50 border border-yellow-100 rounded-xl p-4">
                        <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-minus-circle text-yellow-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-yellow-700">Rendement moyen</p>
                            <p class="text-sm text-yellow-600">Maïs : 1–2.5 t/ha · Riz : 1.5–3 t/ha</p>
                            <p class="text-xs text-slate-500 mt-1">Conditions acceptables. Des améliorations sont possibles.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-emerald-700">Bon rendement</p>
                            <p class="text-sm text-emerald-600">Maïs : &gt; 2.5 t/ha · Riz : &gt; 3 t/ha</p>
                            <p class="text-xs text-slate-500 mt-1">Bonnes conditions climatiques et végétatives. 🎉</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 mt-2">
                    <p class="font-semibold text-slate-700 text-sm mb-2 flex items-center gap-2">
                        <i class="fas fa-satellite text-agri-500"></i> Comprendre le NDVI
                    </p>
                    <p class="text-sm text-slate-600">Le NDVI (Indice de Végétation) mesure la santé de votre végétation :</p>
                    <div class="flex gap-1 mt-2">
                        <div class="flex-1 rounded-lg p-2 bg-blue-50 text-center"><p class="text-xs font-bold text-blue-600">-1 à 0</p><p class="text-xs text-slate-400">Eau</p></div>
                        <div class="flex-1 rounded-lg p-2 bg-slate-100 text-center"><p class="text-xs font-bold text-slate-500">0 à 0.2</p><p class="text-xs text-slate-400">Sol nu</p></div>
                        <div class="flex-1 rounded-lg p-2 bg-yellow-50 text-center"><p class="text-xs font-bold text-yellow-600">0.2–0.4</p><p class="text-xs text-slate-400">Faible</p></div>
                        <div class="flex-1 rounded-lg p-2 bg-lime-50 text-center"><p class="text-xs font-bold text-lime-600">0.4–0.6</p><p class="text-xs text-slate-400">Moyen</p></div>
                        <div class="flex-1 rounded-lg p-2 bg-green-50 text-center"><p class="text-xs font-bold text-green-600">0.6–1.0</p><p class="text-xs text-slate-400">Sain ✅</p></div>
                    </div>
                </div>

                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 text-sm text-amber-800 flex items-start gap-2">
                    <i class="fas fa-info-circle mt-1 flex-shrink-0"></i>
                    <span>Les prévisions sont des <strong>estimations indicatives</strong> basées sur un modèle statistique. Consultez toujours un technicien agricole pour les décisions importantes.</span>
                </div>
            </div>
        </div>

        {{-- ÉTAPE 7 --}}
        <div id="etape7" class="glass rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-slate-600 to-slate-700 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">7</div>
                <div>
                    <h2 class="text-white font-bold text-lg">Historique des prévisions</h2>
                    <p class="text-white/70 text-sm">Consulter toutes vos prédictions passées</p>
                </div>
                <i class="fas fa-history text-white/40 text-3xl ml-auto"></i>
            </div>
            <div class="p-6 text-slate-600">
                <p>Dans <strong>Historique IA</strong>, vous retrouvez la liste complète de toutes vos prévisions passées avec :</p>
                <ul class="space-y-2 mt-3">
                    <li class="flex items-center gap-2 text-sm"><i class="fas fa-check text-agri-500 w-4"></i> La date et l'heure de la prévision</li>
                    <li class="flex items-center gap-2 text-sm"><i class="fas fa-check text-agri-500 w-4"></i> La parcelle et la culture concernées</li>
                    <li class="flex items-center gap-2 text-sm"><i class="fas fa-check text-agri-500 w-4"></i> Les données météo et NDVI utilisées</li>
                    <li class="flex items-center gap-2 text-sm"><i class="fas fa-check text-agri-500 w-4"></i> Le rendement prévu (t/ha)</li>
                </ul>
                <p class="text-sm mt-3">Cliquez sur une prévision pour en voir tous les détails.</p>
            </div>
        </div>

        {{-- ÉTAPE 8 --}}
        <div id="etape8" class="glass rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-red-500 to-pink-500 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">8</div>
                <div>
                    <h2 class="text-white font-bold text-lg">Notifications</h2>
                    <p class="text-white/70 text-sm">Alertes intelligentes après chaque prévision</p>
                </div>
                <i class="fas fa-bell text-white/40 text-3xl ml-auto"></i>
            </div>
            <div class="p-6 text-slate-600">
                <p>Après chaque prévision, AgriPredict AI génère automatiquement des <strong>notifications personnalisées</strong> selon votre résultat :</p>
                <div class="grid md:grid-cols-2 gap-3 mt-4">
                    <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 text-sm">
                        <p class="font-semibold text-emerald-700 flex items-center gap-2 mb-1"><i class="fas fa-check-circle"></i> Succès</p>
                        <p class="text-slate-600">Bon rendement prévu. Conditions optimales.</p>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 text-sm">
                        <p class="font-semibold text-yellow-700 flex items-center gap-2 mb-1"><i class="fas fa-exclamation-circle"></i> Avertissement</p>
                        <p class="text-slate-600">Rendement moyen. Des améliorations sont suggérées.</p>
                    </div>
                    <div class="bg-red-50 border border-red-100 rounded-xl p-3 text-sm">
                        <p class="font-semibold text-red-700 flex items-center gap-2 mb-1"><i class="fas fa-times-circle"></i> Alerte</p>
                        <p class="text-slate-600">Rendement faible prévu. Action requise.</p>
                    </div>
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-sm">
                        <p class="font-semibold text-blue-700 flex items-center gap-2 mb-1"><i class="fas fa-info-circle"></i> Information</p>
                        <p class="text-slate-600">Conseils et suggestions générales.</p>
                    </div>
                </div>
                <p class="text-sm mt-4">Le badge rouge sur l'icône 🔔 dans le menu indique le nombre de notifications non lues. Cliquez sur <strong>Notifications</strong> pour toutes les consulter ou les supprimer.</p>
            </div>
        </div>

        {{-- ÉTAPE 9 --}}
        <div id="etape9" class="glass rounded-2xl overflow-hidden shadow-xl">
            <div class="bg-gradient-to-r from-agri-600 to-agri-700 p-5 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-white font-black text-lg">9</div>
                <div>
                    <h2 class="text-white font-bold text-lg">Mon profil</h2>
                    <p class="text-white/70 text-sm">Gérer vos informations personnelles</p>
                </div>
                <i class="fas fa-user-cog text-white/40 text-3xl ml-auto"></i>
            </div>
            <div class="p-6 text-slate-600">
                <p>Depuis le menu de votre profil (en bas à gauche), vous pouvez accéder à deux pages :</p>
                <div class="space-y-3 mt-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-user-edit text-agri-500 mt-1 flex-shrink-0"></i>
                        <div>
                            <p class="font-semibold text-slate-700">Modifier mon profil</p>
                            <p class="text-sm mt-1">Mettez à jour votre nom et votre adresse email.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-key text-cyan-500 mt-1 flex-shrink-0"></i>
                        <div>
                            <p class="font-semibold text-slate-700">Changer mon mot de passe</p>
                            <p class="text-sm mt-1">Modifiez votre mot de passe en toute sécurité.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Besoin d'aide --}}
        <div class="glass rounded-2xl p-8 shadow-xl text-center">
            <i class="fas fa-headset text-4xl text-agri-400 mb-4 block"></i>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Besoin d'aide ?</h3>
            <p class="text-slate-600 mb-5">Si vous rencontrez un problème ou avez une question, contactez-nous.</p>
            <a href="mailto:agripredictaibj@gmail.com"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-bold rounded-xl shadow-lg transition-all duration-300 hover:scale-105">
                <i class="fas fa-envelope"></i>
                agripredictaibj@gmail.com
            </a>
        </div>

    </div>

    {{-- Liens bas --}}
    <div class="mt-10 flex flex-wrap items-center justify-center gap-4 text-sm text-white/60">
        <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors flex items-center gap-1">
            <i class="fas fa-arrow-left text-xs"></i> Retour au tableau de bord
        </a>
        <span>·</span>
        <a href="{{ route('legal.cgu') }}" class="hover:text-white transition-colors">Conditions d'utilisation</a>
        <span>·</span>
        <a href="{{ route('legal.politique') }}" class="hover:text-white transition-colors">Politique de confidentialité</a>
    </div>

</div>
@endsection