<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Liste des étudiants
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

                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Filter form -->
                    <form method="GET" action="{{ route('etudiants.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div>
                                <label for="groupe_id" class="block text-sm font-medium text-gray-700">Groupe</label>
                                <select id="groupe_id" name="groupe_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Tous les groupes --</option>
                                    @foreach ($groupes as $groupe)
                                        <option value="{{ $groupe->id }}" {{ request()->get('groupe_id') == $groupe->id ? 'selected' : '' }}>
                                            {{ $groupe->nom_groupe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Recherche (nom, matricule, CIN)</label>
                                <input id="search" type="text" name="search"
                                       value="{{ request()->get('search') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       placeholder="Nom, matricule ou CIN">
                            </div>

                            <div class="flex items-end">
                                <button type="submit"
                                        class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus-ring-offset-2 focus:ring-indigo-500">
                                    Filtrer
                                </button>
                                <a href="{{ route('etudiants.index') }}" class="ml-3 mt-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Réinitialiser
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Buttons: New student, Export -->
                    <div class="mb-4 flex items-center gap-3">
                        <a href="{{ route('etudiants.create') }}" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus-ring-offset-2 focus:ring-indigo-500">
                            + Nouvel étudiant
                        </a>
                        <a href="{{ route('etudiants.export.csv') }}" class="px-3 py-1 bg-gray-800 text-white text-sm rounded hover:bg-gray-700">
                            Exporter CSV
                        </a>
                    </div>

                    <!-- Table -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="overflow-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            PPR
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            CIN
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Matricule
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom prénom (FR)
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Groupe
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($etudiants as $etudiant)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $etudiant->ppr }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $etudiant->cin ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $etudiant->matricule ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $etudiant->nom_prenom_francais }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $etudiant->groupe ? $etudiant->groupe->nom_groupe : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $etudiant->email ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('etudiants.edit', $etudiant->ppr) }}"
                                                   class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    Modifier
                                                </a>
                                                <form action="{{ route('etudiants.destroy', $etudiant->ppr) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-900"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ? Cette action est irréversible.');">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Aucun étudiant trouvé.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('form.d-inline').forEach(form => {
            form.addEventListener('submit', function(e) {
                console.log('Form submitted', this);
                // Uncomment the line below to prevent submission for debugging
                // e.preventDefault();
            });
        });
    </script>
</x-app-layout>