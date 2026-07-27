<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\NoteExamen;
use App\Models\NoteModule;
use App\Models\NoteSemestre;
use App\Models\NoteMemoire;
use App\Models\NoteStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Etudiant::with('groupe');

        // Filter by groupe
        if ($request->filled('groupe_id')) {
            $query->where('groupe_id', $request->get('groupe_id'));
        }

        // Search by nom_prenom_francais, matricule, cin
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom_prenom_francais', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%")
                    ->orWhere('cin', 'like', "%{$search}%");
            });
        }

        $etudiants = $query->get();
        $groupes = Groupe::all();

        return view('etudiants.index', compact('etudiants', 'groupes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groupes = Groupe::all();
        return view('etudiants.create', compact('groupes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ppr' => ['required', 'integer', 'unique:etudiant,ppr'],
            'cin' => ['nullable', 'string', 'max:255', 'unique:etudiant,cin'],
            'matricule' => ['nullable', 'string', 'max:255', 'unique:etudiant,matricule'],
            'groupe_id' => ['required', 'exists:groupes,id'],
            'nom_prenom_francais' => ['required', 'string', 'max:255'],
            'nom_prenom_arabe' => ['nullable', 'string', 'max:255'],
            'genre' => ['nullable', 'in:M,F'],
            'date_naissance' => ['nullable', 'date'],
            'lieu_naissance' => ['nullable', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:etudiant,email'],
            'baccalaureat' => ['nullable', 'string', 'max:255'],
            'direction_baccalaureat' => ['nullable', 'string', 'max:255'],
            'annee_baccalaureat' => ['nullable', 'string', 'max:255'],
            'licence' => ['nullable', 'string', 'max:255'],
            'annee_licence' => ['nullable', 'string', 'max:255'],
            'universite_licence' => ['nullable', 'string', 'max:255'],
            'faculte_licence' => ['nullable', 'string', 'max:255'],
            'autre_diplome' => ['nullable', 'string', 'max:255'],
            'specialite_diplome' => ['nullable', 'string', 'max:255'],
            'annee_diplome' => ['nullable', 'string', 'max:255'],
            'universite_diplome' => ['nullable', 'string', 'max:255'],
            'faculte_diplome' => ['nullable', 'string', 'max:255'],
            'centre' => ['nullable', 'string', 'max:255'],
            'ville_centre' => ['nullable', 'string', 'max:255'],
            'annee_sortie' => ['nullable', 'string', 'max:255'],
            'date_recrutement' => ['nullable', 'date'],
            'cadre' => ['nullable', 'string', 'max:255'],
            'grade' => ['nullable', 'string', 'max:255'],
            'anciennete_grade' => ['nullable', 'date'],
            'echelon' => ['nullable', 'string', 'max:255'],
            'anciennete_echelon' => ['nullable', 'date'],
            'dernier_etablissement' => ['nullable', 'string', 'max:255'],
            'matiere_ou_fonction' => ['nullable', 'string', 'max:255'],
            'cycle' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'direction_provinciale' => ['nullable', 'string', 'max:255'],
            'classe' => ['nullable', 'string', 'max:255'],
            'n_ordre' => ['nullable', 'string', 'max:255'],
        ]);

        Etudiant::create($validated);

        return Redirect::route('etudiants.index')
            ->with('success', 'Étudiant créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Etudiant $etudiant)
    {
        return view('etudiants.show', compact('etudiant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etudiant $etudiant)
    {
        $groupes = Groupe::all();
        return view('etudiants.edit', compact('etudiant', 'groupes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        $validated = $request->validate([
            'ppr' => ['required', 'integer', 'unique:etudiant,ppr,' . $etudiant->ppr . ',ppr'],
            'cin' => ['nullable', 'string', 'max:255', 'unique:etudiant,cin,' . $etudiant->ppr . ',ppr'],
            'matricule' => ['nullable', 'string', 'max:255', 'unique:etudiant,matricule,' . $etudiant->ppr . ',ppr'],
            'groupe_id' => ['required', 'exists:groupes,id'],
            'nom_prenom_francais' => ['required', 'string', 'max:255'],
            'nom_prenom_arabe' => ['nullable', 'string', 'max:255'],
            'genre' => ['nullable', 'in:M,F'],
            'date_naissance' => ['nullable', 'date'],
            'lieu_naissance' => ['nullable', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:etudiant,email,' . $etudiant->ppr . ',ppr'],
            'baccalaureat' => ['nullable', 'string', 'max:255'],
            'direction_baccalaureat' => ['nullable', 'string', 'max:255'],
            'annee_baccalaureat' => ['nullable', 'string', 'max:255'],
            'licence' => ['nullable', 'string', 'max:255'],
            'annee_licence' => ['nullable', 'string', 'max:255'],
            'universite_licence' => ['nullable', 'string', 'max:255'],
            'faculte_licence' => ['nullable', 'string', 'max:255'],
            'autre_diplome' => ['nullable', 'string', 'max:255'],
            'specialite_diplome' => ['nullable', 'string', 'max:255'],
            'annee_diplome' => ['nullable', 'string', 'max:255'],
            'universite_diplome' => ['nullable', 'string', 'max:255'],
            'faculte_diplome' => ['nullable', 'string', 'max:255'],
            'centre' => ['nullable', 'string', 'max:255'],
            'ville_centre' => ['nullable', 'string', 'max:255'],
            'annee_sortie' => ['nullable', 'string', 'max:255'],
            'date_recrutement' => ['nullable', 'date'],
            'cadre' => ['nullable', 'string', 'max:255'],
            'grade' => ['nullable', 'string', 'max:255'],
            'anciennete_grade' => ['nullable', 'date'],
            'echelon' => ['nullable', 'string', 'max:255'],
            'anciennete_echelon' => ['nullable', 'date'],
            'dernier_etablissement' => ['nullable', 'string', 'max:255'],
            'matiere_ou_fonction' => ['nullable', 'string', 'max:255'],
            'cycle' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:255'],
            'direction_provinciale' => ['nullable', 'string', 'max:255'],
            'classe' => ['nullable', 'string', 'max:255'],
            'n_ordre' => ['nullable', 'string', 'max:255'],
        ]);

        $etudiant->update($validated);

        return Redirect::route('etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etudiant $etudiant)
    {
        $hasNotesExamen = NoteExamen::where('etudiant_ppr', $etudiant->ppr)->exists();
        $hasNotesModule = NoteModule::where('etudiant_ppr', $etudiant->ppr)->exists();
        $hasNotesSemestre = NoteSemestre::where('etudiant_ppr', $etudiant->ppr)->exists();
        $hasNotesMemoire = NoteMemoire::where('etudiant_ppr', $etudiant->ppr)->exists();
        $hasNotesStage = NoteStage::where('etudiant_ppr', $etudiant->ppr)->exists();

        if ($hasNotesExamen || $hasNotesModule || $hasNotesSemestre || $hasNotesMemoire || $hasNotesStage) {
            return Redirect::back()
                ->with('error', 'Impossible de supprimer cet étudiant car il possède des notes associées.');
        }

        $etudiant->delete();

        return Redirect::route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}
