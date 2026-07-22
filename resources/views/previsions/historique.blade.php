@extends('layouts.app')
@section('title', 'Historique des prévisions')

@section('contenu')
<div class="max-w-6xl mx-auto animate-slide-up">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <h2 class="text-3xl font-bold text-white">
            <i class="fas fa-history text-gold-400 mr-3"></i>Historique des prévisions
        </h2>
        <a href="{{ route('formulaire') }}" class="px-6 py-3 bg-gradient-to-r from-agri-500 to-cyan-500 hover:from-agri-600 hover:to-cyan-600 text-white font-semibold rounded-xl shadow-lg shadow-agri-500/30 transition-all duration-300 flex items-center gap-2 hover-lift">
            <i class="fas fa-plus"></i> Nouvelle prévision
        </a>
    </div>

    {{-- Filtres --}}
    <form method="GET" action="{{ route('historique.index') }}" class="glass rounded-2xl p-4 mb-6 flex flex-col sm:flex-row gap-3">
        <select name="culture" onchange="this.form.submit()" 
            class="px-4 py-2 border-2 border-slate-200 dark:border-slate-600 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all text-slate-700 dark:text-slate-200 font-medium bg-white dark:bg-slate-800">
<option value="">Toutes cultures</option>
<option value="Tomate" {{ request('culture') == 'Tomate' ? 'selected' : '' }}>🍅 Tomate</option>
<option value="Piment" {{ request('culture') == 'Piment' ? 'selected' : '' }}>🌶️ Piment</option>
<option value="Gombo" {{ request('culture') == 'Gombo' ? 'selected' : '' }}>🌿 Gombo</option>
<option value="Oignon" {{ request('culture') == 'Oignon' ? 'selected' : '' }}>🧅 Oignon</option>
<option value="Niebe" {{ request('culture') == 'Niebe' ? 'selected' : '' }}>🫘 Niébé</option>
<option value="Arachide" {{ request('culture') == 'Arachide' ? 'selected' : '' }}>🥜 Arachide</option>
<option value="Soja" {{ request('culture') == 'Soja' ? 'selected' : '' }}>🫘 Soja</option>
<option value="Goussi" {{ request('culture') == 'Goussi' ? 'selected' : '' }}>🌱 Goussi</option>
<option value="Ananas" {{ request('culture') == 'Ananas' ? 'selected' : '' }}>🍍 Ananas</option>
<option value="Coton" {{ request('culture') == 'Coton' ? 'selected' : '' }}>☁️ Coton</option>
<option value="Maïs" {{ request('culture') == 'Maïs' ? 'selected' : '' }}>🌽 Maïs</option>
<option value="Riz" {{ request('culture') == 'Riz' ? 'selected' : '' }}>🍚 Riz</option>
        </select>
        <select name="parcelle_id" onchange="this.form.submit()" 
            class="px-4 py-2 border-2 border-slate-200 dark:border-slate-600 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 dark:focus:ring-agri-800 transition-all text-slate-700 dark:text-slate-200 font-medium bg-white dark:bg-slate-800">
            <option value="">Toutes parcelles</option>
            @foreach($parcelles as $p)
                <option value="{{ $p->id }}" {{ request('parcelle_id') == $p->id ? 'selected' : '' }}>{{ $p->nom }}</option>
            @endforeach
        </select>
        @if(request('culture') || request('parcelle_id'))
            <a href="{{ route('historique.index') }}" 
                class="px-4 py-2 border-2 border-slate-200 dark:border-slate-600 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all text-center font-medium">
                Réinitialiser
            </a>
        @endif
    </form>

    @if($previsions->isEmpty())
        <div class="glass rounded-2xl p-12 text-center">
            <i class="fas fa-chart-bar text-6xl text-slate-300 dark:text-slate-600 mb-4"></i>
            <p class="text-slate-600 dark:text-slate-300 text-lg mb-4">Aucune prévision enregistrée.</p>
            <a href="{{ route('formulaire') }}" class="text-agri-600 dark:text-agri-400 font-semibold hover:text-agri-700 dark:hover:text-agri-300">
                Lancer votre première prévision →
            </a>
        </div>
    @else
        {{-- Tableau --}}
        <div class="glass rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-agri-50 to-cyan-50 dark:from-slate-800 dark:to-slate-700 border-b-2 border-agri-200 dark:border-slate-600">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">#</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Parcelle</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Culture</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Saison</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">NDVI</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Rendement prévu</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Confiance</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-200"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($previsions as $i => $prev)
                    @php
    $confiance = $prev->confiance;

    // Badge confiance
$cBg = $confiance >= 75 
    ? 'bg-green-600 text-white'
    : ($confiance >= 50 
        ? 'bg-orange-500 text-white'
        : 'bg-red-600 text-white');


    // Badge culture unique pour toutes les cultures
