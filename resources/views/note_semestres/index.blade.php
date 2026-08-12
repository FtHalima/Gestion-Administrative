<x-app-layout>
    <slot name="header">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h2 class="font-semibold text-xl text-[#0F172A]">
                    Notes de semestre
                </h2>
                <p class="text-sm text-gray-500">
                    Consultez les résultats et validez les notes de semestre des étudiants.
                </p>
            </div>
        </div>
    </slot>

    <div class="bg-[#F5F7FC] min-h-[calc(100vh-10rem)] p-6">
        <div class="mx-auto max-w-7xl">
            <!-- Success message -->
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 flex items-center space-x-2">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Card -->
            <div class="bg-white border border-[#D5DBE8] rounded-xl shadow-sm">
                <div class="px-6 py-4">
                    <div class="mb-4 flex justify-between items-center border-b pb-2">
                        <div class="space-y-1">
                            <h3 class="text-base font-semibold text-[#0F172A]">Filtrer les notes de semestre</h3>
                            <p class="text-sm text-[#64748B]">Sélectionnez l'année universitaire, le semestre et le groupe pour afficher les étudiants.</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('note-semestres.filtrer') }}" class="mt-4">
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            <!-- Année universitaire -->
                            <div>
                                <label for="annee_universitaire_id" class="block text-sm font-medium text-[#0F172A] mb-1">Année universitaire</label>
                                <select id="annee_universitaire_id" name="annee_universitaire_id"
                                        class="w-full rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]">
                                    <option value="">-- Sélectionner une année --</option>
                                    @foreach($annees as $annee)
                                        <option value="{{ $annee->id }}"
                                                {{ request('annee_universitaire_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Semestre -->
                            <div>
                                <label for="semestre_id" class="block text-sm font-medium text-[#0F172A] mb-1">Semestre</label>
                                <select id="semestre_id" name="semestre_id"
                                        class="w-full rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]">
                                    <option value="">-- Sélectionner un semestre --</option>
                                    @foreach($semestres as $semestre)
                                        <option value="{{ $semestre->id }}"
                                                {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>
                                            {{ $semestre->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Groupe -->
                            <div>
                                <label for="groupe_id" class="block text-sm font-medium text-[#0F172A] mb-1">Groupe</label>
                                <select id="groupe_id" name="groupe_id"
                                        class="w-full rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]">
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
                        <div class="mt-4 flex justify-end">
                            <button type="submit"
                                    class="flex items-center space-x-2 bg-[#00236F] text-white rounded-lg font-medium hover:bg-[#1E3A8A] transition-colors px-5 py-2.5">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Filtrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($etudiants) && $etudiants->isNotEmpty())
                @php
                    $etudiants = $etudiants ?? collect();
                @endphp
                <!-- Students Card -->
                <div class="bg-white border border-[#D5DBE8] rounded-xl shadow-sm mt-6">
                    <div class="px-6 py-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-[#D5DBE8]">
                                <thead class="bg-[#F8FAFC]">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                            PPR
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                            CIN
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-[#0F172A]">
                                            Nom complet
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                            Nombre de modules notés
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                            Moyenne
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                            Statut
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-[#D5DBE8]">
                                    @foreach($etudiants as $etudiant)
                                        @php
                                            $resultat = $resultats[$etudiant->ppr] ?? [];
                                        @endphp
                                        <tr class="hover:bg-[#EFF6FF] transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->ppr }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->cin }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#0F172A]">{{ $etudiant->nom_prenom_francais }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $resultat['nb_modules'] ?? 0 }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if(isset($resultat['moyenne']) && !is_null($resultat['moyenne']))
                                                    <span class="font-semibold text-[#0F172A]">{{ number_format($resultat['moyenne'], 2) }}</span>
                                                @else
                                                    <span class="text-gray-500">Aucune note</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if(isset($resultat['statut']) && !is_null($resultat['statut']))
                                                    @php
                                                        $badgeClass = match($resultat['statut']) {
                                                            'Validé' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                                            'Racheter' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                                            'Rattrapage' => 'bg-rose-50 text-rose-700 border border-rose-200',
                                                            default => 'bg-gray-200 text-gray-800',
                                                        };
                                                    @endphp
                                                    <span class="px-3 py-1 text-xs font-medium rounded-full {{ $badgeClass }}">
                                                        {{ $resultat['statut'] }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-500">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if(isset($resultat['moyenne']) && !is_null($resultat['moyenne']))
                                                    <a href="{{ route('rapports.releve-notes', ['etudiant_ppr' => $etudiant->ppr, 'semestre_id' => request('semestre_id')]) }}"
                                                       target="_blank"
                                                       class="flex items-center justify-center bg-[#00236F] text-white rounded-lg hover:bg-[#1E3A8A] transition-colors px-4 py-2">
                                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 100-4 0 2 2 0 002-4v6m0 0l-3-3m3 3V9"/>
                                                        </svg>
                                                        Relevé PDF
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <form method="POST" action="{{ route('note-semestres.enregistrer') }}">
                                @csrf
                                <input type="hidden" name="annee_universitaire_id" value="{{ request('annee_universitaire_id') }}">
                                <input type="hidden" name="semestre_id" value="{{ request('semestre_id') }}">
                                <input type="hidden" name="groupe_id" value="{{ request('groupe_id') }}">

                                <button type="submit"
                                        class="flex items-center space-x-2 bg-[#00236F] text-white rounded-lg font-medium hover:bg-[#1E3A8A] transition-colors px-5 py-2.5">
                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l4 4M7 13h10l4-4m0 0L9 17m0 0H4"/>
                                    </svg>
                                    Valider les notes de semestre
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty state -->
                <div class="mt-6 bg-white border border-[#D5DBE8] rounded-xl p-10 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3m0 0l3-3m-3 3V8m0 0a2 2 0 100-4 2 2 0 000 4zM5 13l3 3m0 0l3-3m-3 3V8m0 0a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                    <p class="mt-2 text-sm text-[#64748B]">
                        Aucun étudiant trouvé
                    </p>
                    <p class="mt-1 text-sm text-[#64748B]">
                        Veuillez sélectionner un semestre et un groupe.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>