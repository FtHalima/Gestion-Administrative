<x-app-layout>
    <slot name="header">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h2 class="font-semibold text-xl text-[#0F172A]">
                    Notes de stage
                </h2>
                <p class="text-sm text-gray-500">
                    Gestion des stages, des tuteurs académiques et des évaluations des étudiants.
                </p>
            </div>
        </div>
    </slot>

    <div class="bg-[#F5F7FC] min-h-[calc(100vh-10rem)] p-6">
            <!-- Success message -->
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 flex items-center space-x-2">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error messages -->
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 flex items-center space-x-2">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                    </svg>
                    <ul class="list-disc list-inside text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Filter Card -->
            <div class="bg-white border border-[#D5DBE8] rounded-xl shadow-sm">
                <div class="px-6 py-4">
                    <div class="mb-4 flex justify-between items-center border-b pb-2">
                        <div class="space-y-1">
                            <h3 class="text-base font-semibold text-[#0F172A]">Filtrer les notes de stage</h3>
                            <p class="text-sm text-[#64748B]">Sélectionnez l'année universitaire, le semestre et le groupe pour afficher les étudiants.</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('note-stages.filtrer') }}" class="mt-4">
                        <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-3">
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
                        <div class="mb-4 flex justify-between items-center border-b pb-2">
                            <div class="space-y-1">
                                <h3 class="text-base font-semibold text-[#0F172A]">Évaluation des étudiants</h3>
                                <p class="text-sm text-[#64748B]">Renseignez les informations du stage et la note obtenue.</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('note-stages.enregistrer') }}" class="mt-6" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="annee_universitaire_id" value="{{ request('annee_universitaire_id') }}">
                            <input type="hidden" name="semestre_id" value="{{ request('semestre_id') }}">
                            <input type="hidden" name="groupe_id" value="{{ request('groupe_id') }}">

                            <div class="overflow-x-auto">
                                <table class="min-w-full table-fixed divide-y divide-gray-200">
                                    <thead class="bg-[#F8FAFC]">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[60px] text-[#64748B]">
                                                PPR
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[70px] text-[#64748B]">
                                                CIN
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider w-[120px] text-[#0F172A]">
                                                Nom complet
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[200px] text-[#64748B]">
                                                Établissement d'accueil
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[180px] text-[#64748B]">
                                                Tuteur académique
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[80px] text-[#64748B]">
                                                Note<br>(sur 20)
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                                Fichier
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-[#D5DBE8]">
                                        @foreach($etudiants as $etudiant)
                                            @php $note = $notes[$etudiant->ppr] ?? null; @endphp
                                            <tr class="hover:bg-[#EFF6FF] transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->ppr }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->cin }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#0F172A]">{{ $etudiant->nom_prenom_francais }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="text" name="etablissements[{{ $etudiant->ppr }}]"
                                                           value="{{ $note ? $note->etablissement_accueil : '' }}"
                                                           class="w-full min-w-[280px] rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]/20">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <select name="tuteurs[{{ $etudiant->ppr }}]"
                                                            class="w-full min-w-[220px] rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]/20">
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
                                                           class="w-[85px] h-10 px-2 text-center rounded-lg border border-[#D5DBE8] bg-white text-gray-900 focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]/20 focus:outline-none"
                                                           data-ppr="{{ $etudiant->ppr }}">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if(isset($note) && $note->fichier_url)
                                                        <div class="flex items-center space-x-1 text-sm text-[#00236F]">
                                                            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m4 0H9m5 0V9a2 2 0 00-2-2H5a2 2 0 002 2v6a2 2 0 002 2h6"></path>
                                                            </svg>
                                                            Fichier actuel
                                                        </div>
                                                    @endif
                                                    <input type="file" name="fichiers[{{ $etudiant->ppr }}]"
                                                           accept=".pdf,.doc,.docx"
                                                           class="block w-full text-sm text-gray-700 mt-2">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 flex justify-end">
                                <button type="submit"
                                        class="flex items-center space-x-2 bg-[#00236F] text-white rounded-lg font-medium hover:bg-[#1E3A8A] transition-colors px-5 py-2.5">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l4 4M7 13h10l4-4m0 0L9 17m0 0H4"/>
                                    </svg>
                                    Enregistrer les notes de stage
                                </button>
                            </div>
                        </form>
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
                        Veuillez sélectionner une année, un semestre et un groupe.
                    </p>
                </div>
            @endif
    </div>
</x-app-layout>