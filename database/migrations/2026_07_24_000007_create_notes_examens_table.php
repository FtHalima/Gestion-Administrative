<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes_examens', function (Blueprint $table) {
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
            $table->enum('type_exam', ['CC', 'Examen']);
            $table->decimal('note', 4, 2)->comment('sur 20');
            $table->timestamps();

            $table->unique(['etudiant_ppr', 'module_id', 'annee_universitaire_id', 'type_exam'], 'unique_note_examen');

            $table->index('etudiant_ppr');
            $table->index('module_id');
            $table->index('semestre_id');
            $table->index('groupe_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes_examens');
    }
};