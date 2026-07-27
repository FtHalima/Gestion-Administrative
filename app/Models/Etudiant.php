<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'etudiant';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'ppr';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ppr',
        'cin',
        'matricule',
        'groupe_id',
        'classe',
        'n_ordre',
        'nom_prenom_arabe',
        'nom_prenom_francais',
        'genre',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'telephone',
        'email',
        'baccalaureat',
        'direction_baccalaureat',
        'annee_baccalaureat',
        'licence',
        'annee_licence',
        'universite_licence',
        'faculte_licence',
        'autre_diplome',
        'specialite_diplome',
        'annee_diplome',
        'universite_diplome',
        'faculte_diplome',
        'centre',
        'ville_centre',
        'annee_sortie',
        'date_recrutement',
        'cadre',
        'grade',
        'anciennete_grade',
        'echelon',
        'anciennete_echelon',
        'dernier_etablissement',
        'cycle',
        'ville',
        'direction_provinciale',
        'matiere_ou_fonction',
        'photo',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'date_naissance' => 'date',
        'date_recrutement' => 'date',
        'annee_baccalaureat' => 'integer',
        'annee_licence' => 'integer',
        'annee_diplome' => 'integer',
        'annee_sortie' => 'integer',
        'n_ordre' => 'integer',
        'anciennete_grade' => 'integer',
        'anciennete_echelon' => 'integer',
        // Enums are cast automatically in newer Laravel versions; we keep as string.
    ];

    /**
     * Relationships
     */
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function notesExamen()
    {
        return $this->hasMany(NoteExamen::class, 'etudiant_ppr', 'ppr');
    }

    public function notesModule()
    {
        return $this->hasMany(NoteModule::class, 'etudiant_ppr', 'ppr');
    }

    public function notesSemestre()
    {
        return $this->hasMany(NoteSemestre::class, 'etudiant_ppr', 'ppr');
    }

    public function notesMemoire()
    {
        return $this->hasMany(NoteMemoire::class, 'etudiant_ppr', 'ppr');
    }

    public function notesStage()
    {
        return $this->hasMany(NoteStage::class, 'etudiant_ppr', 'ppr');
    }
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'ppr';
    }
}