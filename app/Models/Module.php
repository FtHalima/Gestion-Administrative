<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'code_module',
        'nom_module',
        'semestre_id',
        'professeur_id',
    ];

    protected $casts = [
        // No special casts
    ];

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function professeur()
    {
        return $this->belongsTo(Utilisateur::class, 'professeur_id', 'id');
    }

    public function notesExamen()
    {
        return $this->hasMany(NoteExamen::class);
    }

    public function notesModule()
    {
        return $this->hasMany(NoteModule::class);
    }
}