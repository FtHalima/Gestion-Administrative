<?php $fullWidth = true; ?>
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="min-h-screen flex">
        <!-- Left side -->
        <div class="hidden sm:block sm:w-1/2 relative min-h-screen flex items-center justify-center">
            <!-- Blurred blue background -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#06327d] to-[#0a4d9c] blur-sm"></div>
            <!-- Logo (centered, not blurred) -->
            <img src="{{ asset('images/logo.png') }}" alt="Logo de l'institution" class="relative z-10 max-w-[360px] max-h-[360px] object-contain" />
        </div>

        <!-- Right side -->
        <div class="sm:w-1/2 w-full flex items-center justify-center bg-white">
            <div class="w-full max-w-[500px] space-y-6">
                <!-- Icon and title -->
                <div class="flex items-center mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-md bg-[#06327d] text-white">
                        <!-- Graduation cap icon (Heroicons) -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 15v2m-3-3h6m3-10H6a2 2 0 00-2 2v4a2 2 0 002 2h10a2 2 0 002-2V4a2 2 0 00-2-2h-3zM9 15l3-3m0 0l3 3m-3 3H6a2 2 0 01-2-2V5a2 2 0 012-2h8a2 2 0 012 2v5a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h2 class="text-3xl font-semibold text-[#06327d]">Gestion administrative</h2>
                        <p class="text-lg text-gray-500">Système de gestion du service de la scolarité</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-base font-medium text-gray-700 mb-1 uppercase">IDENTIFIANT</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <!-- User icon -->
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Email ou Nom d'utilisateur">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <div class="flex justify-between items-baseline mb-1">
                            <label for="password" class="block text-base font-medium text-gray-700 uppercase">MOT DE PASSE</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="underline text-sm text-gray-600 hover:text-gray-900">{{ __('Forgot your password?') }}</a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <!-- Lock icon -->
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-4-4h-4a4 4 0 00-4 4v3z" />
                                </svg>
                            </div>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none" id="toggle-password">
                                <!-- Eye icon (will be toggled via JS) -->
                                <svg class="h-4 w-4 text-gray-400" id="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg class="h-4 w-4 text-gray-400 hidden" id="eye-slash" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0012 19c-4.478 0-8.268-2.955-9.543-7a9.97 9.97 0 011.563-3.029m5.858.121a2.06 2.06 0 012.142-2.142c.95-.454 2.224-.352 3.25.048.954.355.66 1.072.08 1.572-.37.315-.78.533-1.03.738M14.25 6.375c-.333 1.414-1.087 2.59-2.107 3.453A10.05 10.05 0 0012 19c4.478 0 8.268 2.955 9.543-7a9.96 9.96 0 00-2.107-3.452z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Mot de passe">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full inline-flex items-center px-4 py-3 bg-[#06327d] text-white font-lg rounded-md shadow-sm hover:bg-[#0a4d9c] focus:outline-none focus:ring-2 focus:ring-offset-2 focus-ring-indigo-500 transition-colors">
                            Se connecter
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Info under button -->
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <div class="h-0.5 flex-1 bg-gray-200"></div>
                        <svg class="h-4 w-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Accès réservé au personnel administratif autorisé. Toute utilisation non autorisée sera signalée et poursuivie.</span>
                    </div>

                    <!-- Support text -->
                    <p class="mt-4 text-center text-base text-gray-500">
                        Besoin d'aide ? Contacter le support IT
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>