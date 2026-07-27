<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Semestre;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::with('semestre', 'professeur')->get();
        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $semestres = Semestre::all();
        $professeurs = Utilisateur::where('role', 'enseignant')->get();
        return view('modules.create', compact('semestres', 'professeurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_module' => ['required', 'string', 'max:255', 'unique:modules,code_module'],
            'nom_module' => ['required', 'string', 'max:255'],
            'semestre_id' => ['required', 'exists:semestres,id'],
            'professeur_id' => ['required', 'exists:utilisateurs,id'],
        ]);

        Module::create($validated);

        return Redirect::route('modules.index')
            ->with('success', 'Module créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        return view('modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        $semestres = Semestre::all();
        $professeurs = Utilisateur::where('role', 'enseignant')->get();
        return view('modules.edit', compact('module', 'semestres', 'professeurs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module)
    {
        $validated = $request->validate([
            'code_module' => ['required', 'string', 'max:255', 'unique:modules,code_module,' . $module->id],
            'nom_module' => ['required', 'string', 'max:255'],
            'semestre_id' => ['required', 'exists:semestres,id'],
            'professeur_id' => ['required', 'exists:utilisateurs,id'],
        ]);

        $module->update($validated);

        return Redirect::route('modules.index')
            ->with('success', 'Module mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        $hasNotesExamen = \App\Models\NoteExamen::where('module_id', $module->id)->exists();
        $hasNotesModule = \App\Models\NoteModule::where('module_id', $module->id)->exists();

        if ($hasNotesExamen || $hasNotesModule) {
            return Redirect::back()
                ->with('error', 'Impossible de supprimer ce module car il est lié à des notes (examen ou module).');
        }

        $module->delete();

        return Redirect::route('modules.index')
            ->with('success', 'Module supprimé avec succès.');
    }

    /**
     * Show modules assigned to the currently authenticated professor (read‑only).
     */
    public function mesModules()
    {
        $modules = Module::with('semestre')
            ->where('professeur_id', auth()->id())
            ->get();

        return view('modules.mes-modules', compact('modules'));
    }
}
