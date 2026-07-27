<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteMemoire extends Model
{
    protected $table = 'notes_memoires';

    public $timestamps = true;

    protected $fillable = [
        'etudiant_ppr',
        'annee_universitaire_id',
        'groupe_id',
        'titre_memoire',
        'encadrant',
        'note_soutenance',
        'note_rapport',
        'moyenne',
    ];

    protected $casts = [
        'note_soutenance' => 'decimal:2',
        'note_rapport' => 'decimal:2',
        'moyenne' => 'decimal:2',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_ppr', 'ppr');
    }

    public function anneeUniversitaire()
    {
        return $this->belongsTo(AnneeUniversitaire::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function encadrant()
    {
        return $this->belongsTo(Utilisateur::class, 'encadrant', 'id');
    }
}