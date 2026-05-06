<?php

namespace App\Http\Controllers;

use App\Models\LigneOrdonnance;
use App\Models\Lot;
use App\Models\Medicament;
use App\Models\Ordonnance;
use App\Models\Patient;
use App\Models\Vente;
use App\Models\LigneVente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdonnanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ordonnances = Ordonnance::with('patient')
            ->orderByDesc('date_prescription')
            ->get();

        return view('ordonnances.index', compact('ordonnances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::all();
        $medicaments = Medicament::all();

        return view('ordonnances.create', compact('patients', 'medicaments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin' => 'required|string|max:255',
            'date_prescription' => 'required|date',
            'medicaments' => 'nullable|array',
            'medicaments.*' => 'nullable|integer|min:0',
            'posologie' => 'nullable|array',
            'posologie.*' => 'nullable|string|max:255',
        ]);

        $ordonnance = Ordonnance::create([
            'patient_id' => $data['patient_id'],
            'medecin' => $data['medecin'],
            'date_prescription' => $data['date_prescription'],
        ]);

        $medicaments = $data['medicaments'] ?? [];
        $posologies = $data['posologie'] ?? [];
        $added = false;

        foreach ($medicaments as $id => $quantite) {
            if ($quantite > 0) {
                LigneOrdonnance::create([
                    'ordonnance_id' => $ordonnance->id,
                    'medicament_id' => $id,
                    'quantite' => $quantite,
                    'posologie' => $posologies[$id] ?? null,
                ]);
                $added = true;
            }
        }

        if (! $added) {
            $ordonnance->delete();
            return back()->withInput()->with('error', 'Veuillez ajouter au moins un médicament avec une quantité supérieure à 0.');
        }

        return redirect()->route('ordonnances.index')->with('success', 'Ordonnance enregistrée.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ordonnance $ordonnance)
    {
        $ordonnance->load('patient', 'lignes.medicament');
        return view('ordonnances.show', compact('ordonnance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ordonnance $ordonnance)
    {
        $patients = Patient::all();
        $medicaments = Medicament::all();
        $ordonnance->load('lignes.medicament');

        return view('ordonnances.edit', compact('ordonnance', 'patients', 'medicaments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ordonnance $ordonnance)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin' => 'required|string|max:255',
            'date_prescription' => 'required|date',
            'statut' => 'required|in:en_attente,traitee',
        ]);

        $ordonnance->update($data);

        return redirect()->route('ordonnances.show', $ordonnance->id)->with('success', 'Ordonnance mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ordonnance $ordonnance)
    {
        $ordonnance->delete();

        return redirect()->route('ordonnances.index')->with('success', 'Ordonnance supprimée.');
    }

    public function transformer($id)
    {
        $ordonnance = Ordonnance::with('lignes.medicament')->findOrFail($id);

        if ($ordonnance->statut !== 'en_attente') {
            return back()->with('error', 'Ordonnance déjà utilisée.');
        }

        $medicaments = $ordonnance->lignes;
        foreach ($medicaments as $ligne) {
            $stockRestant = Lot::where('medicament_id', $ligne->medicament_id)->sum('quantite');
            if ($stockRestant < $ligne->quantite) {
                return back()->with('error', 'Stock insuffisant pour ' . $ligne->medicament->nom_commercial);
            }
        }

        DB::transaction(function () use ($ordonnance, $medicaments) {
            $vente = Vente::create([
                'patient_id' => $ordonnance->patient_id,
                'pharmacien_id' => auth()->id(),
                'mode_paiement' => 'Espèces',
                'ticket_numero' => 'TICKET-' . now()->format('YmdHis') . '-' . (auth()->id() ?? '0'),
                'date' => now(),
                'total' => 0,
            ]);

            $total = 0;
            foreach ($medicaments as $ligne) {
                $quantiteRestante = $ligne->quantite;
                while ($quantiteRestante > 0) {
                    $lot = Lot::where('medicament_id', $ligne->medicament_id)
                        ->where('quantite', '>', 0)
                        ->orderBy('date_expiration', 'asc')
                        ->first();

                    if (! $lot) {
                        throw new \Exception('Stock insuffisant pour ' . $ligne->medicament->nom_commercial);
                    }

                    $take = min($quantiteRestante, $lot->quantite);
                    $lot->decrement('quantite', $take);
                    $quantiteRestante -= $take;
                }

                LigneVente::create([
                    'vente_id' => $vente->id,
                    'medicament_id' => $ligne->medicament_id,
                    'quantite' => $ligne->quantite,
                    'prix' => $ligne->medicament->prix_vente,
                ]);

                $total += $ligne->quantite * $ligne->medicament->prix_vente;
            }

            $vente->update(['total' => $total]);
            $ordonnance->update(['statut' => 'traitee']);
        });

        return redirect()->route('ventes.index')->with('success', 'Ordonnance transformée en vente.');
    }
}
