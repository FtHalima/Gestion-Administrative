<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnneeUniversitaire;
use App\Models\Semestre;
use App\Models\Groupe;
use App\Models\Etudiant;
use App\Models\NoteStage;
use App\Models\Utilisateur;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class NoteStageController extends Controller
{
    /**
     * Display the stage notes filter form.
     */
    public function index()
    {
        $annees = AnneeUniversitaire::all();
        $semestres = Semestre::all();
        $groupes = Groupe::all();

        return view('note_stages.index', compact('annees', 'semestres', 'groupes'));
    }

    /**
     * Process the filter request and load existing stage notes.
     */
    public function filtrer(Request $request)
    {
        $annees = AnneeUniversitaire::all();
        $semestres = Semestre::all();
        $groupes = Groupe::all();

        $validated = $request->validate([
            'annee_universitaire_id' => ['nullable', 'integer', Rule::exists('annees_universitaires', 'id')],
            'semestre_id'            => ['nullable', 'integer', Rule::exists('semestres', 'id')],
            'groupe_id'              => ['nullable', 'integer', Rule::exists('groupes', 'id')],
        ]);

        $anneeId = $validated['annee_universitaire_id'];
        $semestreId = $validated['semestre_id'];
        $groupeId = $validated['groupe_id'];

        $etudiants = collect();
        $notes = collect();

        // If groupe_id is missing, return empty results
        if (!$groupeId) {
            $etudiants = collect();
            $notes = collect();
            $enseignants = collect();
            return view('note_stages.index', compact(
                'annees', 'semestres', 'groupes',
                'etudiants', 'notes', 'enseignants',
                'anneeId', 'semestreId', 'groupeId'
            ));
        }

        // Fetch students of the selected group
        $etudiants = Etudiant::where('groupe_id', $groupeId)->get();

        // Fetch existing stage notes for these students, academic year and semester
        if ($etudiants->isNotEmpty() && $anneeId && $semestreId) {
            $notes = NoteStage::whereIn('etudiant_ppr', $etudiants->pluck('ppr'))
                ->where('annee_universitaire_id', $anneeId)
                ->where('semestre_id', $semestreId)
                ->get()
                ->keyBy('etudiant_ppr');
        }

        // Load teachers for the tuteur_academique select
        $enseignants = Utilisateur::where('role', 'enseignant')->get();

        return view('note_stages.index', compact(
            'annees', 'semestres', 'groupes',
            'etudiants', 'notes',
            'enseignants',
            'anneeId', 'semestreId', 'groupeId'
        ));
    }

    /**
     * Save submitted stage notes.
     */
    public function enregistrer(Request $request)
    {
        $validated = $request->validate([
            'annee_universitaire_id' => ['required', 'integer', Rule::exists('annees_universitaires', 'id')],
            'semestre_id'            => ['required', 'integer', Rule::exists('semestres', 'id')],
            'groupe_id'              => ['required', 'integer', Rule::exists('groupes', 'id')],
            'etablissements'         => ['required', 'array'],
            'etablissements.*'       => ['nullable', 'string', 'max:255'],
            'tuteurs'                => ['required', 'array'],
            'tuteurs.*'              => ['nullable', 'integer'],
            'notes'                  => ['required', 'array'],
            'notes.*'                => ['nullable', 'numeric', 'between:0,20'],
            'fichiers'               => ['required', 'array'],
            'fichiers.*'             => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $anneeId = $validated['annee_universitaire_id'];
        $semestreId = $validated['semestre_id'];
        $groupeId = $validated['groupe_id'];

        $etablissements = $request->input('etablissements', []);
        $tuteurs = $request->input('tuteurs', []);
        $notesInput = $request->input('notes', []);
        $fichiers = $request->input('fichiers', []); // Not used directly; handled via hasFile

        foreach ($etablissements as $ppr => $etablissement) {
            // Process only if at least one field is filled
            if (trim($etablissement) === '' &&
                (!isset($tuteurs[$ppr]) || $tuteurs[$ppr] === null) &&
                (!isset($notesInput[$ppr]) || $notesInput[$ppr] === '' && $notesInput[$ppr] !== '0') &&
                (!$request->hasFile("fichiers.$ppr"))) {
                continue;
            }

            $tuteur = $tuteurs[$ppr] ?? null;
            $note = isset($notesInput[$ppr]) ? $notesInput[$ppr] : null;

            $fichierPath = null;
            if ($request->hasFile("fichiers.$ppr")) {
                $fichierPath = $request->file("fichiers.$ppr")->store('stages', 'public');
            } else {
                // Keep existing file if no new upload
                $existing = NoteStage::where('etudiant_ppr', $ppr)
                    ->where('annee_universitaire_id', $anneeId)
                    ->where('semestre_id', $semestreId)
                    ->first();
                $fichierPath = $existing->fichier_url ?? null;
            }

            NoteStage::updateOrCreate(
                [
                    'etudiant_ppr' => $ppr,
                    'annee_universitaire_id' => $anneeId,
                    'semestre_id' => $semestreId,
                ],
                [
                    'groupe_id' => $groupeId,
                    'etablissement_accueil' => $etablissement,
                    'tuteur_academique' => $tuteur,
                    'note' => $note,
                    'fichier_url' => $fichierPath,
                ]
            );
        }

        return redirect()->back()->with('success', 'Notes de stage enregistrées avec succès.');
    }
}