$cultureBg = 'bg-green-500 text-white dark:bg-green-600 dark:text-white';    $cultureIcon = '🌱';
@endphp
                            <tr class="border-b border-slate-100 dark:border-slate-700 hover:bg-agri-50/50 dark:hover:bg-slate-800/50 transition-colors {{ $i % 2 == 0 ? '' : 'bg-slate-50/50 dark:bg-slate-800/30' }}">
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400 font-semibold">
                                    #{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800 dark:text-slate-100">
                                    {{ $prev->parcelle->nom ?? '—' }}
                                    @if($prev->parcelle && $prev->parcelle->commune)
                                        <div class="text-xs text-slate-400 dark:text-slate-500 font-normal">{{ $prev->parcelle->commune }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
<span class="inline-flex items-center px-3 py-1 rounded-full {{ $cultureBg }} text-xs font-bold shadow-sm">
    {{ $cultureIcon }} {{ $prev->culture }}
</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $prev->saison->nom ?? '—' }}</td>
                                <td class="px-6 py-4 font-bold text-agri-700 dark:text-agri-400">{{ $prev->ndvi }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800 dark:text-slate-100">{{ $prev->rendement_prevu }} t/ha</td>
                                <td class="px-6 py-4">
<span class="inline-flex items-center px-3 py-1 rounded-full {{ $cBg }} text-xs font-bold shadow-sm">
    {{ $prev->confiance }}%
</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $prev->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('historique.show', $prev) }}" class="text-agri-600 dark:text-agri-400 hover:text-agri-700 dark:hover:text-agri-300 font-semibold text-sm">
                                        Voir →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Graphique --}}
        <div class="glass rounded-2xl p-6 shadow-xl">
            <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-4">
                <i class="fas fa-chart-line text-agri-600 dark:text-agri-400 mr-2"></i>Évolution des rendements prévus
            </h4>
<div style="height:350px">
    <canvas id="graphique"></canvas>
</div>        </div>
    @endif
</div>

@push('scripts')
<script>
@if(!$previsions->isEmpty())

const isDark = document.documentElement.classList.contains('dark');

const textColor = isDark ? '#f1f5f9' : '#475569';

const gridColor = isDark 
    ? 'rgba(255,255,255,0.08)' 
    : 'rgba(0,0,0,0.05)';


// Dates
const labels = @json(
    $previsions->reverse()->values()
    ->pluck('created_at')
    ->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))
);


// Cultures venant de Laravel
const cultures = @json($cultures);


// Données
const previsionsData = @json(
    $previsions->reverse()->values()
    ->map(fn($p) => [
        'culture' => $p->culture,
        'rendement' => $p->rendement_prevu
    ])
);

// Palette agricole
const couleurs = [
    '#22c55e',
    '#f59e0b',
    '#06b6d4',
    '#ef4444',
    '#8b5cf6',
    '#ec4899',
    '#14b8a6',
    '#84cc16',
    '#f97316',
    '#6366f1',
    '#64748b',
    '#a855f7'
];


// Génération automatique
const datasets = cultures.map((culture,index)=>{

    const couleur = couleurs[index % couleurs.length];


    return {

        label: '🌱 ' + culture + ' (t/ha)',


        data: previsionsData.map(item =>
            item.culture === culture
            ? item.rendement
            : null
        ),


        borderColor: couleur,


        backgroundColor: couleur + '33',


        fill:true,


        tension:0.4,


        spanGaps:true,


        pointRadius:6,


        pointHoverRadius:8,


        pointBackgroundColor:couleur,


        pointBorderColor:'#ffffff',


        pointBorderWidth:2,


        borderWidth:3

    };

});



new Chart(
    document.getElementById('graphique'),
{

    type:'line',


    data:{

        labels:labels,

        datasets:datasets

    },


    options:{


        responsive:true,


        maintainAspectRatio:false,


        animation:{

            duration:1000

        },


        elements:{

            line:{

                tension:0.4

            },

            point:{

                radius:6

            }

        },


        plugins:{


            legend:{


                position:'bottom',


                labels:{


                    color:textColor,


                    padding:20,


                    font:{

                        size:13,

                        weight:'600'

                    }

                }

            },



            tooltip:{


                backgroundColor:isDark
                ? '#0f172a'
                : '#ffffff',



                titleColor:isDark
                ? '#ffffff'
                : '#1e293b',



                bodyColor:isDark
                ? '#cbd5e1'
                : '#475569',



                padding:12,


                borderWidth:1,


                callbacks:{


                    label:function(context){


                        if(context.parsed.y !== null){


                            return context.dataset.label
                            +' : '
                            +context.parsed.y
                            +' t/ha';

                        }


                    }

                }

            }

        },



        scales:{


            y:{


                beginAtZero:true,


                title:{


                    display:true,


                    text:'Rendement (t/ha)',


                    color:textColor,


                    font:{


                        size:12,


                        weight:'600'

                    }

                },


                ticks:{


                    color:textColor

                },


                grid:{


                    color:gridColor

                }

            },



            x:{


                ticks:{


                    color:textColor

                },


                grid:{


                    display:false

                },


                title:{


                    display:true,


                    text:'Date de prévision',


                    color:textColor,


                    font:{


                        size:12,


                        weight:'600'

                    }

                }

            }

        }

    }

});



// Rafraîchir au changement du thème
const observer = new MutationObserver(()=>{

    location.reload();

});


observer.observe(
    document.documentElement,
    {
        attributes:true
    }
);


@endif
</script>
@endpush
@endsection