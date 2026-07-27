<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('etudiant', function (Blueprint $table) {
            $table->date('anciennete_grade')->nullable()->change();
            $table->date('anciennete_echelon')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiant', function (Blueprint $table) {
            $table->integer('anciennete_grade')->nullable()->change();
            $table->integer('anciennete_echelon')->nullable()->change();
        });
    }
};