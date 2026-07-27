<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('mes-modules', [App\Http\Controllers\ModuleController::class, 'mesModules'])
        ->name('modules.mes-modules');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'role:administration'])->group(function () {
    Route::resource('utilisateurs', App\Http\Controllers\UtilisateurController::class);
    Route::post('utilisateurs/{utilisateur}/reset-password', [App\Http\Controllers\UtilisateurController::class, 'resetPassword'])
        ->name('utilisateurs.reset-password');
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
});