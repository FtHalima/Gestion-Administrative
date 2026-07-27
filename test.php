<?php
require __DIR__.'/bootstrap/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AnneeUniversitaire;
use App\Models\Groupe;
use App\Models\Utilisateur;
use App\Models\Semestre;
use App\Models\Module;
use App\Models\Etudiant;
use App\Models\NoteModule;

// create annee if not exists
$annee = AnneeUniversitaire::firstOrCreate([
    'nom' => '2025-2026',
    'date_debut' => '2025-09-01',
    'date_fin' => '2026-06-30',
    'statut' => 'actif'
]);
echo "Annee ID: {$annee->id}\n";

// create groupe if not exists
$groupe = Groupe::firstOrCreate([
    'nom_groupe' => 'G1',
    'annee_universitaire_id' => $annee->id
]);
echo "Groupe ID: {$groupe->id}\n";

// create professeur user
$prof = Utilisateur::firstOrCreate([
    'email' => 'prof@example.com',
    'role' => 'professeur',
    'nom' => 'Prof',
    'prenom' => 'Test',
    'mot_de_passe' => 'secret',
    'statut' => 'actif'
]);
echo "Prof ID: {$prof->id}\n";

// create semestre
$semestre = Semestre::firstOrCreate([
    'nom' => 'S1',
    'date_debut' => '2025-09-01',
    'date_fin' => '2026-01-31',
    'annee_universitaire_id' => $annee->id
]);
echo "Semestre ID: {$semestre->id}\n";

// create module
$module = Module::firstOrCreate([
    'code_module' => 'MATH101',
    'nom_module' => 'Mathematiques',
    'semestre_id' => $semestre->id,
    'professeur_id' => $prof->id
]);
echo "Module ID: {$module->id}\n";

// create etudiant
$etudiant = Etudiant::firstOrCreate([
    'ppr' => 123456,
    'cin' => '12345678',
    'matricule' => 'MAT123',
    'groupe_id' => $groupe->id,
    'nom_prenom_francais' => 'Jean Dupont'
]);
echo "Etudiant PPR: {$etudiant->ppr}\n";

// create noteModule
$noteModule = NoteModule::create([
    'etudiant_ppr' => $etudiant->ppr,
    'annee_universitaire_id' => $annee->id,
    'semestre_id' => $semestre->id,
    'module_id' => $module->id,
    'groupe_id' => $groupe->id,
    'note_controle' => 12.50,
    'note_exam' => 14.00,
    'moyenne' => 13.63,
    'statut' => 'Validé'
]);
echo "NoteModule ID: {$noteModule->id}\n";
echo "Related Etudiant PPR: ".$noteModule->etudiant->ppr."\n";

// cleanup
$noteModule->delete();
$etudiant->delete();
// optionally delete others if we want clean state
// $groupe->delete();
// $annee->delete();
echo "Test data cleaned up.\n";
