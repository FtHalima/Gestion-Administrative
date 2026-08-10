<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('mes-modules', [App\Http\Controllers\ModuleController::class, 'mesModules'])
        ->name('modules.mes-modules');
    Route::get('note-examens', [App\Http\Controllers\NoteExamenController::class, 'index'])->name('note-examens.index');
    Route::get('note-examens/filtrer', [App\Http\Controllers\NoteExamenController::class, 'filtrer'])->name('note-examens.filtrer');
    Route::post('note-examens/enregistrer', [App\Http\Controllers\NoteExamenController::class, 'enregistrer'])->name('note-examens.enregistrer');
    Route::get('note-modules', [App\Http\Controllers\NoteModuleController::class, 'index'])->name('note-modules.index');
    Route::get('note-modules/filtrer', [App\Http\Controllers\NoteModuleController::class, 'filtrer'])->name('note-modules.filtrer');
    Route::post('note-modules/enregistrer', [App\Http\Controllers\NoteModuleController::class, 'enregistrer'])->name('note-modules.enregistrer');
    Route::get('note-modules/exporter-csv', [App\Http\Controllers\NoteModuleController::class, 'exporterCsv'])->name('note-modules.exporterCsv');
    Route::get('note-semestres', [App\Http\Controllers\NoteSemestreController::class, 'index'])->name('note-semestres.index');
    Route::get('note-semestres/filtrer', [App\Http\Controllers\NoteSemestreController::class, 'filtrer'])->name('note-semestres.filtrer');
    Route::post('note-semestres/enregistrer', [App\Http\Controllers\NoteSemestreController::class, 'enregistrer'])->name('note-semestres.enregistrer');
    Route::get('note-memoires', [App\Http\Controllers\NoteMemoireController::class, 'index'])->name('note-memoires.index');
    Route::get('note-memoires/filtrer', [App\Http\Controllers\NoteMemoireController::class, 'filtrer'])->name('note-memoires.filtrer');
    Route::post('note-memoires/enregistrer', [App\Http\Controllers\NoteMemoireController::class, 'enregistrer'])->name('note-memoires.enregistrer');
    Route::get('note-stages', [App\Http\Controllers\NoteStageController::class, 'index'])->name('note-stages.index');
    Route::get('note-stages/filtrer', [App\Http\Controllers\NoteStageController::class, 'filtrer'])->name('note-stages.filtrer');
    Route::post('note-stages/enregistrer', [App\Http\Controllers\NoteStageController::class, 'enregistrer'])->name('note-stages.enregistrer');
    Route::get('rapports', [App\Http\Controllers\RapportController::class, 'index'])->name('rapports.index');
    Route::get('rapports/releve-notes-formulaire', [App\Http\Controllers\RapportController::class, 'releveNotesFormulaire'])->name('rapports.releve-notes-formulaire');
    Route::get('rapports/releve-notes', [App\Http\Controllers\RapportController::class, 'releveNotes'])->name('rapports.releve-notes');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:administration'])->group(function () {
    Route::resource('utilisateurs', App\Http\Controllers\UtilisateurController::class);
    Route::post('utilisateurs/{utilisateur}/reset-password', [App\Http\Controllers\UtilisateurController::class, 'resetPassword'])
        ->name('utilisateurs.reset-password');
    Route::get('parametres', [App\Http\Controllers\ParametreController::class, 'index'])->name('parametres.index');
    Route::resource('annees-universitaires', App\Http\Controllers\AnneeUniversitaireController::class)
        ->parameters(['annees-universitaires' => 'anneeUniversitaire']);
    Route::resource('semestres', App\Http\Controllers\SemestreController::class)
        ->parameters(['semestres' => 'semestre']);
    Route::resource('modules', App\Http\Controllers\ModuleController::class)
        ->parameters(['modules' => 'module']);
    Route::resource('groupes', App\Http\Controllers\GroupeController::class)
        ->parameters(['groupes' => 'groupe']);
    Route::resource('etudiants', App\Http\Controllers\EtudiantController::class)
        ->parameters(['etudiants' => 'etudiant']);
    Route::post('etudiants/importer', [App\Http\Controllers\EtudiantController::class, 'importStore'])->name('etudiants.importer');

    // Import / Export
    Route::get('etudiants/import', [App\Http\Controllers\EtudiantController::class, 'importForm'])
        ->name('etudiants.import');
    Route::post('etudiants/import', [App\Http\Controllers\EtudiantController::class, 'importStore'])
        ->name('etudiants.import.store');
    Route::get('etudiants/export/csv', [App\Http\Controllers\EtudiantController::class, 'exportCsv'])
        ->name('etudiants.export.csv');
});