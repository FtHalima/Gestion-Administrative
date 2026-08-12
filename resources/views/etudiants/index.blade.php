<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-[#0F172A]">Gestion des étudiants</h2>
    </slot>

    <div class="bg-[#F5F7FC] min-h-[calc(100vh-10rem)] p-6">
        <div class="mx-auto max-w-7xl">
            <!-- Success/Error messages -->
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filter Card -->
            <div class="bg-white border border-[#D5DBE8] rounded-xl">
                <div class="px-6 py-4">
                    <div class="mb-4 flex justify-between items-center border-b pb-2">
                        <h3 class="text-base font-semibold text-[#0F172A]">Filtres</h3>
                    </div>
                    <form method="GET" action="{{ route('etudiants.index') }}" class="mt-4">
                        <div class="gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <!-- Recherche -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-[#0F172A] mb-1">Recherche</label>
                                <input id="search" type="text" name="search"
                                       value="{{ request()->get('search') }}"
                                       class="w-full rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]"
                                       placeholder="Nom, prénom, PPR, CIN ou matricule">
                            </div>
                            <!-- Groupe -->
                            <div>
                                <label for="groupe_id" class="block text-sm font-medium text-[#0F172A] mb-1">Groupe</label>
                                <select id="groupe_id" name="groupe_id"
                                        class="w-full rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]">
                                    <option value="">-- Tous les groupes --</option>
                                    @foreach ($groupes as $groupe)
                                        <option value="{{ $groupe->id }}" {{ request()->get('groupe_id') == $groupe->id ? 'selected' : '' }}>
                                            {{ $groupe->nom_groupe }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Année universitaire -->
                            <div>
                                <label for="annee_id" class="block text-sm font-medium text-[#0F172A] mb-1">Année universitaire</label>
                                <select id="annee_id" name="annee_id"
                                        class="w-full rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]">
                                    <option value="">-- Toutes les années --</option>
                                    @foreach ($annees as $annee)
                                        <option value="{{ $annee->id }}" {{ request()->get('annee_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Trier par -->
                            <div>
                                <label for="sort" class="block text-sm font-medium text-[#0F172A] mb-1">Trier par</label>
                                <select id="sort" name="sort"
                                        class="w-full rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]">
                                    <option value="nom_asc" {{ request()->get('sort', 'nom_asc') == 'nom_asc' ? 'selected' : '' }}>Nom (A → Z)</option>
                                    <option value="nom_desc" {{ request()->get('sort', 'nom_asc') == 'nom_desc' ? 'selected' : '' }}>Nom (Z → A)</option>
                                    <option value="ppr_asc" {{ request()->get('sort', 'nom_asc') == 'ppr_asc' ? 'selected' : '' }}>PPR (croissant)</option>
                                    <option value="ppr_desc" {{ request()->get('sort', 'nom_asc') == 'ppr_desc' ? 'selected' : '' }}>PPR (décroissant)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end space-x-3">
                            <button type="submit"
                                    class="bg-[#00236F] hover:bg-[#001B56] text-white rounded-lg px-4 py-2 font-semibold">
                                Filtrer
                            </button>
                            <a href="{{ route('etudiants.index') }}"
                               class="text-sm font-medium text-[#64748B] hover:text-[#00236F]">
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Actions: New, Import, Export -->
            <div class="flex flex-wrap items-center gap-3 mt-6">
                <a href="{{ route('etudiants.create') }}"
                   class="bg-[#00236F] hover:bg-[#001B56] text-white rounded-lg px-4 py-2 font-semibold">
                    + Nouvel étudiant
                </a>
                <form method="POST" action="{{ route('etudiants.importer') }}" enctype="multipart/form-data" id="import-form" class="inline">
                    @csrf
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required id="import-file-input" class="hidden"
                           onchange="document.getElementById('import-form').submit();">
                    <button type="button" onclick="document.getElementById('import-file-input').click();"
                            class="bg-white border border-[#D5DBE8] text-[#0F172A] rounded-lg px-4 py-2 hover:bg-[#EFF6FF]">
                        Importer
                    </button>
                </form>
                <a href="{{ route('etudiants.export.csv') }}"
                   class="bg-white border border-[#D5DBE8] text-[#0F172A] rounded-lg px-4 py-2 hover:bg-[#EFF6FF]">
                    Exporter CSV
                </a>
            </div>

            <!-- Table Card -->
            <div class="bg-white border border-[#D5DBE8] rounded-xl mt-6 overflow-hidden">
                <div class="overflow-auto">
                    <table class="min-w-full divide-y divide-[#D5DBE8]">
                        <thead class="bg-[#F8FAFC]">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                    PPR
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                    CIN
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                    Matricule
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                    Nom prénom (FR)
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                    Groupe
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                    Email
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-[#D5DBE8]">
                            @forelse ($etudiants as $etudiant)
                                <tr class="hover:bg-[#F8FAFC] transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[#0F172A]">{{ $etudiant->ppr }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->cin ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->matricule ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->nom_prenom_francais }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">
                                        {{ $etudiant->groupe ? $etudiant->groupe->nom_groupe : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->email ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('etudiants.edit', $etudiant->ppr) }}"
                                           class="text-[#00236F] hover:bg-[#EFF6FF] rounded-md px-2 py-1">
                                            Modifier
                                        </a>
                                        <form action="{{ route('etudiants.destroy', $etudiant->ppr) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:bg-red-50 rounded-md px-2 py-1"
                                                    onclick="return confirm('�Êtes-vous sûr de vouloir supprimer cet étudiant ? Cette action est irréversible.');">
                                                Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-[#64748B]">
                                        Aucun étudiant trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-between items-center px-6">
                    <p class="text-sm text-[#64748B]">
                        Affichage de {{ $etudiants->firstItem() }} à {{ $etudiants->lastItem() }} sur {{ $etudiants->total() }} résultats
                    </p>
                    {{ $etudiants->links() }}
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