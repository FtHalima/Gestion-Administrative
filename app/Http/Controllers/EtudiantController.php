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
    public function index()
    {
        $etudiants = Etudiant::with('groupe')->get();
        return view('etudiants.index', compact('etudiants'));
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
            'ppr' => ['required', 'string', 'max:255', 'unique:etudiant,ppr'],
            'cin' => ['nullable', 'string', 'max:255', 'unique:etudiant,cin'],
            'matricule' => ['nullable', 'string', 'max:255', 'unique:etudiant,matricule'],
            'groupe_id' => ['required', 'exists:groupes,id'],
            'nom_prenom_francais' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:etudiant,email'],
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
            'ppr' => ['required', 'string', 'max:255', 'unique:etudiant,ppr,' . $etudiant->ppr],
            'cin' => ['nullable', 'string', 'max:255', 'unique:etudiant,cin,' . $etudiant->ppr],
            'matricule' => ['nullable', 'string', 'max:255', 'unique:etudiant,matricule,' . $etudiant->ppr],
            'groupe_id' => ['required', 'exists:groupes,id'],
            'nom_prenom_francais' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:etudiant,email,' . $etudiant->ppr],
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
