<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Notes de semestre
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

                    <form method="GET" action="{{ route('note-semestres.filtrer') }}" class="space-y-4">
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
                                    <option value="">-- Sélectionner un semestre -- Sélectionner un semestre --</option>
                                    @foreach($semestres as $semestre)
                                        <option value="{{ $semestre->id }}"
                                                {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>
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
                        <div class="mt-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PPR</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CIN</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom complet</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de modules notés</th>
                                        <th scope="col" class="left text-xs font-medium text-gray-500 uppercase tracking-wider">Moyenne</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($etudiants as $etudiant)
                                        @php
                                            $resultat = $resultats[$etudiant->ppr] ?? [];
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->ppr }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->cin }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $etudiant->nom_prenom_francais }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $resultat['nb_modules'] ?? 0 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if(isset($resultat['moyenne']) && !is_null($resultat['moyenne']))
                                                    {{ number_format($resultat['moyenne'], 2) }}
                                                @else
                                                    <span class="text-gray-500">Aucune note</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if(isset($resultat['statut']) && !is_null($resultat['statut']))
                                                    @php
                                                        $class = match($resultat['statut']) {
                                                            'Validé' => 'bg-green-100 text-green-800',
                                                            'Racheter' => 'bg-yellow-100 text-yellow-800',
                                                            'Rattrapage' => 'bg-red-100 text-red-800',
                                                            default => 'bg-gray-200 text-gray-800',
                                                        };
                                                    @endphp
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                                        {{ $resultat['statut'] }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-500">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                @if(isset($resultat['moyenne']) && !is_null($resultat['moyenne']))
                                                    <a href="{{ route('rapports.releve-notes', ['etudiant_ppr' => $etudiant->ppr, 'semestre_id' => request('semestre_id')]) }}"
                                                       target="_blank"
                                                       class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                        📄 Relevé PDF
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <form method="POST" action="{{ route('note-semestres.enregistrer') }}">
                                @csrf
                                <input type="hidden" name="annee_universitaire_id" value="{{ request('annee_universitaire_id') }}">
                                <input type="hidden" name="semestre_id" value="{{ request('semestre_id') }}">
                                <input type="hidden" name="groupe_id" value="{{ request('groupe_id') }}">

                                <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Valider les notes de semestre
                                </button>
                            </form>
                        </div>
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