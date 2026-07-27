<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes_memoires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_ppr')
                  ->constrained('etudiant', 'ppr')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('annee_universitaire_id')
                  ->constrained('annees_universitaires')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('groupe_id')
                  ->constrained('groupes')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->string('titre_memoire', 255);
            $table->foreignId('encadrant')
                  ->constrained('utilisateurs')
                  ->onDelete('restrict')
                  ->onUpdate('cascade')
                  ->comment('FK vers utilisateurs où role=enseignant');
            $table->decimal('note_soutenance', 4, 2)->nullable();
            $table->decimal('note_rapport', 4, 2)->nullable();
            $table->decimal('moyenne', 4, 2)->nullable()
                  ->comment('(soutenance*0.5 + rapport*0.5)');
            $table->timestamps();

            $table->unique(['etudiant_ppr', 'annee_universitaire_id']);

            $table->index('etudiant_ppr');
            $table->index('encadrant');
            $table->index('groupe_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes_memoires');
    }
};