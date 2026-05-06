@extends('layouts.app')

@section('title', 'Nouvelle Ordonnance')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Nouvelle ordonnance</h1>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('ordonnances.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Patient</label>
                <select name="patient_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                    <option value="">Sélectionner un patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->nom }} {{ $patient->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Médecin</label>
                <input type="text" name="medecin" value="{{ old('medecin') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Date de prescription</label>
            <input type="date" name="date_prescription" value="{{ old('date_prescription', now()->format('Y-m-d')) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Médicaments</h2>
            <div class="space-y-4">
                @foreach($medicaments as $med)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end border-b border-gray-200 pb-4">
                        <div>
                            <p class="font-medium text-gray-800">{{ $med->nom_commercial }}</p>
                            <p class="text-sm text-gray-500">{{ $med->forme }} - {{ $med->dosage }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantité</label>
                            <input type="number" min="0" name="medicaments[{{ $med->id }}]" value="{{ old('medicaments.' . $med->id, 0) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Posologie</label>
                            <input type="text" name="posologie[{{ $med->id }}]" value="{{ old('posologie.' . $med->id) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between pt-4">
            <a href="{{ route('ordonnances.index') }}" class="text-gray-600 hover:underline">← Retour</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
