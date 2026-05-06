@extends('layouts.app')

@section('title', 'Éditer un Médicament')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6"> Éditer le Médicament</h1>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('medicaments.update', $medicament->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Nom commercial</label>
            <input type="text" name="nom_commercial" value="{{ old('nom_commercial', $medicament->nom_commercial) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">DCI</label>
                <input type="text" name="dci" value="{{ old('dci', $medicament->dci) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Code CIP13</label>
                <input type="text" name="code_cip13" value="{{ old('code_cip13', $medicament->code_cip13) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Forme</label>
                <input type="text" name="forme" value="{{ old('forme', $medicament->forme) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Dosage</label>
                <input type="text" name="dosage" value="{{ old('dosage', $medicament->dosage) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Classe</label>
                <input type="text" name="classe" value="{{ old('classe', $medicament->classe) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Laboratoire</label>
                <input type="text" name="laboratoire" value="{{ old('laboratoire', $medicament->laboratoire) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Prix achat</label>
                <input type="number" step="0.01" name="prix_achat" value="{{ old('prix_achat', $medicament->prix_achat) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Prix vente</label>
                <input type="number" step="0.01" name="prix_vente" value="{{ old('prix_vente', $medicament->prix_vente) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
            <div>
                <label class="inline-flex items-center gap-2 mt-1">
                    <input type="checkbox" name="remboursable" value="1" {{ old('remboursable', $medicament->remboursable) ? 'checked' : '' }} class="rounded border-gray-300">
                    <span class="text-sm text-gray-700">Remboursable</span>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Taux remboursement (%)</label>
                <input type="number" step="0.01" name="taux_remboursement" value="{{ old('taux_remboursement', $medicament->taux_remboursement) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
        </div>

        <div class="flex items-center justify-between pt-4">
            <a href="{{ route('medicaments.index') }}" class="text-gray-600 hover:underline">← Retour</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
