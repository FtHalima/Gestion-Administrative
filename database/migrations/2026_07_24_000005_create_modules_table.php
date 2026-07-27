<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('code_module', 20)->unique();
            $table->string('nom_module', 150);
            $table->foreignId('semestre_id')
                  ->constrained()
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('professeur_id')
                  ->constrained('utilisateurs')
                  ->onDelete('restrict')
                  ->onUpdate('cascade')
                  ->comment('doit référencer un utilisateur avec role=enseignant');
            $table->index('semestre_id');
            $table->index('professeur_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};