@extends('layouts.app')

@section('title', 'Modifier l\'ordonnance')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6"> Modifier l'ordonnance</h1>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('ordonnances.update', $ordonnance->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Patient</label>
                <select name="patient_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id', $ordonnance->patient_id) == $patient->id ? 'selected' : '' }}>
                            {{ $patient->nom }} {{ $patient->prenom ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Médecin</label>
                <input type="text" name="medecin" value="{{ old('medecin', $ordonnance->medecin) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date de prescription</label>
                <input type="date" name="date_prescription" value="{{ old('date_prescription', $ordonnance->date_prescription->format('Y-m-d')) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Statut</label>
                <select name="statut" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                    <option value="en_attente" {{ old('statut', $ordonnance->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="traitee" {{ old('statut', $ordonnance->statut) == 'traitee' ? 'selected' : '' }}>Traité</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4">
            <a href="{{ route('ordonnances.show', $ordonnance->id) }}" class="text-gray-600 hover:underline">← Retour</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
