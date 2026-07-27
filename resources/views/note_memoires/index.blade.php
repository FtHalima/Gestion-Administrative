<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notes de mémoire
        </h2>
    </slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Formulaire de filtre -->
                    <form method="GET" action="{{ route('note-memoires.filtrer') }}" class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">
                            <div>
                                <label for="annee_universitaire_id" class="block text-sm font-medium text-gray-700 mb-1">Année universitaire</label>
                                <select id="annee_universitaire_id" name="annee_universitaire_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Sélectionner une année --</option>
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->id }}"
                                                {{ request('annee_universitaire_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="groupe_id" class="block text-sm font-medium text-gray-700 mb-1">Groupe</label>
                                <select id="groupe_id" name="groupe_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Sélectionner un groupe --</option>
                                    @foreach($groupes as $groupe)
                                        <option value="{{ $groupe->id }}"
                                                {{ request('groupe_id') == $groupe->id ? 'selected' : '' }}>
                                            {{ $groupe->nom_groupe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-8 md:mt-0 md:ml-4">
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Filtrer
                            </button>
                        </div>
                    </form>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded-md">
                            <ul class="list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(isset($etudiants) && $etudiants->isNotEmpty())
                        @php
                            $etudiants = $etudiants ?? collect();
                        @endphp
                        <!-- Formulaire de saisie -->
                        <form method="POST" action="{{ route('note-memoires.enregistrer') }}" class="mt-6">
                            @csrf
                            <input type="hidden" name="annee_universitaire_id" value="{{ request('annee_universitaire_id') }}">
                            <input type="hidden" name="groupe_id" value="{{ request('groupe_id') }}">

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PPR</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CIN</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom complet</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre du mémoire</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Encadrant</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note Soutenance (50%)</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note Rapport (50%)</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Moyenne</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($etudiants as $etudiant)
                                            @php
                                                $note = $notes[$etudiant->ppr] ?? null;
                                            @endphp
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->ppr }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->cin }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->nom_prenom_francais }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="text" name="titres[{{ $etudiant->ppr }}]"
                                                           value="{{ $note ? $note->titre_memoire : '' }}"
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <select name="encadrants[{{ $etudiant->ppr }}]"
                                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm">
                                                        <option value="">-- Sélectionner un encadrant --</option>
                                                        @foreach($enseignants as $ens)
                                                            <option value="{{ $ens->id }}"
                                                                    {{ $note && $note->encadrant == $ens->id ? 'selected' : '' }}>
                                                                {{ $ens->nom . ' ' . $ens->prenom }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" name="notes_soutenance[{{ $etudiant->ppr }}]"
                                                           min="0" max="20" step="0.25"
                                                           value="{{ $note ? $note->note_soutenance : '' }}"
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm soutenance-input"
                                                           data-ppr="{{ $etudiant->ppr }}">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" name="notes_rapport[{{ $etudiant->ppr }}]"
                                                           min="0" max="20" step="0.25"
                                                           value="{{ $note ? $note->note_rapport : '' }}"
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm rapport-input"
                                                           data-ppr="{{ $etudiant->ppr }}">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 moyenne-cell"
                                                    data-ppr="{{ $etudiant->ppr }}">
                                                    @php
                                                        $soutenance = $note ? $note->note_soutenance : null;
                                                        $rapport    = $note ? $note->note_rapport : null;
                                                        $moyenne    = null;
                                                        if ($soutenance !== null && $rapport !== null) {
                                                            $moyenne = ($soutenance + $rapport) / 2;
                                                        }
                                                    @endphp
                                                    {{ $moyenne !== null ? number_format($moyenne, 2) : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Enregistrer les notes de mémoire
                                </button>
                            </div>
                        </form>
                    @else
                        <p class="mt-6 text-center text-gray-600">
                            Aucun étudiant trouvé, veuillez sélectionner une année universitaire et un groupe.
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to compute moyenne for a given ppr
            function computeMoyenne(ppr) {
                const soutenanceInput = document.querySelector(`.soutenance-input[data-ppr="${ppr}"]`);
                const rapportInput = document.querySelector(`.rapport-input[data-ppr="${ppr}"]`);
                const moyenneCell = document.querySelector(`.moyenne-cell[data-ppr="${ppr}"]`);

                const soutenance = parseFloat(soutenanceInput.value);
                const rapport = parseFloat(rapportInput.value);

                if (!isNaN(soutenance) && !isNaN(rapport)) {
                    const moyenne = (soutenance + rapport) / 2;
                    moyenneCell.textContent = moyenne.toFixed(2);
                } else {
                    moyenneCell.textContent = '-';
                }
            }

            // Attach input events to all soutien and rapport inputs
            document.querySelectorAll('.soutenance-input, .rapport-input').forEach(function(input) {
                input.addEventListener('input', function() {
                    const ppr = this.dataset.ppr;
                    computeMoyenne(ppr);
                });
            });

            // Run initial calculation for existing values
            document.querySelectorAll('.soutenance-input').forEach(function(input) {
                const ppr = input.dataset.ppr;
                computeMoyenne(ppr);
            });
        });
    </script>
</x-app-layout>