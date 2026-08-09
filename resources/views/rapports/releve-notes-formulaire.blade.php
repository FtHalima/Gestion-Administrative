<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Imprimer les rapports
        </h2>
        <p class="text-sm text-gray-500">
            Générer des relevés de notes pour les étudiants.
        </p>
    </slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="GET" action="{{ route('rapports.releve-notes-formulaire') }}" class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label for="semestre_id" class="block text-sm font-medium text-gray-700 mb-1">Semestre</label>
                                <select id="semestre_id" name="semestre_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Sélectionner un semestre --</option>
                                    @foreach($semestres as $semestre)
                                        <option value="{{ $semestre->id }}"
                                                {{ old('semestre_id', $semestreId ?? null) == $semestre->id ? 'selected' : '' }}>
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
                                        <option value="{{ $groupe->id }}"
                                                {{ old('groupe_id') == $groupe->id ? 'selected' : '' }}>
                                            {{ $groupe->nom_groupe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-8 md:mt-0 md:ml-4">
                                <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Rechercher
                                </button>
                            </div>
                        </div>
                    </form>

                    @if(isset($etudiants) && $etudiants->isNotEmpty())
                        <div class="mt-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PPR</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CIN</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom complet</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($etudiants as $etudiant)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->ppr }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->cin }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->nom_prenom_francais }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                @if(isset($semestreId))
                                                    <a href="{{ route('rapports.releve-notes', ['etudiant_ppr' => $etudiant->ppr, 'semestre_id' => $semestreId]) }}"
                                                       target="_blank"
                                                       class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                        📄 Relevé PDF
                                                    </a>
                                                @else
                                                    <span class="text-gray-500">Veuillez sélectionner un semestre</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @if(request()->has('semestre_id') || request()->has('groupe_id'))
                            <p class="mt-6 text-center text-gray-600">
                                Aucun étudiant trouvé pour les critères sélectionnés.
                            </p>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>