<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$controller = new App\Http\Controllers\RapportController();
// Use known etudiant and semestre from earlier test
$request = new Illuminate\Http\Request(['etudiant_ppr'=>89,'semestre_id'=>2], [], [], [], [], [], '');
$response = $controller->releveNotes($request);
echo 'Status: '.$response->getStatusCode().PHP_EOL;
$content = $response->getContent();
file_put_contents('storage/app/releve_test.pdf', $content);
echo 'PDF length: '.strlen($content).PHP_EOL;
?>