<?php

namespace App\Http\Controllers;

use App\Models\CommandeFournisseur;
use App\Models\Fournisseur;
use App\Models\LigneCommande;
use App\Models\LigneVente;
use App\Models\Lot;
use App\Models\Medicament;
use App\Models\Patient;
use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventes = Vente::with('patient', 'pharmacien')
            ->latest()
            ->get();

        return view('ventes.index', compact('ventes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicaments = Medicament::orderBy('nom_commercial')->get();
        $patients = Patient::orderBy('nom')->orderBy('prenom')->get();

        return view('ventes.create', compact('medicaments', 'patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'mode_paiement' => 'nullable|string|max:50',
            'medicaments' => 'required|array',
            'medicaments.*' => 'nullable|integer|min:0',
        ]);

        $medicaments = array_filter($data['medicaments'] ?? [], fn ($q) => $q > 0);

        if (empty($medicaments)) {
            return back()->with('error', 'Veuillez sélectionner au moins une quantité supérieure à zéro.')->withInput();
        }

        $medicamentsData = Medicament::whereIn('id', array_keys($medicaments))
            ->get()
            ->keyBy('id');

        foreach ($medicaments as $id => $quantite) {
            $med = $medicamentsData->get($id);
            if (! $med) {
                return back()->with('error', 'Médicament invalide sélectionné.')->withInput();
            }

            $stockRestant = Lot::where('medicament_id', $id)->sum('quantite');
            if ($stockRestant < $quantite) {
                return back()
                    ->with('error', 'Stock insuffisant pour ' . $med->nom_commercial)
                    ->withInput();
            }
        }

        $selectedMeds = $medicaments;
        if (count($selectedMeds) > 1) {
            session()->flash('warning', 'Attention : vérifiez les interactions médicamenteuses pour cette combinaison.');
        }

        $vente = Vente::create([
            'patient_id' => $data['patient_id'] ?? null,
            'pharmacien_id' => Auth::id(),
            'mode_paiement' => $data['mode_paiement'] ?? 'Espèces',
            'ticket_numero' => 'TICKET-' . now()->format('YmdHis') . '-' . (Auth::id() ?? '0'),
            'date' => now(),
            'total' => 0,
        ]);

        $total = 0;

        foreach ($medicaments as $id => $quantite) {
            $med = $medicamentsData->get($id);
            $remaining = $quantite;

            while ($remaining > 0) {
                $lot = Lot::where('medicament_id', $id)
                    ->where('quantite', '>', 0)
                    ->orderBy('date_expiration', 'asc')
                    ->first();

                if (! $lot) {
                    return back()->with('error', 'Stock insuffisant pour ' . $med->nom_commercial)->withInput();
                }

                $quantityToTake = min($remaining, $lot->quantite);
                $lot->decrement('quantite', $quantityToTake);
                $remaining -= $quantityToTake;
            }

            LigneVente::create([
                'vente_id' => $vente->id,
                'medicament_id' => $id,
                'quantite' => $quantite,
                'prix' => $med->prix_vente,
            ]);

            $total += $quantite * $med->prix_vente;
        }

        $vente->update(['total' => $total]);

        $supplier = Fournisseur::first();
        if ($supplier) {
            $commande = null;
            $commandeTotal = 0;

            foreach ($medicaments as $id => $quantite) {
                $stockRestant = Lot::where('medicament_id', $id)->sum('quantite');
                if ($stockRestant < 10) {
                    if (! $commande) {
                        $commande = CommandeFournisseur::create([
                            'fournisseur_id' => $supplier->id,
                            'date_commande' => now(),
                            'statut' => 'en_attente',
                            'total' => 0,
                        ]);
                    }

                    $med = $medicamentsData->get($id);
                    $quantityToOrder = 50;
                    LigneCommande::create([
                        'commande_fournisseur_id' => $commande->id,
                        'medicament_id' => $id,
                        'quantite' => $quantityToOrder,
                        'prix_achat' => $med->prix_achat,
                    ]);

                    $commandeTotal += $quantityToOrder * $med->prix_achat;
                }
            }

            if ($commande) {
                $commande->update(['total' => $commandeTotal]);
            }
        }

        return redirect()->route('ventes.index')->with('success', 'Vente enregistrée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vente $vente)
    {
        $vente->load('ligneVentes.medicament', 'patient', 'pharmacien');

        return view('ventes.show', compact('vente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vente $vente)
    {
        $patients = Patient::orderBy('nom')->orderBy('prenom')->get();

        return view('ventes.edit', compact('vente', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vente $vente)
    {
        $data = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'mode_paiement' => 'nullable|string|max:50',
        ]);

        $vente->update([
            'patient_id' => $data['patient_id'] ?? null,
            'mode_paiement' => $data['mode_paiement'] ?? $vente->mode_paiement,
        ]);

        return redirect()->route('ventes.show', $vente->id)
                         ->with('success', 'Vente mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vente $vente)
    {
        $vente->delete();
        return redirect()->route('ventes.index')->with('success', 'Vente supprimée.');
    }
}
