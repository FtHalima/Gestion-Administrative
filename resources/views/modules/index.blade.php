<x-app-layout>
    <slot name="header">
        <div class="space-y-2">
            <h2 class="font-semibold text-xl text-[#0F172A]">
                Gestion des modules
            </h2>
            <p class="text-sm text-[#64748B]">
                Liste et gestion des modules académiques
            </p>
        </div>
    </slot>

    <div class="bg-[#F5F7FC] min-h-[calc(100vh-10rem)] p-6">
        <div class="w-full sm:px-6 lg:px-8">
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
            @if (session('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 flex items-center space-x-2 text-red-700">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white border border-[#D5DBE8] rounded-xl shadow-sm">
                <div class="px-6 py-4">
                    <div class="mb-4 flex justify-between items-center border-b pb-2">
                        <div class="space-y-1">
                            <h3 class="text-base font-semibold text-[#0F172A]">
                                Modules
                            </h3>
                            <p class="text-sm text-[#64748B]">
                                Gérez les modules de votre établissement
                            </p>
                        </div>
                        <a href="{{ route('modules.create') }}"
                           class="flex items-center space-x-2 bg-[#00236F] text-white rounded-lg font-medium hover:bg-[#1E3A8A] transition-colors px-5 py-2.5">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0h6"></path>
                            </svg>
                            Nouveau module
                        </a>
                    </div>

                    <div class="overflow-auto">
                        <table class="min-w-full table-fixed divide-y divide-gray-200">
                            <thead class="bg-[#F8FAFC]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[120px] text-[#64748B]">
                                        Code module
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[200px] text-[#64748B]">
                                        Nom module
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[150px] text-[#64748B]">
                                        Semestre
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider w-[150px] text-[#64748B]">
                                        Professeur
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-[#D5DBE8]">
                                @forelse ($modules as $module)
                                    <tr class="hover:bg-[#EFF6FF] transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $module->code_module }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $module->nom_module }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $module->semestre->nom }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $module->professeur->nom ?? $module->professeur->prenom ?? 'Inconnu' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('modules.edit', $module) }}"
                                               class="text-[#00236F] hover:text-[#1E3A8A] mr-3">Modifier</a>
                                            <form action="{{ route('modules.destroy', $module) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('���Êtes-vous sûr de vouloir supprimer ce module ? Il ne peut être supprimé s'il est lié à des notes (examen ou module).');">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Aucun module enregistré.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>