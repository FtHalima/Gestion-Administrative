<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Relevé de notes</title>
    <style>
        body {
            font-family: "DejaVu Sans", "Arial Unicode MS", "Amiri", sans-serif;
            font-size: 12pt;
            margin: 20px;
            color: #000;
        }
        .rtl {
            direction: rtl;
            unicode-bidi: bidi-override;
            text-align: right;
        }
        h1, h2 {
            text-align: center;
            margin: 0;
        }
        .header-title {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .header-subtitle {
            font-size: 12pt;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            border: 1px solid #ccc;
            padding: 6px;
        }
        .info-table th {
            border: 1px solid #ccc;
            padding: 6px;
            background-color: #f0f0f0;
        }
        .notes-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        .notes-table th, .notes-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        .notes-table th {
            background-color: #f0f0f0;
        }
        .notes-table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10pt;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="rtl">
        <div class="header">
            <h1 class="header-title">RELEVÉ DE NOTES</h1>
            <div class="header-subtitle">Semestre : {{ $semestre->nom }}</div>
        </div>

        <div class="student-info">
            <table class="info-table">
                <tr>
                    <th>Nom complet</th>
                    <td>{{ $etudiant->nom_prenom_francais }}</td>
                </tr>
                <tr>
                    <th>PPR</th>
                    <td>{{ $etudiant->ppr }}</td>
                </tr>
                <tr>
                    <th>CIN</th>
                    <td>{{ $etudiant->cin }}</td>
                </tr>
                <tr>
                    <th>Matricule</th>
                    <td>{{ $etudiant->matricule }}</td>
                </tr>
            </table>
        </div>

        <div class="notes-section">
            @if($notesModules->isNotEmpty())
                <table class="notes-table">
                    <thead>
                        <tr>
                            <th>Code Module</th>
                            <th>Nom du Module</th>
                            <th>Note Contrôle</th>
                            <th>Note Examen</th>
                            <th>Moyenne</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notesModules as $note)
                            <tr>
                                <td>{{ $note->module->code_module }}</td>
                                <td style="direction:rtl; unicode-bidi:bidi-override;">{{ $note->module->nom_module }}</td>
                                <td>{{ number_format($note->note_controle, 2) }}</td>
                                <td>{{ number_format($note->note_exam, 2) }}</td>
                                <td>{{ number_format($note->moyenne, 2) }}</td>
                                <td>{{ $note->statut }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">Aucune note enregistrée pour cet étudiant ce semestre.</p>
            @endif
        </div>

        <div class="footer">
            Document généré le {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
<body>
    <div class="header">
        <h1 class="header-title">RELEVÉ DE NOTES</h1>
        <div class="header-subtitle">Semestre : {{ $semestre->nom }}</div>
    </div>

    <div class="student-info">
        <table class="info-table">
            <tr>
                <th>Nom complet</th>
                <td>{{ $etudiant->nom_prenom_francais }}</td>
            </tr>
            <tr>
                <th>PPR</th>
                <td>{{ $etudiant->ppr }}</td>
            </tr>
            <tr>
                <th>CIN</th>
                <td>{{ $etudiant->cin }}</td>
            </tr>
            <tr>
                <th>Matricule</th>
                <td>{{ $etudiant->matricule }}</td>
            </tr>
        </table>
    </div>

    <div class="notes-section">
        @if($notesModules->isNotEmpty())
            <table class="notes-table">
                <thead>
                    <tr>
                        <th>Code Module</th>
                        <th>Nom du Module</th>
                        <th>Note Contrôle</th>
                        <th>Note Examen</th>
                        <th>Moyenne</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notesModules as $note)
                        <tr>
                            <td>{{ $note->module->code_module }}</td>
                            <td style="direction:rtl; unicode-bidi:bidi-override;">{{ $note->module->nom_module }}</td>
                            <td>{{ number_format($note->note_controle, 2) }}</td>
                            <td>{{ number_format($note->note_exam, 2) }}</td>
                            <td>{{ number_format($note->moyenne, 2) }}</td>
                            <td>{{ $note->statut }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">Aucune note enregistrée pour cet étudiant ce semestre.</p>
        @endif
    </div>

    <div class="footer">
        Document généré le {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>