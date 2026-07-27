<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class UtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        Utilisateur::updateOrCreate(
            ['email' => 'admin@gestac.test'],
            [
                'nom' => 'Admin',
                'prenom' => 'Test',
                'mot_de_passe' => Hash::make('password'),
                'role' => 'administration',
                'statut' => 'actif',
                'telephone' => '0600000000',
            ]
        );

        // Enseignant user for testing permissions
        Utilisateur::updateOrCreate(
            ['email' => 'enseignant@test.com'],
            [
                'nom' => 'Enseignant',
                'prenom' => 'Test',
                'mot_de_passe' => Hash::make('password'),
                'role' => 'enseignant',
                'statut' => 'actif',
                'telephone' => '0600000000',
            ]
        );
    }
}