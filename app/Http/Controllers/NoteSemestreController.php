<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnneeUniversitaire;
use App\Models\Semestre;
use App\Models\Groupe;
use App\Models\Etudiant;
use App\Models\NoteModule;
use App\Models\NoteSemestre;
use Illuminate\Validation\Rule;

class NoteSemestreController extends Controller
{
    /**
     * Display the semester notes filter form.
     */
    public function index()
    {
        $annees = AnneeUniversitaire::withoutGlobalScopes()->get();
        $semestres = Semestre::all();
        $groupes = Groupe::all();

        return view('note_semestres.index', compact('annees', 'semestres', 'groupes'));
    }

    /**
     * Process the filter request and compute semester averages.
     */
    public function filtrer(Request $request)
    {
        $annees = AnneeUniversitaire::withoutGlobalScopes()->get();
        $semestres = Semestre::all();
        $groupes = Groupe::all();

        $validated = $request->validate([
            'annee_universitaire_id' => ['nullable', 'integer', Rule::exists('annees_universitaires', 'id')],
            'semestre_id' => ['nullable', 'integer', Rule::exists('semestres', 'id')],
            'groupe_id' => ['nullable', 'integer', Rule::exists('groupes', 'id')],
        ]);

        $anneeId = $validated['annee_universitaire_id'];
        $semestreId = $validated['semestre_id'];
        $groupeId = $validated['groupe_id'];

        $etudiants = collect();
        $resultats = [];

        // If required filters are missing, return empty results
        if (!$groupeId || !$semestreId) {
            return view('note_semestres.index', compact(
                'annees', 'semestres', 'groupes',
                'etudiants', 'resultats',
                'anneeId', 'semestreId', 'groupeId'
            ));
        }

        // Fetch students of the selected group
        $etudiants = Etudiant::where('groupe_id', $groupeId)->get();

        foreach ($etudiants as $etudiant) {
            // Get all module notes for this student, semester, and academic year
            $notesModules = NoteModule::where('etudiant_ppr', $etudiant->ppr)
                ->where('semestre_id', $semestreId)
                ->where('annee_universitaire_id', $anneeId)
                ->get();

            if ($notesModules->isNotEmpty()) {
                $moyenne = $notesModules->avg('moyenne');
                $nbModules = $notesModules->count();

                // Determine statut based on moyenne
                if ($moyenne > 10) {
                    $statut = 'Validé';
                } elseif ($moyenne == 10) {
                    $statut = 'Racheter';
                } else {
                    $statut = 'Rattrapage';
                }
            } else {
                $moyenne = null;
                $nbModules = 0;
                $statut = null;
            }

            $resultats[$etudiant->ppr] = [
                'moyenne' => $moyenne,
                'statut' => $statut,
                'nb_modules' => $nbModules,
            ];
        }

        return view('note_semestres.index', compact(
            'annees', 'semestres', 'groupes',
            'etudiants', 'resultats',
            'anneeId', 'semestreId', 'groupeId'
        ));
    }

    /**
     * Save computed semester averages.
     */
    public function enregistrer(Request $request)
    {
        $validated = $request->validate([
            'annee_universitaire_id' => ['required', 'integer', Rule::exists('annees_universitaires', 'id')],
            'semestre_id' => ['required', 'integer', Rule::exists('semestres', 'id')],
            'groupe_id' => ['required', 'integer', Rule::exists('groupes', 'id')],
        ]);

        $anneeId = $validated['annee_universitaire_id'];
        $semestreId = $validated['semestre_id'];
        $groupeId = $validated['groupe_id'];

        // Retrieve students of the group
        $etudiants = Etudiant::where('groupe_id', $groupeId)->get();

        foreach ($etudiants as $etudiant) {
            // Recalculate average (same logic as in filtrer)
            $notesModules = NoteModule::where('etudiant_ppr', $etudiant->ppr)
                ->where('semestre_id', $semestreId)
                ->where('annee_universitaire_id', $anneeId)
                ->get();

            if ($notesModules->isNotEmpty()) {
                $moyenne = $notesModules->avg('moyenne');

                if ($moyenne > 10) {
                    $statut = 'Validé';
                } elseif ($moyenne == 10) {
                    $statut = 'Racheter';
                } else {
                    $statut = 'Rattrapage';
                }

                // Save or update the semester record
                NoteSemestre::updateOrCreate(
                    [
                        'etudiant_ppr' => $etudiant->ppr,
                        'semestre_id' => $semestreId,
                        'annee_universitaire_id' => $anneeId,
                    ],
                    [
                        'groupe_id' => $groupeId,
                        'moyenne' => $moyenne,
                        'statut' => $statut,
                    ]
                );
            }
            // If no module notes, we do not create/update a record (as per requirement)
        }

        return redirect()->route('note-semestres.index')
            ->with('success', 'Notes de semestre validées avec succès.');
    }
}