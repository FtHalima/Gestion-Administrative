<?php

namespace App\Http\Controllers;

use App\Models\AnneeUniversitaire;
use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\NoteExamen;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NoteExamenController extends Controller
{
    /**
     * Display the filter form for entering exam notes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $annees = AnneeUniversitaire::all();
        $semestres = Semestre::all();
        if (auth()->user()->role === 'enseignant') {
            $modules = Module::where('professeur_id', auth()->id())->get();
        } else {
            $modules = Module::all();
        }
        $groupes = Groupe::all();

        return view('note_examens.index', compact(
            'annees',
            'semestres',
            'modules',
            'groupes'
        ));
    }

    /**
     * Handle the filter submission and show students with existing notes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function filtrer(Request $request)
    {
        // Validate filter inputs (optional)
        $request->validate([
            'annee_universitaire_id' => 'nullable|exists:annees_universitaires,id',
            'semestre_id' => 'nullable|exists:semestres,id',
            'module_id' => 'nullable|exists:modules,id',
            'groupe_id' => 'nullable|exists:groupes,id',
            'type_exam' => 'nullable|string',
        ]);

        // Get filter values
        $anneeId = $request->input('annee_universitaire_id');
        $semestreId = $request->input('semestre_id');
        $moduleId = $request->input('module_id');
        $groupeId = $request->input('groupe_id');
        $typeExam = $request->input('type_exam');

        // Security check for enseignant
        if (auth()->user()->role === 'enseignant' && $moduleId) {
            $module = Module::find($moduleId);
            if (!$module || $module->professeur_id !== auth()->id()) {
                abort(403, "Vous n'êtes pas autorisé à accéder à ce module.");
            }
        }

        // Load filter lists for the view
        $annees = AnneeUniversitaire::all();
        $semestres = Semestre::all();
        if (auth()->user()->role === 'enseignant') {
            $modules = Module::where('professeur_id', auth()->id())->get();
        } else {
            $modules = Module::all();
        }
        $groupes = Groupe::all();

        // If no group selected, show empty list
        if (!$groupeId) {
            $etudiants = collect();
            $notes = collect();
            return view('note_examens.index', compact(
                'annees',
                'semestres',
                'modules',
                'groupes',
                'etudiants',
                'notes'
            ));
        }

        // Get students of the selected group
        $etudiants = Etudiant::where('groupe_id', $groupeId)->get();

        // Fetch existing notes matching the filters
        $notes = collect();
        if ($etudiants->isNotEmpty() && $anneeId && $moduleId && $typeExam) {
            $notes = NoteExamen::whereIn('etudiant_ppr', $etudiants->pluck('ppr'))
                ->where('annee_universitaire_id', $anneeId)
                ->where('module_id', $moduleId)
                ->where('type_exam', $typeExam)
                ->get()
                ->keyBy('etudiant_ppr'); // key by student ppr for easy lookup
        }

        return view('note_examens.index', compact(
            'annees',
            'semestres',
            'modules',
            'groupes',
            'etudiants',
            'notes',
            'anneeId',
            'semestreId',
            'moduleId',
            'groupeId',
            'typeExam'
        ));
    }

    /**
     * Store the exam notes for the selected filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enregistrer(Request $request)
    {
        $request->validate([
            'annee_universitaire_id' => 'required|exists:annees_universitaires,id',
            'semestre_id' => 'required|exists:semestres,id',
            'module_id' => 'required|exists:modules,id',
            'groupe_id' => 'required|exists:groupes,id',
            'type_exam' => 'required|in:CC,Examen',
            'notes' => 'required|array',
            'notes.*' => 'nullable|numeric|min:0|max:20',
        ]);

        // Security check for enseignant
        if (auth()->user()->role === 'enseignant') {
            $module = Module::find($request->module_id);
            if (!$module || $module->professeur_id !== auth()->id()) {
                abort(403, "Vous n'êtes pas autorisé à modifier les notes de ce module.");
            }
        }

        foreach ($request->notes as $etudiantPpr => $note) {
            if ($note === null || $note === '') {
                continue; // ne pas enregistrer les champs laissés vides
            }

            NoteExamen::updateOrCreate(
                [
                    'etudiant_ppr' => $etudiantPpr,
                    'annee_universitaire_id' => $request->annee_universitaire_id,
                    'module_id' => $request->module_id,
                    'type_exam' => $request->type_exam,
                ],
                [
                    'semestre_id' => $request->semestre_id,
                    'groupe_id' => $request->groupe_id,
                    'note' => $note,
                ]
            );
        }

        return redirect()->back()->with('success', 'Notes enregistrées avec succès.');
    }
}