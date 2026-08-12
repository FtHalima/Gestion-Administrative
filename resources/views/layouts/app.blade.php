<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased flex overflow-x-hidden">
        <!-- Sidebar -->
        <aside class="fixed left-0 top-0 bottom-0 w-64 bg-[#00236F] text-white z-20">
            <div class="flex flex-col h-full px-3 pt-4">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-6">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9l3-3m0 0l3 3m-3-3v8m0-4a2 2 0 100-4 2 2 0 000 4zm-4 8a2 2 0 100-4 2 2 0 000 4zm8 0a2 2 0 100-4 2 2 0 000 4z" />
                    </svg>
                    <h1 class="text-lg font-semibold text-white">Système de gestion académique</h1>
                </div>
                <!-- Navigation -->
                <nav class="mt-2 space-y-1 flex-1">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('dashboard') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h10a2 2 0 012 2v9a2 2 0 01-2 2H3a2 2 0 012-2v-9a2 2 0 012-2zm0 0v9a2 2 0 002 2h10a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        Tableau de bord
                    </a>

                    <!-- Administration-only links: Utilisateurs, Étudiants -->
                    @auth
                        @if (auth()->user()->role === 'administration')
                            <!-- Utilisateurs -->
                            <a href="{{ route('utilisateurs.index') }}"
                               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('utilisateurs.index') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4a2 2 0 012 2v4a2 2 0 01-2 2H5a2 2 0 012-2h11zm0 0h-1a4 3 0 00-5 3v1a1 1 0 001 2h1a1 1 0 011 1v2a1 1 0 01-1 1H6a1 1 0 00-1 1v2a1 1 0 011 1h1a1 1 0 001-1v-1a3 3 0 013-3h11z" />
                                </svg>
                                Utilisateurs
                            </a>

                            <!-- Étudiants -->
                            <a href="{{ route('etudiants.index') }}"
                               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('etudiants.index') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5S10.5 3.17 10.5 4v1.18C7.64 4.36 6 6.93 6 10v5a2 2 0 002 2h6z" />
                                </svg>
                                Étudiants
                            </a>
                        @endif
                    @endauth

                    <!-- Common links (visible to all authenticated users) -->
                    <a href="{{ route('note-examens.index') }}"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('note-examens.index') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a3 3 0 100-6m-6 6a3 3 0 100-6m6 6a3 3 0 100-6" />
                        </svg>
                        Notes d'examens
                    </a>

                    <a href="{{ route('note-modules.index') }}"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('note-modules.index') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a3 3 0 100-6m-6 6a3 3 0 100-6m6 6a3 3 0 100-6" />
                        </svg>
                        Notes de modules
                    </a>

                    <a href="{{ route('note-semestres.index') }}"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('note-semestres.index') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                        Notes de semestres
                    </a>

                    <a href="{{ route('note-stages.index') }}"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('note-stages.index') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                        Notes de stage
                    </a>

                    <a href="{{ route('note-memoires.index') }}"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('note-memoires.index') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                        Notes de mémoires
                    </a>

                    

                    <!-- Imprimer les rapports -->
                    <a href="{{ route('rapports.index') }}"
                       class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('rapports.index') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H5a2 2 0 00-2 2v4a2 2 0 002 2h4l2 2h2l2-2h2a2 2 0 002-2V7a2 2 0 002-2V5z" />
                        </svg>
                        Imprimer les rapports
                    </a>

                    <!-- Administration-only link: Paramètres (placed at the end) -->
                    @auth
                        @if (auth()->user()->role === 'administration')
                            <a href="{{ route('parametres.index') }}"
                               class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-white/10 hover:text-white transition-colors text-[#B6C4FF] {{ request()->routeIs('parametres.index') ? 'bg-[rgba(30,58,138,0.2)] border-l-4 border-white text-white font-bold' : '' }}">
                                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                                </svg>
                                Paramètres
                            </a>
                        @endif
                    @endauth
                </nav>

                <!-- Bottom section: user info and logout -->
                <div class="mt-auto pt-4 pb-2">
                    <!-- User info -->
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-full bg-white/20 flex items-center justify-center text-sm font-semibold flex-shrink-0">
                            {{ strtoupper(substr(Auth::user()->prenom, 0, 1) . substr(Auth::user()->nom, 0, 1)) }}
                        </div>
                        <div class="space-y-1 overflow-hidden">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
                            <p class="text-xs text-white/75 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-3 py-2 rounded-md text-sm font-medium text-white/75 hover:bg-white/10 hover:text-white transition-colors"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m12 0v4a2 2 0 01-2 2H5a2 2 0 012-2h10a2 2 0 012 2v4z" />
                            </svg>
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="ml-64 min-h-screen bg-gray-100 flex flex-col min-w-0">
            <!-- Header (white bar) -->
            <header class="bg-white shadow">
                <div class="w-full px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                    <!-- Title from slot -->
                    @isset($header)
                    <div class="flex items-center space-x-4">
                        {{ $header }}
                    </div>
                    @else
                    <div class="flex items-center space-x-4">
                        <h2 class="text-[#00236F] text-xl font-bold">Gestion administrative</h2>
                    </div>
                    @endisset
                    <!-- Right side: search, notifications, settings, avatar -->
                    <div class="flex items-center space-x-4">
                        <!-- Search (visual only) -->
                        <div class="relative w-32">
                            <input type="search"
                                   placeholder="Rechercher..."
                                   class="pl-8 pr-2 py-1 bg-[#EFF4FF] border-[#C5C5D3] rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            <svg class="absolute left-2 top-1/2 -mt-1.5 h-4 w-4 text-gray-400"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 105.636 18.364m12.728-5.636a4.5 4.5 0 01-6.364 6.364" />
                            </svg>
                        </div>

                        <!-- Notification bell -->
                        <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>

                        <!-- Settings gear -->
                        <svg class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        </svg>

                        <!-- Avatar with initials -->
                        <div class="h-8 w-8 rounded-xl bg-[#1E3A8A] text-white flex items-center justify-center text-xs font-semibold">
                            {{ strtoupper(substr(Auth::user()->prenom, 0, 1) . substr(Auth::user()->nom, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>