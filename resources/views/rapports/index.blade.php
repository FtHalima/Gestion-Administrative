<x-app-layout>
    <slot name="header">
        <div class="space-y-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Imprimer les rapports
            </h2>
            <p class="text-sm text-gray-500">
                Sélectionnez le type de document à générer
            </p>
        </div>
    </slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Relevé de notes -->
                <a href="{{ route('rapports.releve-notes-formulaire') }}" class="group block">
                    <div class="h-full bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:shadow-md hover:border-indigo-300 transition duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-50 rounded-full">
                                <svg class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a3 3 0 100-6m-6 6a3 3 0 100-6m6 6a3 3 0 100-6" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Relevé de notes</h3>
                        <p class="text-sm text-gray-500">Relevé de notes détaillé par étudiant et semestre</p>
                    </div>
                </a>

                <!-- Attestation de stage -->
                <a href="#" class="group block opacity-60 pointer-events-none">
                    <div class="h-full bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-50 rounded-full opacity-60">
                                <svg class="h-5 w-5 text-indigo-600 opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M9 12l2-2 4 4" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2 opacity-60">Attestation de stage</h3>
                        <p class="text-sm text-gray-500 opacity-60">Attestation de réalisation de stage</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 opacity-60">
                            Bientôt disponible
                        </span>
                    </div>
                </a>

                <!-- Liste de présence -->
                <a href="#" class="group block opacity-60 pointer-events-none">
                    <div class="h-full bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-50 rounded-full opacity-60">
                                <svg class="h-5 w-5 text-indigo-600 opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" data-name="layer 1" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2 opacity-60">Liste de présence</h3>
                        <p class="text-sm text-gray-500 opacity-60">Liste de présence des étudiants par cours</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 opacity-60">
                            Bientôt disponible
                        </span>
                    </div>
                </a>

                <!-- État administratif -->
                <a href="#" class="group block opacity-60 pointer-events-none">
                    <div class="h-full bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-50 rounded-full opacity-60">
                                <svg class="h-5 w-5 text-indigo-600 opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m4-8H9a2 2 0 00-2 2v10a2 2 0 002 2h6a2 2 0 002-2v-3m0-3a2 2 0 00-2-2H9a2 2 0 00-2 2v2" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2 opacity-60">État administratif</h3>
                        <p class="text-sm text-gray-500 opacity-60">Synthèse de la situation administrative de l'étudiant</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 opacity-60">
                            Bientôt disponible
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>