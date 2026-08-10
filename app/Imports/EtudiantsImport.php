<?php

namespace App\Imports;

use App\Models\Etudiant;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class EtudiantsImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        \Log::info('Importing row data:', $row);

        return new Etudiant([
            'ppr' => $row['ppr'],
            'cin' => $row['cin'] ?? null,
            'matricule' => $row['matricule'] ?? null,
            'nom_prenom_francais' => $row['nom_prenom_francais'] ?? $row['nom_complet'] ?? null,
            'email' => $row['email'] ?? null,
            'groupe_id' => $row['groupe_id'] ?? null,
        ]);
    }
}