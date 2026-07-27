<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_ppr')
                  ->constrained('etudiant', 'ppr')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('annee_universitaire_id')
                  ->constrained('annees_universitaires')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('semestre_id')
                  ->constrained('semestres')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('module_id')
                  ->constrained('modules')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('groupe_id')
                  ->constrained('groupes')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->decimal('note_controle', 4, 2)->nullable()
                  ->comment('note de contrôle continu');
            $table->decimal('note_exam', 4, 2)->nullable()
                  ->comment('note d’examen final');
            $table->decimal('moyenne', 4, 2)->nullable()
                  ->comment('moyenne pondérée (0.25*controle + 0.75*examen)');
            $table->enum('statut', ['Validé', 'Racheter', 'Rattrapage'])
                  ->nullable()
                  ->comment('calculé en PHP : >10 Validé, =10 Racheter, <10 Rattrapage');
            $table->timestamps();

            $table->unique(['etudiant_ppr', 'module_id', 'annee_universitaire_id'], 'unique_note_module');

            $table->index('etudiant_ppr');
            $table->index('module_id');
            $table->index('semestre_id');
            $table->index('groupe_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes_modules');
    }
};