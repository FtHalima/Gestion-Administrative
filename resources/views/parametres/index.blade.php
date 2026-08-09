<x-app-layout>
    <slot name="header">
        <div class="space-y-2">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Paramètres
            </h2>
            <p class="text-sm text-gray-500">
                Configurez la structure académique de votre établissement.
            </p>
        </div>
    </slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Années universitaires -->
                <a href="{{ route('annees-universitaires.index') }}" class="group block">
                    <div class="h-full bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:shadow-md hover:border-indigo-300 transition duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-50 rounded-full">
                                <svg class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Années universitaires</h3>
                        <p class="text-sm text-gray-500">Gérer les années académiques et leurs dates</p>
                    </div>
                </a>

                <!-- Semestres -->
                <a href="{{ route('semestres.index') }}" class="group block">
                    <div class="h-full bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:shadow-md hover:border-indigo-300 transition duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-50 rounded-full">
                                <svg class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Semestres</h3>
                        <p class="text-sm text-gray-500">Configurer les semestres et leurs périodes</p>
                    </div>
                </a>

                <!-- Modules -->
                <a href="{{ route('modules.index') }}" class="group block">
                    <div class="h-full bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:shadow-md hover:border-indigo-300 transition duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-50 rounded-full">
                                <svg class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Modules</h3>
                        <p class="text-sm text-gray-500">Créer et affecter les modules aux enseignants</p>
                    </div>
                </a>

                <!-- Groupes -->
                <a href="{{ route('groupes.index') }}" class="group block">
                    <div class="h-full bg-white rounded-lg border border-gray-200 shadow-sm p-6 hover:shadow-md hover:border-indigo-300 transition duration-200">
                        <div class="flex items-center justify-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center bg-indigo-50 rounded-full">
                                <svg class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 6v2l3 3h-2v3l3-3v-2h3l-3-3V6H9z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 mb-2">Groupes</h3>
                        <p class="text-sm text-gray-500">Organiser les étudiants par groupes</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>