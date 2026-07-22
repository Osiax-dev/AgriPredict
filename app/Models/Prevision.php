<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prevision extends Model
{
    //
    protected $fillable = ['user_id', // ✅ AJOUT
'parcelle_id', 'saison_id', 'culture', 'ndvi', 'temperature', 'pluviometrie', 'humidite', 'rendement_prevu', 'production_totale', 'confiance', 'top_features', 'recommandations'];
    protected $casts = ['top_features' => 'array'];
    public function parcelle() { return $this->belongsTo(Parcelle::class); }
    public function saison() { return $this->belongsTo(Saison::class); }
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
}
