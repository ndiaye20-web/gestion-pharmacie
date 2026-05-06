@extends('layouts.app')

@section('title', 'Ajouter un Lot')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Ajouter un lot</h1>

    <form method="POST" action="{{ route('lots.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Médicament</label>
            <select name="medicament_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                @foreach($medicaments as $med)
                    <option value="{{ $med->id }}">{{ $med->nom_commercial }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Numéro lot</label>
            <input type="text" name="numero_lot" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Quantité</label>
            <input type="number" name="quantite" min="0" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Date expiration</label>
            <input type="date" name="date_expiration" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        </div>

        <div class="flex items-center justify-between pt-4">
            <a href="{{ route('lots.index') }}" class="text-gray-600 hover:underline">← Retour</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">Ajouter</button>
        </div>
    </form>
</div>
@endsection
