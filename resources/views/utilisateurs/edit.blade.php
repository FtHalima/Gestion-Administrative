<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier l'utilisateur
        </h2>
    </slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('utilisateurs.update', $utilisateur) }}">
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
                                       value="{{ old('nom', $utilisateur->nom) }}"
                                       class="mt-1 block w-80 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input id="prenom" name="prenom" type="text" required
                                       value="{{ old('prenom', $utilisateur->prenom) }}"
                                       class="mt-1 block w-80 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-70 text-gray-700">Email</label>
                                <input id="email" name="email" type="email" required
                                       value="{{ old('email', $utilisateur->email) }}"
                                       class="mt-1 block w-80 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div class="sm:col-span-2">
                                <label for="mot_de_passe" class="block text-sm font-medium text-gray-700">Mot de passe (laisser vide pour ne pas changer)</label>
                                <input id="mot_de_passe" name="mot_de_passe" type="password"
                                       class="mt-1 block w-80 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">

                                <label for="mot_de_passe_confirmation" class="mt-4 block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                                <input id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" type="password"
                                       class="mt-1 block w-80 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            </div>

                            <div class="sm:col-span-2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                                        <select id="role" name="role"
                                                class="mt-1 block w-80 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="enseignant" {{ old('role', $utilisateur->role) == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                                            <option value="administration" {{ old('role', $utilisateur->role) == 'administration' ? 'selected' : '' }}>Administration</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                                        <select id="statut" name="statut"
                                                class="mt-1 block w-80 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="actif" {{ old('statut', $utilisateur->statut) == 'actif' ? 'selected' : '' }}>Actif</option>
                                            <option value="inactif" {{ old('statut', $utilisateur->statut) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('utilisateurs.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Mettre à jour l'utilisateur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>