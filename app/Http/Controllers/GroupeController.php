<?php

namespace App\Http\Controllers;

use App\Models\AnneeUniversitaire;
use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\NoteExamen;
use App\Models\NoteModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GroupeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupes = Groupe::with('anneeUniversitaire')->get();
        return view('groupes.index', compact('groupes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $annees = AnneeUniversitaire::all();
        return view('groupes.create', compact('annees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_groupe' => ['required', 'string', 'max:255'],
            'annee_universitaire_id' => ['required', 'exists:annees_universitaires,id'],
        ], [
            'nom_groupe.unique' => 'La combinaison nom groupe / année universitaire existe déjà.',
        ]);

        // Ensure unique combination
        $exists = Groupe::where('nom_groupe', $validated['nom_groupe'])
            ->where('annee_universitaire_id', $validated['annee_universitaire_id'])
            ->exists();

        if ($exists) {
            return Redirect::back()
                ->withInput()
                ->withErrors(['nom_groupe' => 'La combinaison nom groupe / année universitaire existe déjà.']);
        }

        Groupe::create($validated);

        return Redirect::route('groupes.index')
            ->with('success', 'Groupe créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Groupe $groupe)
    {
        return view('groupes.show', compact('groupe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Groupe $groupe)
    {
        $annees = AnneeUniversitaire::all();
        return view('groupes.edit', compact('groupe', 'annees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Groupe $groupe)
    {
        $validated = $request->validate([
            'nom_groupe' => ['required', 'string', 'max:255'],
            'annee_universitaire_id' => ['required', 'exists:annees_universitaires,id'],
        ]);

        // Check unique combination excluding current record
        $exists = Groupe::where('nom_groupe', $validated['nom_groupe'])
            ->where('annee_universitaire_id', $validated['annee_universitaire_id'])
            ->where('id', '<>', $groupe->id)
            ->exists();

        if ($exists) {
            return Redirect::back()
                ->withInput()
                ->withErrors(['nom_groupe' => 'La combinaison nom groupe / année universitaire existe déjà.']);
        }

        $groupe->update($validated);

        return Redirect::route('groupes.index')
            ->with('success', 'Groupe mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Groupe $groupe)
    {
        // Prevent deletion if students or notes linked
        $hasEtudiants = Etudiant::where('groupe_id', $groupe->id)->exists();
        $hasNotesExamen = NoteExamen::where('groupe_id', $groupe->id)->exists();
        $hasNotesModule = NoteModule::where('groupe_id', $groupe->id)->exists();

        if ($hasEtudiants || $hasNotesExamen || $hasNotesModule) {
            return Redirect::back()
                ->with('error', 'Impossible de supprimer ce groupe car il est lié à des étudiants ou des notes (examen ou module).');
        }

        $groupe->delete();

        return Redirect::route('groupes.index')
            ->with('success', 'Groupe supprimé avec succès.');
    }
}
