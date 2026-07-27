<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AnneeUniversitaire;
$annee = AnneeUniversitaire::firstOrCreate([
    'nom' => '2025-2026',
    'date_debut' => '2025-09-01',
    'date_fin' => '2026-06-30',
    'statut' => 'actif'
]);
echo "Annee ID: {$annee->id}\n";

use App\Models\Groupe;
$groupe = Groupe::firstOrCreate([
    'nom_groupe' => 'G1',
    'annee_universitaire_id' => $annee->id
]);
echo "Groupe ID: {$groupe->id}\n";

use App\Models\Etudiant;
$etudiant = Etudiant::firstOrCreate([
    'ppr' => 123456,
    'cin' => '12345678',
    'matricule' => 'MAT123',
    'groupe_id' => $groupe->id,
    'nom_prenom_francais' => 'Jean Dupont'
]);
echo "Etudiant PPR: {$etudiant->ppr}\n";
echo "Groupe via relation: {$etudiant->groupe->nom_groupe}\n";

use App\Models\Utilisateur;
$prof = Utilisateur::firstOrCreate([
    'email' => 'prof@example.com',
    'role' => 'professeur',
    'nom' => 'Prof',
    'prenom' => 'Test',
    'mot_de_passe' => 'secret',
    'statut' => 'actif'
]);
echo "Prof ID: {$prof->id}\n";

use App\Models\Semestre;
$semestre = Semestre::firstOrCreate([
    'nom' => 'S1',
    'date_debut' => '2025-09-01',
    'date_fin' => '2026-01-31',
    'annee_universitaire_id' => $annee->id
]);
echo "Semestre ID: {$semestre->id}\n";

use App\Models\Module;
$module = Module::firstOrCreate([
    'code_module' => 'MATH101',
    'nom_module' => 'Mathematiques',
    'semestre_id' => $semestre->id,
    'professeur_id' => $prof->id
]);
echo "Module ID: {$module->id}\n";

use App\Models\NoteModule;
$note = NoteModule::create([
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
echo "NoteModule ID: {$note->id}\n";
echo "Related Etudiant PPR: ".$note->etudiant->ppr."\n";

$note->delete();
$etudiant->delete();
// optionally clean others
echo "Test data cleaned up.\n";
?>