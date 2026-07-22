<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    protected $fillable = [
        'user_id',
        'parcelle_id',
        'nom',
        'culture',
        'region',
        'type_saison',
        'campagne',
        'pluies_confirmees',
        'cumul_pluies_mm',
        'date_debut',
        'date_fin',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'pluies_confirmees' => 'boolean',
        'cumul_pluies_mm' => 'decimal:2',
    ];

    public function previsions()
    {
        return $this->hasMany(Prevision::class);
    }

    public function parcelle()
    {
        return $this->belongsTo(Parcelle::class);
    }

    public function joursEcoules(): int
    {
        $today = now();
        if ($today < $this->date_debut) return 0;
        if ($today > $this->date_fin) return $this->date_debut->diffInDays($this->date_fin);
        return $this->date_debut->diffInDays($today);
    }

    public function joursRestants(): int
    {
        $today = now();
        if ($today > $this->date_fin) return 0;
        return intval($today->diffInDays($this->date_fin));
    }
}