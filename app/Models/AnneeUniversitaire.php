<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeUniversitaire extends Model
{
    protected $table = 'annees_universitaires';

    public $timestamps = true;

    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'statut',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }

    public function semestres()
    {
        return $this->hasMany(Semestre::class);
    }
}