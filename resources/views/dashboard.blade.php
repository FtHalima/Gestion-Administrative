<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tableau de bord
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <!-- Stats grid -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Étudiants -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <!-- User icon (Heroicon: user) -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-500">Étudiants</h3>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['etudiants'] }}</p>
                            <p class="mt-1 text-sm text-gray-500">Total inscrits</p>
                        </div>
                    </div>
                </div>

                <!-- Modules -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-blue-100 text-blue-600 flex items-center justify-center">
                            <!-- Book open icon (Heroicon: book-open) -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-500">Modules</h3>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['modules'] }}</p>
                            <p class="mt-1 text-sm text-gray-500">Modules actifs</p>
                        </div>
                    </div>
                </div>

                <!-- Groupes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <!-- Users icon (Heroicon: users) -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-500">Groupes</h3>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['groupes'] }}</p>
                            <p class="mt-1 text-sm text-gray-500">Groupes de formation</p>
                        </div>
                    </div>
                </div>

                <!-- Notes totales -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-purple-100 text-purple-600 flex items-center justify-center">
                            <!-- Calculator icon (Heroicon: calculator) -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 012 2v6a2 2 0 01-2 2h-6a2 2 0 01-2-2v-6a2 2 0 012-2zm0-6V5a2 2 0 00-2-2h-6a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2zM9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2v-2h2v2h2v-2h2V7a2 2 0 00-2-2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-500">Notes</h3>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['notes_total'] }}</p>
                            <p class="mt-1 text-sm text-gray-500">Toutes les notes enregistrées</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deuxième partie : Répartition des notes -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Répartition des notes</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Examens</span>
                                <span class="font-medium text-gray-900">{{ $stats['notes_examen'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Modules</span>
                                <span class="font-medium text-gray-900">{{ $stats['notes_module'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Semestres</span>
                                <span class="font-medium text-gray-900">{{ $stats['notes_semestre'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Mémoires</span>
                                <span class="font-medium text-gray-900">{{ $stats['notes_memoire'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Stages</span>
                                <span class="font-medium text-gray-900">{{ $stats['notes_stage'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>