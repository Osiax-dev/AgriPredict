@extends('layouts.guest')
@section('title', 'Politique de Confidentialité')

@section('contenu')
<div class="min-h-screen py-16 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- En-tête --}}
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 mb-6 shadow-xl">
                <i class="fas fa-shield-alt text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-black text-white mb-3">Politique de Confidentialité</h1>
            <p class="text-white/60 text-sm">Dernière mise à jour : Juin 2026</p>
            <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full text-white/70 text-sm">
                <i class="fas fa-lock text-cyan-400"></i>
                Vos données sont protégées
            </div>
        </div>

        {{-- Intro --}}
        <div class="glass rounded-2xl p-6 mb-6 shadow-xl border-l-4 border-cyan-400 animate-fade-in">
            <p class="text-slate-700 leading-relaxed">
                Chez <strong>AgriPredict AI</strong>, nous prenons la protection de vos données personnelles très au sérieux.
                Cette politique explique quelles données nous collectons, pourquoi, et comment nous les utilisons et protégeons.
            </p>
        </div>

        <div class="space-y-6">

            {{-- Section 1 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <i class="fas fa-database text-cyan-500 w-6"></i>
                    1. Données collectées
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-4">
                    <p>Nous collectons les données suivantes lors de l'utilisation de la plateforme :</p>

                    <div class="grid md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-user text-agri-500"></i> Données d'identité
                            </p>
                            <ul class="text-sm space-y-1 text-slate-500">
                                <li>• Nom complet</li>
                                <li>• Adresse email</li>
                                <li>• Identifiant Google (si connexion OAuth)</li>
                            </ul>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-seedling text-agri-500"></i> Données agricoles
                            </p>
                            <ul class="text-sm space-y-1 text-slate-500">
                                <li>• Coordonnées GPS de vos parcelles</li>
                                <li>• Type de culture </li>
                                <li>• Données météo et NDVI associées</li>
                                <li>• Résultats de prévisions</li>
                            </ul>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-chart-bar text-agri-500"></i> Données d'usage
                            </p>
                            <ul class="text-sm space-y-1 text-slate-500">
                                <li>• Date et heure de connexion</li>
                                <li>• Historique des prévisions</li>
                                <li>• Avis et commentaires publiés</li>
                            </ul>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="font-semibold text-slate-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-server text-agri-500"></i> Données techniques
                            </p>
                            <ul class="text-sm space-y-1 text-slate-500">
                                <li>• Adresse IP</li>
                                <li>• Type de navigateur / appareil</li>
                                <li>• Cookies de session</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <i class="fas fa-bullseye text-cyan-500 w-6"></i>
                    2. Finalités du traitement
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>Vos données sont collectées et utilisées uniquement pour les finalités suivantes :</p>
                    <ul class="space-y-3 mt-3">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Création et gestion de votre compte utilisateur.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Génération des prévisions de rendement agricole par le modèle IA.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Envoi de notifications et alertes agricoles personnalisées.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Envoi d'emails transactionnels (vérification d'email, réinitialisation de mot de passe).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Amélioration continue du modèle de prédiction (données agricoles agrégées et anonymisées).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Sécurité, prévention des abus et administration de la plateforme.</span>
                        </li>
                    </ul>
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mt-4">
                        <p class="text-blue-800 text-sm flex items-start gap-2">
                            <i class="fas fa-info-circle mt-1 flex-shrink-0"></i>
                            Nous ne vendons, ne louons et ne partageons jamais vos données personnelles à des tiers à des fins commerciales.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Section 3 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <i class="fas fa-share-alt text-cyan-500 w-6"></i>
                    3. Partage des données
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>Vos données peuvent être partagées uniquement avec :</p>
                    <ul class="space-y-3 mt-3">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-satellite text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Google Earth Engine</strong> — pour la récupération des données NDVI satellitaires à partir de vos coordonnées GPS.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-cloud-sun text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Open-Meteo API</strong> — pour les données météorologiques (température, pluviométrie, humidité) de votre zone.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-robot text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Groq AI</strong> — en tant que service secondaire d'analyse IA, uniquement pour des données agrégées.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-envelope text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Gmail SMTP</strong> — pour l'envoi des emails transactionnels (votre adresse email uniquement).</span>
                        </li>
                    </ul>
                    <p class="mt-3">Ces services tiers sont soumis à leurs propres politiques de confidentialité. Nous veillons à ne leur transmettre que les données strictement nécessaires.</p>
                </div>
            </div>

            {{-- Section 4 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <i class="fas fa-lock text-cyan-500 w-6"></i>
                    4. Sécurité des données
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>Nous mettons en œuvre les mesures de sécurité suivantes pour protéger vos données :</p>
                    <ul class="space-y-2 mt-3">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-key text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Les mots de passe sont <strong class="text-slate-700">hachés et salés</strong> avec l'algorithme bcrypt (jamais stockés en clair).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-envelope-open-text text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Vérification d'email obligatoire</strong> à l'inscription pour valider l'identité de chaque utilisateur.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-shield-virus text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Protection contre les attaques CSRF, XSS et injections SQL via le framework Laravel.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-user-shield text-agri-500 mt-1 flex-shrink-0"></i>
                            <span>Séparation stricte des rôles entre les utilisateurs et les administrateurs.</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Section 5 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <i class="fas fa-user-cog text-cyan-500 w-6"></i>
                    5. Vos droits
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>Conformément aux principes de protection des données personnelles, vous disposez des droits suivants :</p>
                    <div class="grid md:grid-cols-2 gap-3 mt-4">
                        <div class="flex items-start gap-3 bg-slate-50 rounded-xl p-4">
                            <i class="fas fa-eye text-cyan-500 mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="font-semibold text-slate-700 text-sm">Droit d'accès</p>
                                <p class="text-xs text-slate-500 mt-1">Consulter vos données personnelles stockées.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-slate-50 rounded-xl p-4">
                            <i class="fas fa-edit text-cyan-500 mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="font-semibold text-slate-700 text-sm">Droit de rectification</p>
                                <p class="text-xs text-slate-500 mt-1">Corriger vos informations depuis votre profil.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-slate-50 rounded-xl p-4">
                            <i class="fas fa-trash-alt text-cyan-500 mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="font-semibold text-slate-700 text-sm">Droit à l'effacement</p>
                                <p class="text-xs text-slate-500 mt-1">Demander la suppression de votre compte et de vos données.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 bg-slate-50 rounded-xl p-4">
                            <i class="fas fa-ban text-cyan-500 mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="font-semibold text-slate-700 text-sm">Droit d'opposition</p>
                                <p class="text-xs text-slate-500 mt-1">Vous opposer à certains traitements de vos données.</p>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4">Pour exercer ces droits, contactez-nous à :
                        <a href="mailto:agripredictaibj@gmail.com" class="text-agri-600 hover:text-agri-700 font-medium">agripredictaibj@gmail.com</a>
                    </p>
                </div>
            </div>

            {{-- Section 6 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <i class="fas fa-cookie-bite text-cyan-500 w-6"></i>
                    6. Cookies
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>AgriPredict AI utilise uniquement des cookies <strong class="text-slate-700">strictement nécessaires</strong> au fonctionnement :</p>
                    <ul class="space-y-2 mt-3">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-circle text-agri-400 mt-2 text-xs flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Cookie de session</strong> — maintient votre connexion active pendant votre navigation.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-circle text-agri-400 mt-2 text-xs flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Token CSRF</strong> — protège vos formulaires contre les attaques.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-circle text-agri-400 mt-2 text-xs flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Préférence de thème</strong> (localStorage) — mémorise votre choix mode clair/sombre.</span>
                        </li>
                    </ul>
                    <p class="mt-3">Nous n'utilisons aucun cookie publicitaire ou de traçage tiers.</p>
                </div>
            </div>

            {{-- Section 7 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <i class="fas fa-clock text-cyan-500 w-6"></i>
                    7. Durée de conservation
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>Vos données sont conservées aussi longtemps que votre compte est actif. En cas de suppression de compte, vos données personnelles sont effacées de nos serveurs dans un délai raisonnable.</p>
                    <p>Les données agricoles agrégées et anonymisées peuvent être conservées à des fins de recherche et d'amélioration du modèle IA.</p>
                </div>
            </div>

        </div>

        {{-- Liens bas de page --}}
        <div class="mt-10 flex flex-wrap items-center justify-center gap-4 text-sm text-white/60">
            <a href="{{ route('accueil') }}" class="hover:text-white transition-colors flex items-center gap-1">
                <i class="fas fa-arrow-left text-xs"></i> Retour à l'accueil
            </a>
            <span>·</span>
            <a href="{{ route('legal.cgu') }}" class="hover:text-white transition-colors">Conditions d'utilisation</a>
            <span>·</span>
            <a href="{{ route('legal.guide') }}" class="hover:text-white transition-colors">Guide d'utilisation</a>
        </div>

    </div>
</div>
@endsection