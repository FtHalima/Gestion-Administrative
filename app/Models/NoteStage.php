<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteStage extends Model
{
    protected $table = 'notes_stages';

    public $timestamps = true;

    protected $fillable = [
        'etudiant_ppr',
        'annee_universitaire_id',
        'semestre_id',
        'groupe_id',
        'etablissement_accueil',
        'tuteur_academique',
        'note',
        'fichier_url',
    ];

    protected $casts = [
        'note' => 'decimal:2',
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

    public function tuteurAcademique()
    {
        return $this->belongsTo(Utilisateur::class, 'tuteur_academique', 'id');
    }
}