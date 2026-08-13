<x-app-layout>
    <slot name="header">
        <div class="space-y-2">
            <h2 class="font-semibold text-xl text-[#0F172A]">
                Imprimer les rapports
            </h2>
            <p class="text-sm text-[#64748B]">
                Sélectionnez le type de document à générer
            </p>
        </div>
    </slot>

    <div class="bg-[#F5F7FC] min-h-[calc(100vh-10rem)] p-6">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Relevé de notes -->
                <a href="{{ route('rapports.releve-notes-formulaire') }}" class="group block">
                    <div class="h-full bg-white rounded-xl border border-[#D5DBE8] shadow-sm p-6 hover:border-[#00236F] hover:bg-[#F5F7FC] transition-colors duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-[#EFF6FF] rounded-full">
                                <svg class="h-5 w-5 text-[#00236F]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a3 3 0 100-6m-6 6a3 3 0 100-6m6 6a3 3 0 100-6" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-[#0F172A] mb-2">Relevé de notes</h3>
                        <p class="text-sm text-[#64748B]">Relevé de notes détaillé par étudiant et semestre</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#10B981]/20 text-[#10B981]">
                            Disponible
                        </span>
                    </div>
                </a>

                <!-- Attestation de stage -->
                <a href="#" class="group block opacity-50 pointer-events-none">
                    <div class="h-full bg-white rounded-xl border border-[#D5DBE8] shadow-sm p-6">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-[#EFF6FF] rounded-full">
                                <svg class="h-5 w-5 text-[#00236F]/50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M9 12l2-2 4 4" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-[#0F172A] mb-2 opacity-50">Attestation de stage</h3>
                        <p class="text-sm text-[#64748B] opacity-50">Attestation de réalisation de stage</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#10B981]/20 text-[#10B981] opacity-50">
                            Bientôt disponible
                        </span>
                    </div>
                </a>

                <!-- Liste de présence -->
                <a href="#" class="group block opacity-50 pointer-events-none">
                    <div class="h-full bg-white rounded-xl border border-[#D5DBE8] shadow-sm p-6">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-[#EFF6FF] rounded-full">
                                <svg class="h-5 w-5 text-[#00236F]/50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" data-name="layer 1" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-[#0F172A] mb-2 opacity-50">Liste de présence</h3>
                        <p class="text-sm text-[#64748B] opacity-50">Liste de présence des étudiants par cours</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#10B981]/20 text-[#10B981] opacity-50">
                            Bientôt disponible
                        </span>
                    </div>
                </a>

                <!-- État administratif -->
                <a href="#" class="group block opacity-50 pointer-events-none">
                    <div class="h-full bg-white rounded-xl border border-[#D5DBE8] shadow-sm p-6">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-[#EFF6FF] rounded-full">
                                <svg class="h-5 w-5 text-[#00236F]/50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m4-8H9a2 2 0 00-2 2v10a2 2 0 002 2h6a2 2 0 002-2v-3m0-3a2 2 0 00-2-2H9a2 2 0 00-2 2v2" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-[#0F172A] mb-2 opacity-50">État administratif</h3>
                        <p class="text-sm text-[#64748B] opacity-50">Synthèse de la situation administrative de l'étudiant</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#10B981]/20 text-[#10B981] opacity-50">
                            Bientôt disponible
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>