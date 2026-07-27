<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groupes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_groupe', 50);
            $table->foreignId('annee_universitaire_id')
                  ->constrained('annees_universitaires')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->unique(['nom_groupe', 'annee_universitaire_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groupes');
    }
};
