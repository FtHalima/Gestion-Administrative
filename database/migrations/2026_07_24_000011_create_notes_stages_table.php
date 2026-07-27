<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes_stages', function (Blueprint $table) {
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
            $table->string('etablissement_accueil', 255)->nullable();
            $table->foreignId('tuteur_academique')
                  ->constrained('utilisateurs')
                  ->onDelete('restrict')
                  ->onUpdate('cascade')
                  ->comment('FK vers utilisateurs où role=enseignant');
            $table->decimal('note', 4, 2)->nullable()
                  ->comment('note de stage (sur 20)');
            $table->string('fichier_url', 500)->nullable()
                  ->comment('chemin local ou lien cloud (PDF, etc.)');
            $table->timestamps();

            $table->unique(['etudiant_ppr', 'annee_universitaire_id']);

            $table->index('etudiant_ppr');
            $table->index('semestre_id');
            $table->index('groupe_id');
            $table->index('tuteur_academique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes_stages');
    }
};