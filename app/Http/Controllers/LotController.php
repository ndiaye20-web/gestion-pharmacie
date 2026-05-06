<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use App\Models\Medicament;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lots = Lot::with('medicament')->get();

        $expires = Lot::where('date_expiration', '<', Carbon::today())->get();

        $soon = Lot::whereBetween('date_expiration', [
            Carbon::today(),
            Carbon::today()->addMonths(3),
        ])->get();

        return view('lots.index', compact('lots', 'expires', 'soon'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicaments = Medicament::orderBy('nom_commercial')->get();
        return view('lots.create', compact('medicaments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'medicament_id' => 'required|exists:medicaments,id',
            'numero_lot' => 'required|string|max:255',
            'quantite' => 'required|integer|min:0',
            'date_expiration' => 'required|date',
        ]);

        Lot::create($data);

        return redirect()->route('lots.index')->with('success', 'Lot ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lot $lot)
    {
        return view('lots.show', compact('lot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lot $lot)
    {
        $medicaments = Medicament::orderBy('nom_commercial')->get();
        return view('lots.edit', compact('lot', 'medicaments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lot $lot)
    {
        $data = $request->validate([
            'medicament_id' => 'required|exists:medicaments,id',
            'numero_lot' => 'required|string|max:255',
            'quantite' => 'required|integer|min:0',
            'date_expiration' => 'required|date',
        ]);

        $lot->update($data);

        return redirect()->route('lots.index')->with('success', 'Lot mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lot $lot)
    {
        $lot->delete();
        return redirect()->route('lots.index')->with('success', 'Lot supprimé.');
    }
}
