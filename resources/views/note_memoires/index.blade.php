<x-app-layout>
    <slot name="header">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h2 class="font-semibold text-xl text-[#0F172A]">
                    Notes de mémoire
                </h2>
                <p class="text-sm text-gray-500">
                    Gestion des mémoires, des encadrants et des évaluations des étudiants.
                </p>
            </div>
        </div>
    </slot>

    <div class="bg-[#F5F7FC] min-h-[calc(100vh-10rem)] p-6">
            <!-- Success message -->
            @if (session('success'))
                <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 flex items-center space-x-2 text-emerald-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error messages -->
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 flex items-center space-x-2 text-red-700">
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
                            <h3 class="text-base font-semibold text-[#0F172A]">Filtrer les notes de mémoire</h3>
                            <p class="text-sm text-[#64748B]">Sélectionnez l'année universitaire et le groupe pour afficher les étudiants.</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('note-memoires.filtrer') }}" class="mt-4">
                        <div class="grid gap-4 sm:grid-cols-2">
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
                                            Titre du mémoire
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[180px] text-[#64748B]">
                                            Encadrant
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[80px] text-[#64748B]">
                                            Note Soutenance<br>(50%)
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[80px] text-[#64748B]">
                                            Note Rapport<br>(50%)
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[80px] text-[#64748B]">
                                            Moyenne
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-[#D5DBE8]">
                                    @foreach($etudiants as $etudiant)
                                        @php
                                            $note = $notes[$etudiant->ppr] ?? null;
                                        @endphp
                                        <tr class="hover:bg-[#EFF6FF] transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->ppr }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $etudiant->cin }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#0F172A]">{{ $etudiant->nom_prenom_francais }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="text" name="titres[{{ $etudiant->ppr }}]"
                                                       value="{{ $note ? $note->titre_memoire : '' }}"
                                                       class="w-full min-w-[280px] rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]/20">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <select name="encadrants[{{ $etudiant->ppr }}]"
                                                        class="w-full min-w-[220px] rounded-lg border border-[#D5DBE8] bg-white text-sm focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]/20">
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
                                                       class="w-[85px] h-10 px-2 text-center rounded-lg border border-[#D5DBE8] bg-white text-gray-900 focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]/20 focus:outline-none soutenance-input"
                                                       data-ppr="{{ $etudiant->ppr }}">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="number" name="notes_rapport[{{ $etudiant->ppr }}]"
                                                       min="0" max="20" step="0.25"
                                                       value="{{ $note ? $note->note_rapport : '' }}"
                                                       class="w-[85px] h-10 px-2 text-center rounded-lg border border-[#D5DBE8] bg-white text-gray-900 focus:border-[#00236F] focus:ring-2 focus-ring-[#00236F]/20 focus:outline-none rapport-input"
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

                        <div class="mt-4 flex justify-end">
                            <form method="POST" action="{{ route('note-memoires.enregistrer') }}">
                                @csrf
                                <input type="hidden" name="annee_universitaire_id" value="{{ request('annee_universitaire_id') }}">
                                <input type="hidden" name="groupe_id" value="{{ request('groupe_id') }}">

                                <button type="submit"
                                        class="flex items-center space-x-2 bg-[#00236F] text-white rounded-lg font-medium hover:bg-[#1E3A8A] transition-colors px-5 py-2.5">
                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l4 4M7 13h10l4-4m0 0L9 17m0 0H4"/>
                                    </svg>
                                    Enregistrer les notes de mémoire
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty state -->
                <div class="mt-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3m0 0l3-3m-3 3V8m0 0a2 2 0 100-4 2 2 0 000 4zM5 13l3 3m0 0l3-3m-3 3V8m0 0a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                    <p class="text-sm text-[#64748B]">
                        Aucun étudiant trouvé
                    </p>
                    <p class="mt-1 text-sm text-[#64748B]">
                        Veuillez sélectionner une année universitaire et un groupe.
                    </p>
                </div>
            @endif
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