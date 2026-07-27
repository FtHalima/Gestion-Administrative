<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteExamen extends Model
{
    protected $table = 'notes_examens';

    public $timestamps = true;

    protected $fillable = [
        'etudiant_ppr',
        'annee_universitaire_id',
        'semestre_id',
        'module_id',
        'groupe_id',
        'type_exam',
        'note',
    ];

    protected $casts = [
        'note' => 'decimal:2',
        // enums are string
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