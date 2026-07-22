<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcelle extends Model
{
    //
        protected $fillable = ['user_id', 'nom', 'superficie', 'culture', 'type_sol', 'lat', 'lng', 'ndvi_actuel', 'departement', 'commune', 'notes'];
    public function previsions() { return $this->hasMany(Prevision::class); }
    public function saisons() { return $this->hasMany(Saison::class); }
    public function dernierePrevision() { return $this->hasOne(Prevision::class)->latestOfMany(); }
}
