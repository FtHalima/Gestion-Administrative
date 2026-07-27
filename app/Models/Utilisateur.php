<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Utilisateur extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'role',
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'telephone',
        'statut',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    protected $casts = [
        // No special casts needed; timestamps handled automatically
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'professeur_id');
    }

    public function noteMemoires()
    {
        return $this->hasMany(NoteMemoire::class, 'encadrant');
    }

    public function noteStages()
    {
        return $this->hasMany(NoteStage::class, 'tuteur_academique');
    }
}
