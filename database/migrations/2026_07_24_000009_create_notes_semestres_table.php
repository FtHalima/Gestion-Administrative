<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes_semestres', function (Blueprint $table) {
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
            $table->foreignId('groupe_id')
                  ->constrained('groupes')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->decimal('moyenne', 4, 2)->nullable()
                  ->comment('moyenne de toutes les notes_modules du semestre');
            $table->enum('statut', ['Validé', 'Racheter', 'Rattrapage'])
                  ->nullable()
                  ->comment('même logique que notes_modules');
            $table->timestamps();

            $table->unique(['etudiant_ppr', 'semestre_id', 'annee_universitaire_id'], 'unique_note_semestre');

            $table->index('etudiant_ppr');
            $table->index('semestre_id');
            $table->index('groupe_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes_semestres');
    }
};