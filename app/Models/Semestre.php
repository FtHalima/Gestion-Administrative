<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $table = 'semestres';

    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'annee_universitaire_id',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function anneeUniversitaire()
    {
        return $this->belongsTo(AnneeUniversitaire::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

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

    public function notesStage()
    {
        return $this->hasMany(NoteStage::class);
    }
}