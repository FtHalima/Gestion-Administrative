<x-app-layout>
    <slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouvel étudiant
        </h2>
    </slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 rounded-md">
                            <ul class="list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('etudiants.store') }}">
                        @csrf

                        <div class="space-y-6">
                            <!-- Identité -->
                            <fieldset>
                                <legend class="text-lg font-medium text-gray-900 mb-2">Identité</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <div>
                                        <label for="ppr" class="block text-sm font-medium text-gray-700 mb-1">PPR</label>
                                        <input id="ppr" type="text" name="ppr"
                                               value="{{ old('ppr') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               required>
                                    </div>
                                    <div>
                                        <label for="cin" class="block text-sm font-medium text-gray-700 mb-1">CIN</label>
                                        <input id="cin" type="text" name="cin"
                                               value="{{ old('cin') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="matricule" class="block text-sm font-medium text-gray-700 mb-1">Matricule</label>
                                        <input id="matricule" type="text" name="matricule"
                                               value="{{ old('matricule') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="nom_prenom_francais" class="block text-sm font-medium text-gray-700 mb-1">Nom prénom (FR)</label>
                                        <input id="nom_prenom_francais" type="text" name="nom_prenom_francais"
                                               value="{{ old('nom_prenom_francais') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               required maxlength="255">
                                    </div>
                                    <div>
                                        <label for="nom_prenom_arabe" class="block text-sm font-medium text-gray-700 mb-1">Nom prénom (AR)</label>
                                        <input id="nom_prenom_arabe" type="text" name="nom_prenom_arabe"
                                               value="{{ old('nom_prenom_arabe') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                                        <select id="genre" name="genre"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="">-- Sélectionner --</option>
                                            <option value="M" {{ old('genre') == 'M' ? 'selected' : '' }}>Masculin</option>
                                            <option value="F" {{ old('genre') == 'F' ? 'selected' : '' }}>Féminin</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                                        <input id="date_naissance" type="date" name="date_naissance"
                                               value="{{ old('date_naissance') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="lieu_naissance" class="block text-sm font-medium text-gray-700 mb-1">Lieu de naissance</label>
                                        <input id="lieu_naissance" type="text" name="lieu_naissance"
                                               value="{{ old('lieu_naissance') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input id="email" type="email" name="email"
                                               value="{{ old('email') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                        <input id="adresse" type="text" name="adresse"
                                               value="{{ old('adresse') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                        <input id="telephone" type="text" name="telephone"
                                               value="{{ old('telephone') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Baccalauréat -->
                            <fieldset>
                                <legend class="text-lg font-medium text-gray-900 mb-2">Baccalauréat</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label for="baccalaureat" class="block text-sm font-medium text-gray-700 mb-1">Baccalauréat</label>
                                        <input id="baccalaureat" type="text" name="baccalaureat"
                                               value="{{ old('baccalaureat') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="direction_baccalaureat" class="block text-sm font-medium text-gray-700 mb-1">Direction du bac</label>
                                        <input id="direction_baccalaureat" type="text" name="direction_baccalaureat"
                                               value="{{ old('direction_baccalaureat') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="annee_baccalaureat" class="block text-sm font-medium text-gray-700 mb-1">Année du bac</label>
                                        <input id="annee_baccalaureat" type="text" name="annee_baccalaureat"
                                               value="{{ old('annee_baccalaureat') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Licence -->
                            <fieldset>
                                <legend class="text-lg font-medium text-gray-900 mb-2">Licence</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label for="licence" class="block text-sm font-medium text-gray-700 mb-1">Licence</label>
                                        <input id="licence" type="text" name="licence"
                                               value="{{ old('licence') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="annee_licence" class="block text-sm font-medium text-gray-700 mb-1">Année licence</label>
                                        <input id="annee_licence" type="text" name="annee_licence"
                                               value="{{ old('annee_licence') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="universite_licence" class="block text-sm font-medium text-gray-700 mb-1">Université licence</label>
                                        <input id="universite_licence" type="text" name="universite_licence"
                                               value="{{ old('universite_licence') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="faculte_licence" class="block text-sm font-medium text-gray-700 mb-1">Faculté licence</label>
                                        <input id="faculte_licence" type="text" name="faculte_licence"
                                               value="{{ old('faculte_licence') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Autre diplôme -->
                            <fieldset>
                                <legend class="text-lg font-medium text-gray-900 mb-2">Autre diplôme</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label for="autre_diplome" class="block text-sm font-medium text-gray-700 mb-1">Autre diplôme</label>
                                        <input id="autre_diplome" type="text" name="autre_diplome"
                                               value="{{ old('autre_diplome') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="specialite_diplome" class="block text-sm font-medium text-gray-700 mb-1">Spécialité diplôme</label>
                                        <input id="specialite_diplome" type="text" name="specialite_diplome"
                                               value="{{ old('specialite_diplome') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="annee_diplome" class="block text-sm font-medium text-gray-700 mb-1">Année diplôme</label>
                                        <input id="annee_diplome" type="text" name="annee_diplome"
                                               value="{{ old('annee_diplome') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="universite_diplome" class="block text-sm font-medium text-gray-700 mb-1">Université diplôme</label>
                                        <input id="universite_diplome" type="text" name="universite_diplome"
                                               value="{{ old('universite_diplome') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="faculte_diplome" class="block text-sm font-medium text-gray-700 mb-1">Faculté diplôme</label>
                                        <input id="faculte_diplome" type="text" name="faculte_diplome"
                                               value="{{ old('faculte_diplome') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Formation -->
                            <fieldset>
                                <legend class="text-lg font-medium text-gray-900 mb-2">Formation</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label for="centre" class="block text-sm font-medium text-gray-700 mb-1">Centre</label>
                                        <input id="centre" type="text" name="centre"
                                               value="{{ old('centre') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="ville_centre" class="block text-sm font-medium text-gray-700 mb-1">Ville du centre</label>
                                        <input id="ville_centre" type="text" name="ville_centre"
                                               value="{{ old('ville_centre') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="annee_sortie" class="block text-sm font-medium text-gray-700 mb-1">Année de sortie</label>
                                        <input id="annee_sortie" type="text" name="annee_sortie"
                                               value="{{ old('annee_sortie') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Carrière -->
                            <fieldset>
                                <legend class="text-lg font-medium text-gray-900 mb-2">Carrière</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label for="date_recrutement" class="block text-sm font-medium text-gray-700 mb-1">Date de recrutement</label>
                                        <input id="date_recrutement" type="date" name="date_recrutement"
                                               value="{{ old('date_recrutement') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="cadre" class="block text-sm font-medium text-gray-700 mb-1">Cadre</label>
                                        <input id="cadre" type="text" name="cadre"
                                               value="{{ old('cadre') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Grade</label>
                                        <input id="grade" type="text" name="grade"
                                               value="{{ old('grade') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="anciennete_grade" class="block text-sm font-medium text-gray-700 mb-1">Ancienneté de grade</label>
                                        <input id="anciennete_grade" type="date" name="anciennete_grade"
                                               value="{{ old('anciennete_grade') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="echelon" class="block text-sm font-medium text-gray-700 mb-1">Échelon</label>
                                        <input id="echelon" type="text" name="echelon"
                                               value="{{ old('echelon') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="anciennete_echelon" class="block text-sm font-medium text-gray-700 mb-1">Ancienneté d'échelon</label>
                                        <input id="anciennete_echelon" type="date" name="anciennete_echelon"
                                               value="{{ old('anciennete_echelon') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="dernier_etablissement" class="block text-sm font-medium text-gray-700 mb-1">Dernier établissement</label>
                                        <input id="dernier_etablissement" type="text" name="dernier_etablissement"
                                               value="{{ old('dernier_etablissement') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="cycle" class="block text-sm font-medium text-gray-700 mb-1">Cycle</label>
                                        <input id="cycle" type="text" name="cycle"
                                               value="{{ old('cycle') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                                        <input id="ville" type="text" name="ville"
                                               value="{{ old('ville') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="direction_provinciale" class="block text-sm font-medium text-gray-700 mb-1">Direction provinciale</label>
                                        <input id="direction_provinciale" type="text" name="direction_provinciale"
                                               value="{{ old('direction_provinciale') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Affectation -->
                            <fieldset>
                                <legend class="text-lg font-medium text-gray-900 mb-2">Affectation</legend>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="groupe_id" class="block text-sm font-medium text-gray-700 mb-1">Groupe</label>
                                        <select id="groupe_id" name="groupe_id"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="">-- Sélectionner un groupe --</option>
                                            @foreach ($groupes as $groupe)
                                                <option value="{{ $groupe->id }}"
                                                        {{ old('groupe_id') == $groupe->id ? 'selected' : '' }}>
                                                    {{ $groupe->nom_groupe }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="classe" class="block text-sm font-medium text-gray-700 mb-1">Classe</label>
                                        <input id="classe" type="text" name="classe"
                                               value="{{ old('classe') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                    <div>
                                        <label for="n_ordre" class="block text-sm font-medium text-gray-700 mb-1">N° ordre</label>
                                        <input id="n_ordre" type="text" name="n_ordre"
                                               value="{{ old('n_ordre') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                               maxlength="255">
                                    </div>
                                </div>
                            </fieldset>

                            <div class="mt-6 flex items-center justify-end space-x-3">
                                <a href="{{ route('etudiants.index') }}"
                                   class="text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus-ring-offset-2 focus:ring-indigo-500">
                                    Créer l'étudiant
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>