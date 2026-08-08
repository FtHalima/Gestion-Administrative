<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnneeUniversitaire;
use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\Semestre;
use Barryvdh\DomPDF\Facade\Pdf;

class RapportController extends Controller
{
    /**
     * Display a listing of the resource for reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('rapports.index');
    }

    /**
     * Show the form to select group and semester, then list students.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function releveNotesFormulaire(Request $request)
    {
        $annees = AnneeUniversitaire::withoutGlobalScopes()->get();
        $semestres = Semestre::all();
        $groupes = Groupe::all();

        $groupeId = $request->groupe_id;
        $semestreId = $request->semestre_id;

        $etudiants = collect();
        if ($groupeId) {
            $etudiants = Etudiant::where('groupe_id', $groupeId)->get();
        }

        return view('rapports.releve-notes-formulaire', compact('annees', 'semestres', 'groupes', 'etudiants', 'semestreId'));
    }

    /**
     * Generate a PDF transcript of grades for a student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function releveNotes(Request $request)
    {
        $request->validate([
            'etudiant_ppr' => ['required', 'exists:etudiant,ppr'],
            'semestre_id' => ['required', 'exists:semestres,id'],
        ]);

        $etudiant = Etudiant::where('ppr', $request->etudiant_ppr)->firstOrFail();

        $notesModules = \App\Models\NoteModule::where('etudiant_ppr', $etudiant->ppr)
            ->where('semestre_id', $request->semestre_id)
            ->with('module')
            ->get();

        $noteSemestre = \App\Models\NoteSemestre::where('etudiant_ppr', $etudiant->ppr)
            ->where('semestre_id', $request->semestre_id)
            ->first();

        $semestre = \App\Models\Semestre::findOrFail($request->semestre_id);

        $pdf = Pdf::loadView('rapports.releve-notes', compact('etudiant', 'notesModules', 'noteSemestre', 'semestre'))
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'fontDir' => base_path('vendor/dompdf/dompdf/lib/fonts'),
                'fontHeightRatio' => 1.1,
            ])
            ->setPaper('a4', 'portrait');

        return $pdf->stream('releve-notes-' . $etudiant->ppr . '.pdf');
    }
}