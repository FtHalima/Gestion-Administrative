<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteModule extends Model
{
    protected $table = 'notes_modules';

    public $timestamps = true;

    protected $fillable = [
        'etudiant_ppr',
        'annee_universitaire_id',
        'semestre_id',
        'module_id',
        'groupe_id',
        'note_controle',
        'note_exam',
        'moyenne',
        'statut',
    ];

    protected $casts = [
        'note_controle' => 'decimal:2',
        'note_exam' => 'decimal:2',
        'moyenne' => 'decimal:2',
        // statut is string
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

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
}