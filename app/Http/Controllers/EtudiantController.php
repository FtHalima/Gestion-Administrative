<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\AnneeUniversitaire;
use App\Models\NoteExamen;
use App\Models\NoteModule;
use App\Models\NoteSemestre;
use App\Models\NoteMemoire;
use App\Models\NoteStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;
use SplFileObject;

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

        // Filter by année universitaire
        if ($request->filled('annee_id')) {
            $query->whereHas('groupe.anneeUniversitaire', function ($q) use ($request) {
                $q->where('annees_universitaires.id', $request->annee_id);
            });
        }

        // Search by nom_prenom_francais, matricule, cin, ppr
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom_prenom_francais', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%")
                    ->orWhere('cin', 'like', "%{$search}%")
                    ->orWhere('ppr', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->input('sort', 'nom_asc');
        switch ($sort) {
            case 'nom_asc':
                $query->orderBy('nom_prenom_francais', 'asc');
                break;
            case 'nom_desc':
                $query->orderBy('nom_prenom_francais', 'desc');
                break;
            case 'ppr_asc':
                $query->orderBy('ppr', 'asc');
                break;
            case 'ppr_desc':
                $query->orderBy('ppr', 'desc');
                break;
            default:
                $query->orderBy('nom_prenom_francais', 'asc');
        }

        $etudiants = $query->paginate(10)->appends($request->except('page'));

        $groupes = Groupe::all();
        $annees = AnneeUniversitaire::orderBy('nom')->get();

        return view('etudiants.index', compact('etudiants', 'groupes', 'annees', 'request', 'sort'));
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

    /**
     * Show the import form.
     */
    public function importForm()
    {
        return view('etudiants.import');
    }

    /**
     * Handle the imported CSV file.
     */
    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        if (! $request->file->isValid()) {
            return back()->with('error', 'Le fichier est invalide.');
        }

        $path = $request->file->getRealPath();
        $object = new SplFileObject($path);
        $object->setFlags(SplFileObject::READ_CSV);
        $object->setCsvControl(';'); // CSV semicolon-separated

        $headers = null;
        $created = 0;
        $lineNumber = 0;

        foreach ($object as $row) {
            $lineNumber++;

            // Ignore completely empty rows (all fields empty after trim)
            if (array_filter($row, fn($val) => trim($val) !== '') === []) {
                \Log::warning('Import CSV ligne '.$lineNumber.' REJETÉE : ligne entièrement vide');
                continue;
            }

            if (is_null($headers)) {
                // Remove UTF-8 BOM if present
                if (!empty($row[0]) && (substr($row[0], 0, 3) === "\xEF\xBB\xBF")) {
                    $row[0] = substr($row[0], 3);
                }
                $headers = $row;
                \Log::info('Import CSV headers reçus:', $headers ?? []);
                \Log::info('Header count: '.count($headers));
                continue;
            }

            \Log::info('Line '.$lineNumber.': Row count: '.count($row).' Headers count: '.count($headers));

            if (count($headers) !== count($row)) {
                \Log::warning('Import CSV ligne '.$lineNumber.' REJETÉE : nombre de colonnes mismatch - Headers: '.count($headers).' Values: '.count($row).' Row data: '.json_encode($row));
                continue;
            }

            $data = array_combine($headers, $row);
            if (!$data) {
                \Log::warning('Import CSV ligne '.$lineNumber.' REJETÉE : array_combine returned false');
                continue;
            }

            // Normalize keys (trim + lower)
            $data = array_map('trim', $data);
            $keys   = array_change_key_case(array_keys($data), CASE_LOWER);
            $data   = array_combine($keys, array_values($data));

            \Log::info('Import CSV ligne traitée:', $data ?? []);

            // Required fields
            if (empty($data['ppr']) || empty($data['nom_prenom_francais'])) {
                $missing = [];
                if (empty($data['ppr'])) $missing[] = 'ppr';
                if (empty($data['nom_prenom_francais'])) $missing[] = 'nom_prenom_francais';
                \Log::warning('Import CSV ligne '.$lineNumber.' REJETÉE : champ obligatoire '.implode(' ou ', $missing).' manquant');
                continue;
            }

            // Resolve groupe (either ID or name)
            $groupeId = null;
            if (!empty($data['groupe_id']) && is_numeric($data['groupe_id'])) {
                $groupeId = (int)$data['groupe_id'];
            } elseif (!empty($data['groupe'])) {
                $groupe = Groupe::where('nom_groupe', $data['groupe'])->first();
                $groupeId = $groupe ? $groupe->id : null;
            }

            // Optional: log if groupe not found but not required? We'll log as warning if groupe expected but not found and groupe column not empty.
            if (!empty($data['groupe']) && is_null($groupeId)) {
                \Log::warning('Import CSV ligne '.$lineNumber.' REJETÉE : groupe introuvable');
                continue;
            }

            $attributes = [
                'ppr'                 => $data['ppr'],
                'nom_prenom_francais' => $data['nom_prenom_francais'] ?? '',
                'nom_prenom_arabe'    => $data['nom_prenom_arabe'] ?? null,
                'genre'               => $data['genre'] ?? null,
                'date_naissance'      => $data['date_naissance'] ?? null,
                'lieu_naissance'      => $data['lieu_naissance'] ?? null,
                'adresse'             => $data['adresse'] ?? null,
                'telephone'           => $data['telephone'] ?? null,
                'email'               => $data['email'] ?? null,
                'baccalaureat'        => $data['baccalaureat'] ?? null,
                'direction_baccalaureat'=> $data['direction_baccalaureat'] ?? null,
                'annee_baccalaureat'  => $data['annee_baccalaureat'] ?? null,
                'licence'             => $data['licence'] ?? null,
                'annee_licence'       => $data['annee_licence'] ?? null,
                'universite_licence'  => $data['universite_licence'] ?? null,
                'faculte_licence'     => $data['faculte_licence'] ?? null,
                'autre_diplome'       => $data['autre_diplome'] ?? null,
                'specialite_diplome'  => $data['specialite_diplome'] ?? null,
                'annee_diplome'       => $data['annee_diplome'] ?? null,
                'universite_diplome'  => $data['universite_diplome'] ?? null,
                'faculte_diplome'     => $data['faculte_diplome'] ?? null,
                'centre'              => $data['centre'] ?? null,
                'ville_centre'        => $data['ville_centre'] ?? null,
                'annee_sortie'        => $data['annee_sortie'] ?? null,
                'date_recrutement'    => $data['date_recrutement'] ?? null,
                'cadre'               => $data['cadre'] ?? null,
                'grade'               => $data['grade'] ?? null,
                'anciennete_grade'    => $data['anciennete_grade'] ?? null,
                'echelon'             => $data['echelon'] ?? null,
                'anciennete_echelon'  => $data['anciennete_echelon'] ?? null,
                'dernier_etablissement'=> $data['dernier_etablissement'] ?? null,
                'matiere_ou_fonction' => $data['matiere_ou_fonction'] ?? null,
                'cycle'               => $data['cycle'] ?? null,
                'ville'               => $data['ville'] ?? null,
                'direction_provinciale'=> $data['direction_provinciale'] ?? null,
                'classe'              => $data['classe'] ?? null,
                'n_ordre'             => $data['n_ordre'] ?? null,
                'groupe_id'           => $groupeId,
            ];

            Etudiant::updateOrCreate(['ppr' => $attributes['ppr']], $attributes);
            $created++;
        }

        if ($created === 0) {
            return back()->with('error', 'Aucun étudiant valide n’a été trouvé dans le fichier.');
        }

        return redirect()->route('etudiants.index')
            ->with('success', "$created étudiant(s) importé(s) avec succès.");
    }

    /**
     * Export CSV of all students.
     */
    public function exportCsv(Request $request)
    {
        $etudiants = Etudiant::with('groupe')->get();

        $filename = 'etudiants_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        ];

        $callback = function () use ($etudiants) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM for Excel
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header (semicolon = French separator)
            fputcsv($handle, [
                'PPR',
                'Nom (FR)',
                'Nom (AR)',
                'Cin',
                'Matricule',
                'Genre',
                'Date Naissance',
                'Lieu Naissance',
                'Adresse',
                'Téléphone',
                'Email',
                'Baccalauréat',
                'Dir. Bac',
                'Année Bac',
                'Licence',
                'Année Lic.',
                'Univ. Lic.',
                'Fac. Lic.',
                'Autre dipl.',
                'Spéc. dipl.',
                'Année dipl.',
                'Univ. dipl.',
                'Fac. dipl.',
                'Centre',
                'Ville centre',
                'Année sortie',
                'Date recrut.',
                'Cadre',
                'Grade',
                'Anc. grade',
                'Échelon',
                'Anc. échelon',
                'Dernier établ.',
                'Matière/Fonction',
                'Cycle',
                'Ville',
                'Dir. prov.',
                'Classe',
                'N° ordre',
                'Groupe'
            ], ';');

            foreach ($etudiants as $et) {
                fputcsv($handle, [
                    $et->ppr,
                    $et->nom_prenom_francais,
                    $et->nom_prenom_arabe ?? '',
                    $et->cin ?? '',
                    $et->matricule ?? '',
                    $et->genre ?? '',
                    $et->date_naissance ? $et->date_naissance->format('Y-m-d') : '',
                    $et->lieu_naissance ?? '',
                    $et->adresse ?? '',
                    $et->telephone ?? '',
                    $et->email ?? '',
                    $et->baccalaureat ?? '',
                    $et->direction_baccalaureat ?? '',
                    $et->annee_baccalaureat ?? '',
                    $et->licence ?? '',
                    $et->annee_licence ?? '',
                    $et->universite_licence ?? '',
                    $et->faculte_licence ?? '',
                    $et->autre_diplome ?? '',
                    $et->specialite_diplome ?? '',
                    $et->annee_diplome ?? '',
                    $et->universite_diplome ?? '',
                    $et->faculte_diplome ?? '',
                    $et->centre ?? '',
                    $et->ville_centre ?? '',
                    $et->annee_sortie ?? '',
                    $et->date_recrutement ? $et->date_recrutement->format('Y-m-d') : '',
                    $et->cadre ?? '',
                    $et->grade ?? '',
                    $et->anciennete_grade ?? '',
                    $et->echelon ?? '',
                    $et->anciennete_echelon ?? '',
                    $et->dernier_etablissement ?? '',
                    $et->matiere_ou_fonction ?? '',
                    $et->cycle ?? '',
                    $et->ville ?? '',
                    $et->direction_provinciale ?? '',
                    $et->classe ?? '',
                    $et->n_ordre ?? '',
                    $et->groupe ? $et->groupe->nom_groupe : ''
                ], ';');
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}