<?php

namespace App\Http\Controllers;

use App\Models\Medicament;
use Illuminate\Http\Request;

class MedicamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicaments = Medicament::all();
        return view('medicaments.index', compact('medicaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_commercial' => 'required|string|max:255',
            'dci' => 'nullable|string|max:255',
            'code_cip13' => 'required|string|max:255|unique:medicaments,code_cip13',
            'forme' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'classe' => 'nullable|string|max:255',
            'laboratoire' => 'nullable|string|max:255',
            'remboursable' => 'boolean',
            'taux_remboursement' => 'nullable|numeric|min:0|max:100',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
        ]);

        $data['remboursable'] = isset($data['remboursable']) && $data['remboursable'];

        Medicament::create($data);

        return redirect()->route('medicaments.index')->with('success', 'Médicament ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicament $medicament)
    {
        return view('medicaments.show', compact('medicament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicament $medicament)
    {
        return view('medicaments.edit', compact('medicament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicament $medicament)
    {
        $data = $request->validate([
            'nom_commercial' => 'required|string|max:255',
            'dci' => 'nullable|string|max:255',
            'code_cip13' => 'required|string|max:255|unique:medicaments,code_cip13,' . $medicament->id,
            'forme' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'classe' => 'nullable|string|max:255',
            'laboratoire' => 'nullable|string|max:255',
            'remboursable' => 'boolean',
            'taux_remboursement' => 'nullable|numeric|min:0|max:100',
            'prix_achat' => 'required|numeric|min:0',
            'prix_vente' => 'required|numeric|min:0',
        ]);

        $data['remboursable'] = isset($data['remboursable']) && $data['remboursable'];

        $medicament->update($data);

        return redirect()->route('medicaments.index')->with('success', 'Médicament mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicament $medicament)
    {
        $medicament->delete();

        return redirect()->route('medicaments.index')->with('success', 'Médicament supprimé.');
    }
}
