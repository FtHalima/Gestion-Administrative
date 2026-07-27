<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $table = 'groupes';

    protected $fillable = [
        'nom_groupe',
        'annee_universitaire_id',
    ];

    protected $casts = [
        // No special casts
    ];

    public function anneeUniversitaire()
    {
        return $this->belongsTo(AnneeUniversitaire::class);
    }

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    // Inverse of many notes? Actually notes belong to Groupe via groupe_id.
    public function notesExamen()
    {
        return $this->hasMany(NoteExamen::class);
    }

    public function notesModule()
    {
        return $this->hasMany(NoteModule::class);
    }

    public function notesSemestre()
    {
        return $this->hasMany(NoteSemestre::class);
    }

    public function notesMemoire()
    {
        return $this->hasMany(NoteMemoire::class);
    }

    public function notesStage()
    {
        return $this->hasMany(NoteStage::class);
    }
}