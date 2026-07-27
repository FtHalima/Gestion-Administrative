<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Saisie des notes de module
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

                    <form method="GET" action="{{ route('note-modules.filtrer') }}" class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
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
                                <label for="semestre_id" class="block text-sm font-medium text-gray-700 mb-1">Semestre</label>
                                <select id="semestre_id" name="semestre_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Sélectionner un semestre --</option>
                                    @foreach($semestres as $semestre)
                                        <option value="{{ $semestre->id }}"
                                                {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>
                                            {{ $semestre->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="module_id" class="block text-sm font-medium text-gray-700 mb-1">Module</label>
                                <select id="module_id" name="module_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Sélectionner un module --</option>
                                    @foreach($modules as $module)
                                        <option value="{{ $module->id }}"
                                                {{ request('module_id') == $module->id ? 'selected' : '' }}>
                                            {{ $module->nom_module }}
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

                    @if(isset($etudiants) && $etudiants->isNotEmpty())
                        @php
                            $etudiants = $etudiants ?? collect();
                        @endphp
                        <form method="POST" action="{{ route('note-modules.enregistrer') }}">
                            @csrf
                            <input type="hidden" name="annee_universitaire_id" value="{{ request('annee_universitaire_id') }}">
                            <input type="hidden" name="semestre_id" value="{{ request('semestre_id') }}">
                            <input type="hidden" name="module_id" value="{{ request('module_id') }}">
                            <input type="hidden" name="groupe_id" value="{{ request('groupe_id') }}">

                            <div class="mt-6 overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PPR</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CIN</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom complet</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note Contrôle (sur 20)</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note Examen (sur 20)</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Moyenne</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($etudiants as $etudiant)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->ppr }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->cin }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->nom_prenom_francais }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" name="notes_controle[{{ $etudiant->ppr }}]" min="0" max="20" step="0.25"
                                                           data-ppr="{{ $etudiant->ppr }}"
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm note-controle"
                                                           value="{{ isset($notes[$etudiant->ppr]) ? $notes[$etudiant->ppr]->note_controle : '' }}">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" name="notes_exam[{{ $etudiant->ppr }}]" min="0" max="20" step="0.25"
                                                           data-ppr="{{ $etudiant->ppr }}"
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm note-exam"
                                                           value="{{ isset($notes[$etudiant->ppr]) ? $notes[$etudiant->ppr]->note_exam : '' }}">
                                                </td>
                                                <td>
                                                    <span id="moyenne-{{ $etudiant->ppr }}">
                                                        {{ isset($notes[$etudiant->ppr]) && !is_null($notes[$etudiant->ppr]->moyenne) ? number_format($notes[$etudiant->ppr]->moyenne, 2) : '-' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span id="statut-{{ $etudiant->ppr }}">
                                                        {{ isset($notes[$etudiant->ppr]) && !is_null($notes[$etudiant->ppr]->statut) ? $notes[$etudiant->ppr]->statut : '-' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Enregistrer les notes
                                </button>
                            </div>
                        </form>
                    @else
                        <p class="mt-6 text-center text-gray-600">
                            Aucun étudiant trouvé, veuillez sélectionner un groupe.
                        </p>
                    @endif

                </div>
                <script>
                    document.querySelectorAll('.note-controle, .note-exam').forEach(function(input) {
                        input.addEventListener('input', function() {
                            const ppr = this.closest('tr').querySelector('.note-controle').dataset.ppr;
                            const controle = parseFloat(document.querySelector(".note-controle[data-ppr='" + ppr + "']").value);
                            const exam = parseFloat(document.querySelector(".note-exam[data-ppr='" + ppr + "']").value);

                            const moyenneSpan = document.getElementById('moyenne-' + ppr);
                            const statutSpan = document.getElementById('statut-' + ppr);

                            if (!isNaN(controle) && !isNaN(exam)) {
                                const moyenne = (controle * 0.25) + (exam * 0.75);
                                moyenneSpan.textContent = moyenne.toFixed(2);

                                if (moyenne > 10) {
                                    statutSpan.textContent = 'Validé';
                                } else if (moyenne == 10) {
                                    statutSpan.textContent = 'Racheter';
                                } else {
                                    statutSpan.textContent = 'Rattrapage';
                                }
                            } else {
                                moyenneSpan.textContent = '-';
                                statutSpan.textContent = '-';
                            }
                        });
                    });
                </script>

                <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.note-controle').forEach(function(input) {
            input.dispatchEvent(new Event('input'));
        });
    });
</script>
            </div>
        </div>
    </div>
</x-app-layout>