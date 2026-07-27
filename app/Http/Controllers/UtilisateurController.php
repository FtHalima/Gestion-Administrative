<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utilisateurs = Utilisateur::all();
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('utilisateurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:utilisateurs,email'],
            'mot_de_passe' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:administration,enseignant'],
            'statut' => ['sometimes', 'in:actif,inactif'],
        ]);

        Utilisateur::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'mot_de_passe' => Hash::make($validated['mot_de_passe']),
            'role' => $validated['role'],
            'statut' => $validated['statut'] ?? 'actif',
            'telephone' => $request->input('telephone', null),
        ]);

        return redirect()->route('utilisateurs.index')
                        ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Utilisateur $utilisateur)
    {
        return view('utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilisateur $utilisateur)
    {
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Utilisateur $utilisateur)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:utilisateurs,email,'.$utilisateur->id],
            'role' => ['required', 'in:administration,enseignant'],
            'statut' => ['sometimes', 'in:actif,inactif'],
            // password optional for update
        ]);

        $utilisateur->update([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'statut' => $validated['statut'] ?? $utilisateur->statut,
            'telephone' => $request->input('telephone', $utilisateur->telephone),
        ]);

        // If password is provided, update it
        if ($request->filled('mot_de_passe')) {
            $request->validate([
                'mot_de_passe' => ['required', 'confirmed', Password::defaults()],
            ]);
            $utilisateur->update([
                'mot_de_passe' => Hash::make($request->mot_de_passe),
            ]);
        }

        return redirect()->route('utilisateurs.index')
                        ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')
                        ->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Reset password for the specified user.
     */
    public function resetPassword(Utilisateur $utilisateur)
    {
        // Generate a temporary password
        $plainPassword = Str::random(8);
        $hashed = Hash::make($plainPassword);

        $utilisateur->update(['mot_de_passe' => $hashed]);

        // In a real app, you would email this password to the user.
        // For now, we’ll flash it to the session so we can display it once.
        return redirect()->route('utilisateurs.index')
                        ->with('reset_password', "Mot de passe temporaire pour {$utilisateur->email} : {$plainPassword}");
    }
}