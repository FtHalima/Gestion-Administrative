<x-app-layout>
    <slot name="header">
        <div class="space-y-2">
            <h2 class="font-semibold text-xl text-[#0F172A]">
                Paramètres
            </h2>
            <p class="text-sm text-[#64748B]">
                Configurez la structure académique de votre établissement.
            </p>
        </div>
    </slot>

    <div class="bg-[#F5F7FC] min-h-[calc(100vh-10rem)] p-6">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Années universitaires -->
                <a href="{{ route('annees-universitaires.index') }}" class="group block">
                    <div class="h-full bg-white rounded-xl border border-[#D5DBE8] shadow-sm p-6 hover:border-[#00236F] hover:bg-[#F5F7FC] transition-colors duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-[#EFF6FF] rounded-full">
                                <svg class="h-5 w-5 text-[#00236F]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-[#0F172A] mb-2">Années universitaires</h3>
                        <p class="text-sm text-[#64748B]">Gérer les années académiques et leurs dates</p>
                        <span class="inline-flex items-center ml-auto text-[#00236F] text-xs">
                            →
                        </span>
                    </div>
                </a>

                <!-- Semestres -->
                <a href="{{ route('semestres.index') }}" class="group block">
                    <div class="h-full bg-white rounded-xl border border-[#D5DBE8] shadow-sm p-6 hover:border-[#00236F] hover:bg-[#F5F7FC] transition-colors duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-[#EFF6FF] rounded-full">
                                <svg class="h-5 w-5 text-[#00236F]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-[#0F172A] mb-2">Semestres</h3>
                        <p class="text-sm text-[#64748B]">Configurer les semestres et leurs périodes</p>
                        <span class="inline-flex items-center ml-auto text-[#00236F] text-xs">
                            →
                        </span>
                    </div>
                </a>

                <!-- Modules -->
                <a href="{{ route('modules.index') }}" class="group block">
                    <div class="h-full bg-white rounded-xl border border-[#D5DBE8] shadow-sm p-6 hover:border-[#00236F] hover:bg-[#F5F7FC] transition-colors duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-[#EFF6FF] rounded-full">
                                <svg class="h-5 w-5 text-[#00236F]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 3h6a2 2 0 002 2v14a2 2 0 002 2h8a2 2 0 002-2v-9H2V5zm10-1H4a1 1 0 00-1 1v2a1 1 0 001 1h8a1 1 0 001-1v-2a1 1 0 00-1-1zm0 6H4v2h8v-2z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-[#0F172A] mb-2">Modules</h3>
                        <p class="text-sm text-[#64748B]">Créer et affecter les modules aux enseignants</p>
                        <span class="inline-flex items-center ml-auto text-[#00236F] text-xs">
                            →
                        </span>
                    </div>
                </a>

                <!-- Groupes -->
                <a href="{{ route('groupes.index') }}" class="group block">
                    <div class="h-full bg-white rounded-xl border border-[#D5DBE8] shadow-sm p-6 hover:border-[#00236F] hover:bg-[#F5F7FC] transition-colors duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-[#EFF6FF] rounded-full">
                                <svg class="h-5 w-5 text-[#00236F]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 118 0zM8 11v1a2 2 0 002 2h4a2 2 0 002-2v-1m-2-5a4 4 0 11-8 0 4 4 0 118 0zM8 5a4 4 0 118 0v2a4 4 0 01-8 0V5z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-[#0F172A] mb-2">Groupes</h3>
                        <p class="text-sm text-[#64748B]">Organiser les étudiants par groupes</p>
                        <span class="inline-flex items-center ml-auto text-[#00236F] text-xs">
                            →
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>