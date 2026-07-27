<?php

namespace App\Http\Controllers;

use App\Models\AnneeUniversitaire;
use App\Models\Groupe;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AnneeUniversitaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $annees = AnneeUniversitaire::orderBy('date_debut', 'desc')->get();
        return view('annees-universitaires.index', compact('annees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('annees-universitaires.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:annees_universitaires,nom'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
            'statut' => ['required', 'string', 'in:actif,archivée'],
        ]);

        AnneeUniversitaire::create($validated);

        return Redirect::route('annees-universitaires.index')
            ->with('success', 'Année universitaire créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnneeUniversitaire $anneeUniversitaire)
    {
        // Not needed for CREF but we can show details if wanted
        return view('annees-universitaires.show', compact('anneeUniversitaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnneeUniversitaire $anneeUniversitaire)
    {
        return view('annees-universitaires.edit', compact('anneeUniversitaire'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnneeUniversitaire $anneeUniversitaire)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255', 'unique:annees_universitaires,nom,' . $anneeUniversitaire->id],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after:date_debut'],
            'statut' => ['required', 'string', 'in:actif,archivée'],
        ]);

        $anneeUniversitaire->update($validated);

        return Redirect::route('annees-universitaires.index')
            ->with('success', 'Année universitaire mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnneeUniversitaire $anneeUniversitaire)
    {
        // Check if any groupes are linked to this annee universitaire
        $hasGroupes = Groupe::where('annee_universitaire_id', $anneeUniversitaire->id)->exists();
        // Check if any semestres are linked
        $hasSemestres = Semestre::where('annee_universitaire_id', $anneeUniversitaire->id)->exists();

        if ($hasGroupes || $hasSemestres) {
            return Redirect::back()
                ->with('error', 'Impossible de supprimer cette année universitaire car elle est liée à des groupes ou des semestres.');
        }

        $anneeUniversitaire->delete();

        return Redirect::route('annees-universitaires.index')
            ->with('success', 'Année universitaire supprimée avec succès.');
    }
}