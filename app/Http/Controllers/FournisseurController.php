<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    /**
     * Afficher la liste des fournisseurs
     */
    public function index()
    {
        $fournisseurs = Fournisseur::latest()->get();
        return view('fournisseurs.index', compact('fournisseurs'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('fournisseurs.create');
    }

    /**
     * Enregistrer un fournisseur
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'adresse' => 'nullable|string|max:255',
        ]);

        Fournisseur::create([
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'adresse' => $request->adresse,
        ]);

        return redirect()->route('fournisseurs.index')
                         ->with('success', 'Fournisseur ajouté avec succès');
    }

    /**
     * Afficher un fournisseur (optionnel)
     */
    public function show(Fournisseur $fournisseur)
    {
        return view('fournisseurs.show', compact('fournisseur'));
    }

    /**
     * Formulaire de modification
     */
    public function edit(Fournisseur $fournisseur)
    {
        return view('fournisseurs.edit', compact('fournisseur'));
    }

    /**
     * Mettre à jour
     */
    public function update(Request $request, Fournisseur $fournisseur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'adresse' => 'nullable|string|max:255',
        ]);

        $fournisseur->update([
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'adresse' => $request->adresse,
        ]);

        return redirect()->route('fournisseurs.index')
                         ->with('success', 'Fournisseur modifié avec succès');
    }

    /**
     * Supprimer
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();

        return redirect()->route('fournisseurs.index')
                         ->with('success', 'Fournisseur supprimé');
    }
}
