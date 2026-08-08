<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnneeUniversitaire;
use App\Models\Groupe;
use App\Models\Etudiant;
use App\Models\NoteMemoire;
use App\Models\Utilisateur;
use Illuminate\Validation\Rule;

class NoteMemoireController extends Controller
{
    /**
     * Display the memory notes filter form.
     */
    public function index()
    {
        $annees = AnneeUniversitaire::withoutGlobalScopes()->get();
        $groupes = Groupe::all();

        return view('note_memoires.index', compact('annees', 'groupes'));
    }

    /**
     * Process the filter request and load existing memory notes.
     */
    public function filtrer(Request $request)
    {
        // Load lists for the filter selects (avoid undefined variable issue)
        $annees = AnneeUniversitaire::withoutGlobalScopes()->get();
        $groupes = Groupe::all();

        $validated = $request->validate([
            'annee_universitaire_id' => ['nullable', 'integer', Rule::exists('annees_universitaires', 'id')],
            'groupe_id' => ['nullable', 'integer', Rule::exists('groupes', 'id')],
        ]);

        $anneeId = $validated['annee_universitaire_id'];
        $groupeId = $validated['groupe_id'];

        $etudiants = collect();
        $notes = collect();

        // If groupe_id is missing, return empty results
        if (!$groupeId) {
            return view('note_memoires.index', compact(
                'annees', 'groupes',
                'etudiants', 'notes',
                'enseignants', collect(),
                'anneeId', 'groupeId'
            ));
        }

        // Fetch students of the selected group
        $etudiants = Etudiant::where('groupe_id', $groupeId)->get();

        // Fetch existing memory notes for these students and academic year
        if ($etudiants->isNotEmpty() && $anneeId) {
            $notes = NoteMemoire::whereIn('etudiant_ppr', $etudiants->pluck('ppr'))
                ->where('annee_universitaire_id', $anneeId)
                ->get()
                ->keyBy('etudiant_ppr');
        }

        // Load teachers for the encadrant select
        $enseignants = Utilisateur::where('role', 'enseignant')->get();

        return view('note_memoires.index', compact(
            'annees', 'groupes',
            'etudiants', 'notes',
            'enseignants',
            'anneeId', 'groupeId'
        ));
    }

    /**
     * Save submitted memory notes.
     */
    public function enregistrer(Request $request)
    {
        $validated = $request->validate([
            'annee_universitaire_id' => ['required', 'integer', Rule::exists('annees_universitaires', 'id')],
            'groupe_id' => ['required', 'integer', Rule::exists('groupes', 'id')],
            'titres' => ['required', 'array'],
            'titres.*' => ['nullable', 'string', 'max:255'],
            'encadrants' => ['required', 'array'],
            'encadrants.*' => ['nullable', 'integer'],
            'notes_soutenance' => ['required', 'array'],
            'notes_soutenance.*' => ['nullable', 'numeric', 'between:0,20'],
            'notes_rapport' => ['required', 'array'],
            'notes_rapport.*' => ['nullable', 'numeric', 'between:0,20'],
        ]);

        $anneeId = $validated['annee_universitaire_id'];
        $groupeId = $validated['groupe_id'];

        $titres = $request->input('titres', []);
        $encadrants = $request->input('encadrants', []);
        $notesSoutenance = $request->input('notes_soutenance', []);
        $notesRapport = $request->input('notes_rapport', []);

        foreach ($titres as $ppr => $titre) {
            // Process only if a title is provided (trimmed)
            if (trim($titre) === '') {
                continue;
            }

            $encadrant = $encadrants[$ppr] ?? null;
            $noteSoutenance = isset($notesSoutenance[$ppr]) ? $notesSoutenance[$ppr] : null;
            $noteRapport = isset($notesRapport[$ppr]) ? $notesRapport[$ppr] : null;

            // Calculate moyenne if both notes are present
            if ($noteSoutenance !== null && $noteRapport !== null) {
                $moyenne = ($noteSoutenance + $noteRapport) / 2;
            } else {
                $moyenne = null;
            }

            NoteMemoire::updateOrCreate(
                [
                    'etudiant_ppr' => $ppr,
                    'annee_universitaire_id' => $anneeId,
                ],
                [
                    'groupe_id' => $groupeId,
                    'titre_memoire' => $titre,
                    'encadrant' => $encadrant,
                    'note_soutenance' => $noteSoutenance,
                    'note_rapport' => $noteRapport,
                    'moyenne' => $moyenne,
                ]
            );
        }

        return redirect()->back()->with('success', 'Notes de mémoire enregistrées avec succès.');
    }
}