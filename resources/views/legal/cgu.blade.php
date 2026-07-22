@extends('layouts.guest')
@section('title', "Conditions Générales d'Utilisation")

@section('contenu')
<div class="min-h-screen py-16 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- En-tête --}}
        <div class="text-center mb-12 animate-fade-in">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-agri-500 to-cyan-500 mb-6 shadow-xl">
                <i class="fas fa-file-contract text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl font-black text-white mb-3">Conditions Générales d'Utilisation</h1>
            <p class="text-white/60 text-sm">Dernière mise à jour : Juin 2026</p>
            <div class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full text-white/70 text-sm">
                <i class="fas fa-leaf text-agri-400"></i>
                AgriPredict AI · Bénin
            </div>
        </div>

        {{-- Contenu --}}
        <div class="space-y-6">

            {{-- Article 1 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-black">1</span>
                    Présentation de la plateforme
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>AgriPredict AI est une plateforme numérique de prévision de rendement agricole basée sur l'intelligence artificielle, développée dans le cadre d'un projet de fin d'études par <strong class="text-slate-800">MONTCHO Lysias</strong> et <strong class="text-slate-800">TCHEOUBI Osiax</strong>.</p>
                    <p>La plateforme est destinée en priorité aux <strong class="text-slate-800">agriculteurs béninois</strong> souhaitant estimer les rendements de leurs cultures  à partir de données climatiques et satellitaires.</p>
                    <p>L'accès à AgriPredict AI est proposé gratuitement à titre expérimental et peut évoluer sans préavis.</p>
                </div>
            </div>

            {{-- Article 2 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-black">2</span>
                    Acceptation des conditions
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>En créant un compte ou en utilisant AgriPredict AI, vous acceptez sans réserve les présentes Conditions Générales d'Utilisation (CGU).</p>
                    <p>Si vous n'acceptez pas ces conditions, vous devez cesser immédiatement d'utiliser la plateforme.</p>
                    <p>Ces CGU peuvent être modifiées à tout moment. Les utilisateurs seront informés de toute modification substantielle par email ou par notification sur la plateforme.</p>
                </div>
            </div>

            {{-- Article 3 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-black">3</span>
                    Création de compte et accès
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>Pour accéder aux fonctionnalités complètes de la plateforme, vous devez créer un compte en fournissant des informations exactes et à jour (nom, adresse email valide).</p>
                    <p>Un <strong class="text-slate-800">email de vérification</strong> vous sera envoyé lors de l'inscription. Votre compte ne sera pleinement activé qu'après confirmation de votre adresse email.</p>
                    <p>Vous pouvez également vous connecter via votre compte <strong class="text-slate-800">Google</strong> grâce à OAuth 2.0.</p>
                    <p>Vous êtes responsable de la confidentialité de vos identifiants et de toute activité effectuée depuis votre compte.</p>
                </div>
            </div>

            {{-- Article 4 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-black">4</span>
                    Fonctionnalités et utilisation
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>AgriPredict AI met à disposition les fonctionnalités suivantes :</p>
                    <ul class="space-y-2 mt-3">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-brain text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Prévision de rendement par IA</strong> — estimation du rendement (t/ha) à partir de données NDVI, climatiques et culturales.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marked-alt text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Gestion des parcelles</strong> — création et suivi de vos parcelles agricoles.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-calendar-alt text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Gestion des saisons</strong> — organisation de vos cycles de culture.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-history text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Historique des prévisions</strong> — consultation de toutes vos prédictions passées.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-bell text-agri-500 mt-1 flex-shrink-0"></i>
                            <span><strong class="text-slate-700">Notifications intelligentes</strong> — alertes automatiques basées sur les résultats de vos prévisions.</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Article 5 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-black">5</span>
                    Comportements interdits
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>Il est strictement interdit de :</p>
                    <ul class="space-y-2 mt-3">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-times-circle text-red-400 mt-1 flex-shrink-0"></i>
                            <span>Utiliser la plateforme à des fins commerciales non autorisées ou frauduleuses.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-times-circle text-red-400 mt-1 flex-shrink-0"></i>
                            <span>Tenter de contourner les mesures de sécurité ou d'accéder aux données d'autres utilisateurs.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-times-circle text-red-400 mt-1 flex-shrink-0"></i>
                            <span>Publier des avis ou contenus faux, diffamatoires ou inappropriés.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-times-circle text-red-400 mt-1 flex-shrink-0"></i>
                            <span>Utiliser des robots ou scripts automatisés pour interagir avec la plateforme.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-times-circle text-red-400 mt-1 flex-shrink-0"></i>
                            <span>Reproduire ou redistribuer les algorithmes et modèles IA sans autorisation écrite.</span>
                        </li>
                    </ul>
                    <p class="mt-3">Tout manquement à ces règles peut entraîner la suspension ou suppression définitive du compte.</p>
                </div>
            </div>

            {{-- Article 6 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-black">6</span>
                    Limitation de responsabilité
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <p class="text-amber-800 font-medium flex items-start gap-2">
                            <i class="fas fa-exclamation-triangle mt-1 flex-shrink-0"></i>
                            Les prévisions fournies par AgriPredict AI sont des <strong>estimations à titre indicatif</strong> basées sur des modèles statistiques. Elles ne constituent pas des conseils agronomiques professionnels et ne sauraient remplacer l'expertise d'un technicien agricole.
                        </p>
                    </div>
                    <p>Les développeurs d'AgriPredict AI ne peuvent être tenus responsables des décisions agricoles prises sur la base des prévisions générées par la plateforme, ni des pertes de rendement éventuelles.</p>
                    <p>La disponibilité de la plateforme n'est pas garantie en permanence. Des interruptions de service peuvent survenir pour maintenance ou mise à jour.</p>
                </div>
            </div>

            {{-- Article 7 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-black">7</span>
                    Propriété intellectuelle
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>Tous les éléments de la plateforme (code source, modèles IA, interface, logo, contenus) sont la propriété exclusive de leurs auteurs — MONTCHO Lysias et TCHEOUBI Osiax — dans le cadre de leur projet académique.</p>
                    <p>Toute reproduction, représentation, modification ou exploitation non autorisée est interdite.</p>
                </div>
            </div>

            {{-- Article 8 --}}
            <div class="glass rounded-2xl p-8 shadow-xl animate-fade-in">
                <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-agri-100 text-agri-700 flex items-center justify-center text-sm font-black">8</span>
                    Droit applicable et contact
                </h2>
                <div class="text-slate-600 leading-relaxed space-y-3">
                    <p>Les présentes CGU sont régies par le droit béninois. Tout litige relatif à leur interprétation ou exécution sera soumis aux juridictions compétentes de la République du Bénin.</p>
                    <p>Pour toute question relative aux présentes CGU, vous pouvez nous contacter à l'adresse :</p>
                    <a href="mailto:agripredictaibj@gmail.com" class="inline-flex items-center gap-2 px-4 py-2 bg-agri-50 hover:bg-agri-100 text-agri-700 rounded-xl font-medium transition-colors mt-2">
                        <i class="fas fa-envelope"></i>
                        agripredictaibj@gmail.com
                    </a>
                </div>
            </div>

        </div>

        {{-- Liens bas de page --}}
        <div class="mt-10 flex flex-wrap items-center justify-center gap-4 text-sm text-white/60">
            <a href="{{ route('accueil') }}" class="hover:text-white transition-colors flex items-center gap-1">
                <i class="fas fa-arrow-left text-xs"></i> Retour à l'accueil
            </a>
            <span>·</span>
            <a href="{{ route('legal.politique') }}" class="hover:text-white transition-colors">Politique de confidentialité</a>
            <span>·</span>
            <a href="{{ route('legal.guide') }}" class="hover:text-white transition-colors">Guide d'utilisation</a>
        </div>

    </div>
</div>
@endsection