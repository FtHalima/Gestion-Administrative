<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vue d'ensemble du système
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <?php
            $femaleCount = \App\Models\Etudiant::where('genre', 'F')->count();
            $maleCount = \App\Models\Etudiant::where('genre', 'M')->count();
            $known = $femaleCount + $maleCount;
            if ($known > 0) {
                $femalePercent = round(($femaleCount / $known) * 100);
                $malePercent = round(($maleCount / $known) * 100);
            } else {
                $femalePercent = 0;
                $malePercent = 0;
            }
            ?>
            <!-- Stats grid -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Étudiants -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <!-- User icon -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-500">TOTAL DES ÉTUDIANTS</h3>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['etudiants'] }}</p>
                            <p class="mt-1 text-sm text-gray-500">Total inscrits</p>
                        </div>
                    </div>
                </div>

                <!-- Modules (pôles) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-blue-100 text-blue-600 flex items-center justify-center">
                            <!-- Book open icon -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-500">TOTAL DES MODULES</h3>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $stats['modules'] }}</p>
                            <p class="mt-1 text-sm text-gray-500">Modules actifs</p>
                        </div>
                    </div>
                </div>

                <!-- Répartition par genre -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 flex items-center space-x-4">
                        <div class="flex-shrink-0 h-10 w-10 rounded-md bg-purple-100 text-purple-600 flex items-center justify-center">
                            <!-- Chart icon -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v2H3V3zm0 4h18v2H3V7zm0 4h18v2H3v-2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-500">RÉPARTITION PAR GENRE</h3>
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-gray-900">
                                    Femelle  : {{ $femaleCount }} ({{ $femalePercent }}%)
                                </p>
                                <p class="text-sm font-medium text-gray-900">
                                    Male : {{ $maleCount }} ({{ $malePercent }}%)
                                </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accès rapide -->
            <div class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2 sm:p-4">
                    <div class="p-6 flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 ">Accès rapide</h3>
                        </div>
                        
                    </div>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <!-- Saisir les notes -->
                        <a href="{{ route('note-modules.index') }}" class="block bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-[#EFF6FF] transition-colors">
                            <div class="flex-shrink-0 h-8 w-8 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center mb-2">
                                <!-- Edit icon -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Saisir les notes</p>
                        </a>

                        <!-- Les modules -->
                        <a href="{{ route('modules.index') }}" class="block bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-[#EFF6FF] transition-colors">
                            <div class="flex-shrink-0 h-8 w-8 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center mb-2">
                                <!-- Book icon -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Les modules</p>
                        </a>

                        <!-- Imprimer -->
                        <a href="{{ route('rapports.index') }}" class="block bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-[#EFF6FF] transition-colors">
                            <div class="flex-shrink-0 h-8 w-8 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center mb-2">
                                <!-- Printer icon -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H5a2 2 0 00-2 2v4a2 2 0 002 2h4l2 2h2l2-2h2a2 2 0 002-2V7a2 2 0 002-2V5z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Imprimer</p>
                        </a>

                        <!-- Rechercher étudiant -->
                        <a href="{{ route('etudiants.index') }}" class="block bg-white border border-gray-200 rounded-lg p-4 text-center hover:bg-[#EFF6FF] transition-colors">
                            <div class="flex-shrink-0 h-8 w-8 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center mb-2">
                                <!-- Search icon -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.636 18.364m12.728-5.636a4.5 4.5 0 01-6.364 6.364" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Rechercher étudiant</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>