<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le module
        </h2>
    </slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('modules.update', $module) }}">
                        @csrf
                        @method('PUT')
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded-md">
                                <ul class="list-disc list-inside text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="code_module" class="block text-sm font-medium text-gray-700">Code module</label>
                                <input id="code_module" name="code_module" type="text" required
                                       value="{{ old('code_module', $module->code_module) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div>
                                <label for="nom_module" class="block text-sm font-medium text-gray-700">Nom module</label>
                                <input id="nom_module" name="nom_module" type="text" required
                                       value="{{ old('nom_module', $module->nom_module) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div>
                                <label for="semestre_id" class="block text-sm font-medium text-gray-700">Semestre</label>
                                <select id="semestre_id" name="semestre_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Sélectionner un semestre --</option>
                                    @foreach ($semestres as $semestre)
                                        <option value="{{ $semestre->id }}" {{ old('semestre_id', $module->semestre_id) == $semestre->id ? 'selected' : '' }}>
                                            {{ $semestre->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="professeur_id" class="block text-sm font-medium text-gray-700">Professeur</label>
                                <select id="professeur_id" name="professeur_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Sélectionner un professeur --</option>
                                    @foreach ($professeurs as $professeur)
                                        <option value="{{ $professeur->id }}" {{ old('professeur_id', $module->professeur_id) == $professeur->id ? 'selected' : '' }}>
                                            {{ $professeur->nom }} {{ $professeur->prenom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('modules.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Mettre à jour le module
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>