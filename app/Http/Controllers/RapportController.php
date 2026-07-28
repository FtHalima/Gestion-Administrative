<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\NoteModule;
use App\Models\NoteSemestre;
use Barryvdh\DomPDF\Facade\Pdf;

class RapportController extends Controller
{
    /**
     * Génère un PDF du relevé de notes d'un étudiant pour un semestre.
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

        $etudiant = Etudiant::findOrFail($request->etudiant_ppr);

        $notesModules = NoteModule::where('etudiant_ppr', $etudiant->ppr)
            ->where('semestre_id', $request->semestre_id)
            ->with('module')
            ->get();

        $noteSemestre = NoteSemestre::where('etudiant_ppr', $etudiant->ppr)
            ->where('semestre_id', $request->semestre_id)
            ->first();

        $semestre = \App\Models\Semestre::findOrFail($request->semestre_id);

        $pdf = Pdf::loadView('rapports.releve-notes', compact('etudiant', 'notesModules', 'noteSemestre', 'semestre'));

        return $pdf->stream('releve-notes-' . $etudiant->ppr . '.pdf');
    }
}