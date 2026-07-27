<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semestres', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 20)->comment('exemple: S1, S2');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->foreignId('annee_universitaire_id')
                  ->constrained('annees_universitaires')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->unique(['nom', 'annee_universitaire_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semestres');
    }
};