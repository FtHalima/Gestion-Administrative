<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notes de stage
        </h2>
    </slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded-md">
                            <ul class="list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="GET" action="{{ route('note-stages.filtrer') }}" class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div>
                                <label for="annee_universitaire_id" class="block text-sm font-medium text-gray-700 mb-1">Année universitaire</label>
                                <select id="annee_universitaire_id" name="annee_universitaire_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Sélectionner une année --</option>
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->id }}" {{ request('annee_universitaire_id') == $annee->id ? 'selected' : '' }}>
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
                                        <option value="{{ $semestre->id }}" {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>
                                            {{ $semestre->nom }}
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
                                        <option value="{{ $groupe->id }}" {{ request('groupe_id') == $groupe->id ? 'selected' : '' }}>
                                            {{ $groupe->nom_groupe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-8 md:mt-0 md:ml-4">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Filtrer
                            </button>
                        </div>
                    </form>

                    @if(isset($etudiants) && $etudiants->isNotEmpty())
                        <form method="POST" action="{{ route('note-stages.enregistrer') }}" class="mt-6" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="annee_universitaire_id" value="{{ request('annee_universitaire_id') }}">
                            <input type="hidden" name="semestre_id" value="{{ request('semestre_id') }}">
                            <input type="hidden" name="groupe_id" value="{{ request('groupe_id') }}">

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PPR</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CIN</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom complet</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Établissement d'accueil</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tuteur académique</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note (sur 20)</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fichier</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($etudiants as $etudiant)
                                            @php $note = $notes[$etudiant->ppr] ?? null; @endphp
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->ppr }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->cin }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->nom_prenom_francais }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="text" name="etablissements[{{ $etudiant->ppr }}]"
                                                           value="{{ $note ? $note->etablissement_accueil : '' }}"
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <select name="tuteurs[{{ $etudiant->ppr }}]"
                                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm">
                                                        <option value="">-- Sélectionner un tuteur --</option>
                                                        @foreach($enseignants as $ens)
                                                            <option value="{{ $ens->id }}"
                                                                    {{ $note && $note->tuteur_academique == $ens->id ? 'selected' : '' }}>
                                                                {{ $ens->nom . ' ' . $ens->prenom }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" name="notes[{{ $etudiant->ppr }}]"
                                                           min="0" max="20" step="0.25"
                                                           value="{{ $note ? $note->note : '' }}"
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 sm:text-sm">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if(isset($note) && $note->fichier_url)
                                                        <a href="{{ Storage::url($note->fichier_url) }}" target="_blank" class="text-indigo-600 text-xs block mb-1">
                                                            📎 Fichier actuel
                                                        </a>
                                                    @endif
                                                    <input type="file" name="fichiers[{{ $etudiant->ppr }}]"
                                                           accept=".pdf,.doc,.docx"
                                                           class="block w-full text-sm text-gray-700">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Enregistrer les notes de stage
                                </button>
                            </div>
                        </form>
                    @else
                        <p class="mt-6 text-center text-gray-600">
                            Aucun étudiant trouvé, veuillez sélectionner un semestre et un groupe.
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>