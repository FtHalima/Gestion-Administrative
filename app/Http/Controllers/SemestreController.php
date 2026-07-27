<?php

namespace App\Http\Controllers;

use App\Models\AnneeUniversitaire;
use App\Models\Semestre;
use App\Models\Module;
use App\Models\NoteSemestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SemestreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semestres = Semestre::with('anneeUniversitaire')->get();
        return view('semestres.index', compact('semestres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $annees = AnneeUniversitaire::all();
        return view('semestres.create', compact('annees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
            'annee_universitaire_id' => ['required', 'exists:annees_universitaires,id'],
            'statut' => ['required', 'string', 'in:debut,cloture'],
        ]);

        Semestre::create($validated);

        return Redirect::route('semestres.index')
            ->with('success', 'Semestre créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Semestre $semestre)
    {
        return view('semestres.show', compact('semestre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semestre $semestre)
    {
        $annees = AnneeUniversitaire::all();
        return view('semestres.edit', compact('semestre', 'annees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semestre $semestre)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
            'annee_universitaire_id' => ['required', 'exists:annees_universitaires,id'],
            'statut' => ['required', 'string', 'in:debut,cloture'],
        ]);

        $semestre->update($validated);

        return Redirect::route('semestres.index')
            ->with('success', 'Semestre mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semestre $semestre)
    {
        // Prevent deletion if modules or notes are linked
        $hasModules = Module::where('semestre_id', $semestre->id)->exists();
        $hasNotes = NoteSemestre::where('semestre_id', $semestre->id)->exists();

        if ($hasModules || $hasNotes) {
            return Redirect::back()
                ->with('error', 'Impossible de supprimer ce semestre car il est lié à des modules ou des notes de semestre.');
        }

        $semestre->delete();

        return Redirect::route('semestres.index')
            ->with('success', 'Semestre supprimé avec succès.');
    }
}
