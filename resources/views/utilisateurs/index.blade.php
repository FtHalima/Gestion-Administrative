<x-app-layout>
    <slot name="header">
        <div class="flex items-center justify-between">
            <div class="space-y-1">
                <h2 class="font-semibold text-xl text-[#0F172A]">
                    Gestion des utilisateurs
                </h2>
                <p class="text-sm text-gray-500">
                    Gérez les comptes, les rôles et les accès du personnel administratif.
                </p>
            </div>
        </div>
    </slot>

    <div class="bg-[#F5F7FC] min-h-[calc(100vh-10rem)] p-6">
        <div class="mx-auto max-w-7xl">
            <!-- Card container -->
            <div class="bg-white border border-[#D5DBE8] rounded-xl shadow-sm">
                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('utilisateurs.create') }}" class="flex items-center space-x-2 bg-[#00236F] text-white rounded-lg font-medium hover:bg-[#1E3A8A] transition-colors px-4 py-2">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Nouvel utilisateur
                        </a>
                    </div>

                    <div class="overflow-auto">
                        <table class="min-w-full divide-y divide-[#D5DBE8]">
                            <thead class="bg-[#F8FAFC]">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                        Nom
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                        Prénom
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                        Rôle
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#64748B]">
                                        Statut
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-[#D5DBE8]">
                                @forelse ($utilisateurs as $utilisateur)
                                    <tr class="hover:bg-[#EFF6FF] transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#0F172A]">{{ $utilisateur->nom }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $utilisateur->prenom }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#64748B]">{{ $utilisateur->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $roleClass = match ($utilisateur->role) {
                                                    'administrateur' => 'bg-blue-50 text-blue-600',
                                                    'enseignant' => 'bg-indigo-50 text-indigo-600',
                                                    'agent' => 'bg-purple-50 text-purple-600',
                                                    default => 'bg-gray-50 text-gray-600',
                                                };
                                            @endphp
                                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $roleClass }}">{{ ucfirst($utilisateur->role) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $statusClass = $utilisateur->statut === 'actif' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800';
                                            @endphp
                                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ ucfirst($utilisateur->statut) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <!-- Modifier -->
                                            <a href="{{ route('utilisateurs.edit', $utilisateur) }}"
                                               class="text-[#00236F] hover:bg-[#EFF6FF] rounded-md px-2 py-1">
                                                Modifier
                                            </a>

                                            <!-- Supprimer -->
                                            <form action="{{ route('utilisateurs.destroy', $utilisateur) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:bg-red-50 rounded-md px-2 py-1"
                                                        onclick="return confirm('���Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                                    Supprimer
                                                </button>
                                            </form>

                                            <!-- Réinitialiser MDP -->
                                            <form action="{{ route('utilisateurs.reset-password', $utilisateur) }}" method="POST" class="d-inline ml-2">
                                                @csrf
                                                <button type="submit"
                                                        class="text-[#1E3A8A] hover:bg-[#EFF6FF] rounded-md px-2 py-1"
                                                        onclick="return confirm('Réinitialiser le mot de passe de cet utilisateur ?');">
                                                    Réinitialiser MDP
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-[#64748B]">
                                            <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3 3m0 0l3-3m-3 3V8m0 0a2 2 0 100-4 2 2 0 000 4zM5 13l3 3m0 0l3-3m-3 3V8m0 0a2 2 0 100-4 2 2 0 000 4z"/>
                                            </svg>
                                            Aucun utilisateur trouvé.
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