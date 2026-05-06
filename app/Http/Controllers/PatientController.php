<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::orderBy('nom')->orderBy('prenom')->get();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'numero_secu' => 'nullable|string|max:25',
            'mutuelle' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
            'historique' => 'nullable|string',
        ]);

        Patient::create($data);

        return redirect()->route('patients.index')
                         ->with('success', 'Patient ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        $patient->load('ordonnances', 'ventes');
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'numero_secu' => 'nullable|string|max:25',
            'mutuelle' => 'nullable|string|max:255',
            'allergies' => 'nullable|string',
            'historique' => 'nullable|string',
        ]);

        $patient->update($data);

        return redirect()->route('patients.index')
                         ->with('success', 'Patient mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
                         ->with('success', 'Patient supprimé.');
    }
}
