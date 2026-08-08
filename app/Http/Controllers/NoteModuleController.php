<?php

namespace App\Http\Controllers;

use App\Models\AnneeUniversitaire;
use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\NoteModule;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NoteModuleController extends Controller
{
    /**
     * Display the filter form for entering module notes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $annees = AnneeUniversitaire::withoutGlobalScopes()->get();
        $semestres = Semestre::all();
        if (auth()->user()->role === 'enseignant') {
            $modules = Module::where('professeur_id', auth()->id())->get();
        } else {
            $modules = Module::all();
        }
        $groupes = Groupe::all();

        return view('note_modules.index', compact(
            'annees',
            'semestres',
            'modules',
            'groupes'
        ));
    }

    /**
     * Handle the filter submission and show students with existing module notes.
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
        ]);

        // Get filter values
        $anneeId = $request->input('annee_universitaire_id');
        $semestreId = $request->input('semestre_id');
        $moduleId = $request->input('module_id');
        $groupeId = $request->input('groupe_id');

        // Security check for enseignant
        if (auth()->user()->role === 'enseignant' && $moduleId) {
            $module = Module::find($moduleId);
            if (!$module || $module->professeur_id !== auth()->id()) {
                abort(403, "Vous n'êtes pas autorisé à accéder à ce module.");
            }
        }

        // Load filter lists for the view
        $annees = AnneeUniversitaire::withoutGlobalScopes()->get();
        $semestres = Semestre::all();
        if (auth()->user()->role === 'enseignant') {
            $modules = Module::where('professeur_id', auth()->id())->get();
        } else {
            $modules = Module::all();
        }
        $groupes = Groupe::all();

        // If no group selected, show empty lists
        if (!$groupeId) {
            $etudiants = collect();
            $notes = collect();
            return view('note_modules.index', compact(
                'annees',
                'semestres',
                'modules',
                'groupes',
                'etudiants',
                'notes',
                'anneeId',
                'semestreId',
                'moduleId',
                'groupeId'
            ));
        }

        // Get students of the selected group
        $etudiants = Etudiant::where('groupe_id', $groupeId)->get();

        // Fetch existing module notes matching the filters
        $notes = collect();
        if ($etudiants->isNotEmpty() && $anneeId && $moduleId) {
            $notes = NoteModule::whereIn('etudiant_ppr', $etudiants->pluck('ppr'))
                ->where('annee_universitaire_id', $anneeId)
                ->where('module_id', $moduleId)
                ->get()
                ->keyBy('etudiant_ppr'); // key by student ppr for easy lookup
        }

        return view('note_modules.index', compact(
            'annees',
            'semestres',
            'modules',
            'groupes',
            'etudiants',
            'notes',
            'anneeId',
            'semestreId',
            'moduleId',
            'groupeId'
        ));
    }

    /**
     * Store the module notes (contrôle and examen) for the selected filter.
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
            'notes_controle' => 'required|array',
            'notes_exam' => 'required|array',
            'notes_controle.*' => 'nullable|numeric|min:0|max:20',
            'notes_exam.*' => 'nullable|numeric|min:0|max:20',
        ]);

        // Security check for enseignant
        if (auth()->user()->role === 'enseignant') {
            $module = Module::find($request->module_id);
            if (!$module || $module->professeur_id !== auth()->id()) {
                abort(403, "Vous n'êtes pas autorisé à modifier les notes de ce module.");
            }
        }

        // Get the student list again to iterate over only those in the selected group
        $etudiants = Etudiant::where('groupe_id', $request->groupe_id)
            ->pluck('ppr') // we only need the PPRs for iteration
            ->toArray();

        foreach ($etudiants as $ppr) {
            $noteControle = $request->input("notes_controle.$ppr");
            $noteExam     = $request->input("notes_exam.$ppr");

            // Skip if either note is missing/empty
            if ($noteControle === null || $noteControle === '' ||
                $noteExam     === null || $noteExam     === '') {
                continue;
            }

            // Calculate weighted average: 25% contrôle, 75% examen
            $moyenne = ($noteControle * 0.25) + ($noteExam * 0.75);

            // Determine status based on the average
            if ($moyenne > 10) {
                $statut = 'Validé';
            } elseif ($moyenne == 10) {
                $statut = 'Racheter';
            } else {
                $statut = 'Rattrapage';
            }

            // Upsert the record
            NoteModule::updateOrCreate(
                [
                    'etudiant_ppr' => $ppr,
                    'annee_universitaire_id' => $request->annee_universitaire_id,
                    'module_id' => $request->module_id,
                ],
                [
                    'semestre_id' => $request->semestre_id,
                    'groupe_id' => $request->groupe_id,
                    'note_controle' => $noteControle,
                    'note_exam'     => $noteExam,
                    'moyenne'       => $moyenne,
                    'statut'        => $statut,
                ]
            );
        }

        return redirect()->back()->with('success', 'Notes de module enregistrées avec succès.');
    }

    /**
     * Export module notes to CSV.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\JsonResponse
     */
    public function exporterCsv(Request $request)
    {
        // Validate required filters
        $request->validate([
            'annee_universitaire_id' => 'required|integer|exists:annees_universitaires,id',
            'semestre_id'            => 'required|integer|exists:semestres,id',
            'module_id'              => 'required|integer|exists:modules,id',
            'groupe_id'              => 'required|integer|exists:groupes,id',
        ]);

        // Cast to int (defensive)
        $anneeId = (int) $request->input('annee_universitaire_id');
        $semestreId = (int) $request->input('semestre_id');
        $moduleId = (int) $request->input('module_id');
        $groupeId = (int) $request->input('groupe_id');

        // Fetch students of the selected group
        $etudiants = Etudiant::where('groupe_id', $groupeId)->get();

        // Fetch their notes for the selected period/module
        $notes = NoteModule::whereIn('etudiant_ppr', $etudiants->pluck('ppr'))
            ->where('annee_universitaire_id', $anneeId)
            ->where('semestre_id', $semestreId)
            ->where('module_id', $moduleId)
            ->get()
            ->keyBy('etudiant_ppr');

        // Debug: log raw notes values
        \Log::debug('CSV Export notes:', [
            'filters' => compact('anneeId', 'semestreId', 'moduleId', 'groupeId'),
            'count_etudiants' => $etudiants->count(),
            'count_notes' => $notes->count(),
            'notes' => $notes->map(function ($note) {
                return [
                    'ppr' => $note->etudiant_ppr,
                    'note_controle' => $note->note_controle,
                    'note_exam' => $note->note_exam,
                    'moyenne' => $note->moyenne,
                    'statut' => $note->statut,
                ];
            })->toArray(),
        ]);

        $filename = 'notes_module_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($etudiants, $notes) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM for Excel
            fputs($handle, "\xEF\xBB\xBF");
            // Header – semicolon separated
            fputcsv($handle, ['PPR', 'CIN', 'Nom complet', 'Note Contrôle', 'Note Examen', 'Moyenne', 'Statut'], ';');

            foreach ($etudiants as $etudiant) {
                $note = $notes[$etudiant->ppr] ?? null;

                // Ensure numeric values are formatted with two decimal places, using comma as decimal separator
                $noteControle = $note ? number_format((float) $note->note_controle, 2, ',', '') : '';
                $noteExam     = $note ? number_format((float) $note->note_exam,     2, ',', '') : '';
                $moyenne      = $note ? number_format((float) $note->moyenne,      2, ',', '') : '';
                $statut       = $note ? $note->statut : '';

                fputcsv($handle, [
                    $etudiant->ppr,
                    $etudiant->cin,
                    $etudiant->nom_prenom_francais,
                    $noteControle,
                    $noteExam,
                    $moyenne,
                    $statut,
                ], ';');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}