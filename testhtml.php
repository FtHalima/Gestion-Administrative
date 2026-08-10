<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use Illuminate\Support\Facades\View;
$etudiant = App\Models\Etudiant::find(89);
$semestre = App\Models\Semestre::find(2);
$notesModules = App\Models\NoteModule::where('etudiant_ppr', $etudiant->ppr)
    ->where('semestre_id', $semestre->id)
    ->with('module')
    ->get();
$noteSemestre = null;
$html = View::make('rapports.releve-notes', compact('etudiant', 'notesModules', 'noteSemestre', 'semestre'))->render();
file_put_contents('storage/app/releve_test.html', $html);
echo "HTML length: ".strlen($html).PHP_EOL;
echo "Contains Arabic? ".(preg_match('/[\x{0600}-\x{06FF}]/u', $html) ? 'yes' : 'no').PHP_EOL;
?>