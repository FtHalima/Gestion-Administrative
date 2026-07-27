<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteSemestre extends Model
{
    protected $table = 'notes_semestres';

    public $timestamps = true;

    protected $fillable = [
        'etudiant_ppr',
        'annee_universitaire_id',
        'semestre_id',
        'groupe_id',
        'moyenne',
        'statut',
    ];

    protected $casts = [
        'moyenne' => 'decimal:2',
        // statut string
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_ppr', 'ppr');
    }

    public function anneeUniversitaire()
    {
        return $this->belongsTo(AnneeUniversitaire::class);
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
}