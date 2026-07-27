<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiant', function (Blueprint $table) {
            $table->bigInteger('ppr')->unsigned()->primary()->comment('Numéro personnel permanent – clé primaire');
            $table->string('cin', 20)->nullable()->unique();
            $table->string('matricule', 50)->nullable()->unique();
            $table->foreignId('groupe_id')
                  ->constrained()
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->string('classe', 50)->nullable();
            $table->integer('n_ordre')->nullable();
            $table->string('nom_prenom_arabe', 100)->nullable();
            $table->string('nom_prenom_francais', 100)->nullable();
            $table->enum('genre', ['M', 'F'])->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance', 100)->nullable();
            $table->string('adresse', 255)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('baccalaureat', 50)->nullable();
            $table->string('direction_baccalaureat', 100)->nullable();
            $table->year('annee_baccalaureat')->nullable();
            $table->string('licence', 50)->nullable();
            $table->year('annee_licence')->nullable();
            $table->string('universite_licence', 150)->nullable();
            $table->string('faculte_licence', 150)->nullable();
            $table->string('autre_diplome', 50)->nullable();
            $table->string('specialite_diplome', 100)->nullable();
            $table->year('annee_diplome')->nullable();
            $table->string('universite_diplome', 150)->nullable();
            $table->string('faculte_diplome', 150)->nullable();
            $table->string('centre', 100)->nullable();
            $table->string('ville_centre', 100)->nullable();
            $table->year('annee_sortie')->nullable();
            $table->date('date_recrutement')->nullable();
            $table->string('cadre', 50)->nullable();
            $table->string('grade', 50)->nullable();
            $table->integer('anciennete_grade')->nullable();
            $table->string('echelon', 20)->nullable();
            $table->integer('anciennete_echelon')->nullable();
            $table->string('dernier_etablissement', 150)->nullable();
            $table->string('cycle', 50)->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('direction_provinciale', 100)->nullable();
            $table->string('matiere_ou_fonction', 100)->nullable();
            $table->string('photo', 255)->nullable();
            $table->timestamps();

            $table->index('groupe_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiant');
    }
};