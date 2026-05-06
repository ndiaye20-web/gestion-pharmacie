<?php

namespace App\Http\Controllers;

use App\Models\CommandeFournisseur;
use App\Models\Fournisseur;
use App\Models\LigneCommande;
use App\Models\Lot;
use App\Models\Medicament;
use Illuminate\Http\Request;

class CommandeFournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = CommandeFournisseur::with(['fournisseur', 'lignes.medicament'])
            ->orderBy('date_commande', 'desc')
            ->get();

        return view('commandes.index', compact('commandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fournisseurs = Fournisseur::orderBy('nom')->get();
        $medicaments = Medicament::orderBy('nom_commercial')->get();

        return view('commandes.create', compact('fournisseurs', 'medicaments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'medicaments' => 'required|array',
            'medicaments.*' => 'nullable|integer|min:0',
            'prix' => 'nullable|array',
            'prix.*' => 'nullable|numeric|min:0',
        ]);

        $commande = CommandeFournisseur::create([
            'fournisseur_id' => $validated['fournisseur_id'],
            'date_commande' => now(),
            'statut' => 'en_attente',
            'total' => 0,
        ]);

        $total = 0;
        $hasLines = false;

        foreach ($validated['medicaments'] as $id => $quantite) {
            if ($quantite > 0) {
                $hasLines = true;
                $prix = $validated['prix'][$id] ?? 0;

                LigneCommande::create([
                    'commande_fournisseur_id' => $commande->id,
                    'medicament_id' => $id,
                    'quantite' => $quantite,
                    'prix_achat' => $prix,
                ]);

                $total += $quantite * $prix;
            }
        }

        if (! $hasLines) {
            $commande->delete();
            return back()->with('error', 'Veuillez ajouter au moins un médicament à la commande.')->withInput();
        }

        $commande->update(['total' => $total]);

        return redirect()->route('commandes.index')
                         ->with('success', 'Commande créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CommandeFournisseur $commandeFournisseur)
    {
        $commandeFournisseur->load('fournisseur', 'lignes.medicament');

        return view('commandes.show', compact('commandeFournisseur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommandeFournisseur $commandeFournisseur)
    {
        $fournisseurs = Fournisseur::orderBy('nom')->get();
        $commandeFournisseur->load('lignes.medicament');

        return view('commandes.edit', compact('commandeFournisseur', 'fournisseurs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommandeFournisseur $commandeFournisseur)
    {
        $validated = $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'statut' => 'required|in:en_attente,reçue',
        ]);

        $commandeFournisseur->update($validated);

        return redirect()->route('commandes.show', $commandeFournisseur->id)
                         ->with('success', 'Commande mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommandeFournisseur $commandeFournisseur)
    {
        $commandeFournisseur->delete();

        return redirect()->route('commandes.index')
                         ->with('success', 'Commande supprimée.');
    }

    public function reception($id)
    {
        $commande = CommandeFournisseur::with('lignes.medicament')->findOrFail($id);

        if ($commande->statut === 'reçue') {
            return back()->with('error', 'Commande déjà reçue');
        }

        foreach ($commande->lignes as $ligne) {
            Lot::create([
                'medicament_id' => $ligne->medicament_id,
                'fournisseur_id' => $commande->fournisseur_id,
                'numero_lot' => 'LOT-' . strtoupper(uniqid()),
                'quantite' => $ligne->quantite,
                'date_expiration' => now()->addYear(),
                'date_fabrication' => now(),
                'statut' => 'disponible',
            ]);
        }

        $commande->update([
            'statut' => 'reçue',
            'date_reception' => now(),
        ]);

        return redirect()->route('commandes.index')
                         ->with('success', 'Commande reçue et stock mis à jour.');
    }
}
