<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le semestre
        </h2>
    </slot>

    <div class="py-12">
        <div class="w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('semestres.update', $semestre) }}">
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
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input id="nom" name="nom" type="text" required
                                       value="{{ old('nom', $semestre->nom) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div>
                                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début</label>
                                <input id="date_debut" name="date_debut" type="date" required
                                       value="{{ old('date_debut', $semestre->date_debut ? \Carbon\Carbon::parse($semestre->date_debut)->format('Y-m-d') : '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div>
                                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin</label>
                                <input id="date_fin" name="date_fin" type="date" required
                                       value="{{ old('date_fin', $semestre->date_fin ? \Carbon\Carbon::parse($semestre->date_fin)->format('Y-m-d') : '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div>
                                <label for="annee_universitaire_id" class="block text-sm font-medium text-gray-700">Année universitaire</label>
                                <select id="annee_universitaire_id" name="annee_universitaire_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Sélectionner une année --</option>
                                    @foreach ($annees as $annee)
                                        <option value="{{ $annee->id }}" {{ old('annee_universitaire_id', $semestre->annee_universitaire_id) == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                                <select id="statut" name="statut"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="debut" {{ old('statut', $semestre->statut) == 'debut' ? 'selected' : '' }}>Début</option>
                                    <option value="cloture" {{ old('statut', $semestre->statut) == 'cloture' ? 'selected' : '' }}>Clôture</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('semestres.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Mettre à jour le semestre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>