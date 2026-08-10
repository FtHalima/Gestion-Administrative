<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Groupe;
use App\Models\Module;
use App\Models\NoteExamen;
use App\Models\NoteModule;
use App\Models\NoteSemestre;
use App\Models\NoteMemoire;
use App\Models\NoteStage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Calculate statistics
        $stats = [
            'etudiants' => Etudiant::count(),
            'groupes' => Groupe::count(),
            'modules' => Module::count(),
            'notes_examen' => NoteExamen::count(),
            'notes_module' => NoteModule::count(),
            'notes_semestre' => NoteSemestre::count(),
            'notes_memoire' => NoteMemoire::count(),
            'notes_stage' => NoteStage::count(),
        ];

        // Total notes across all types
        $stats['notes_total'] = array_sum([
            $stats['notes_examen'],
            $stats['notes_module'],
            $stats['notes_semestre'],
            $stats['notes_memoire'],
            $stats['notes_stage'],
        ]);

        return view('dashboard', compact('stats'));
    }
}