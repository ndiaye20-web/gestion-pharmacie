@extends('layouts.app')

@section('title', 'Ajouter un Médicament')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Ajouter un Médicament</h1>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('medicaments.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Nom commercial</label>
            <input type="text" name="nom_commercial" value="{{ old('nom_commercial') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">DCI</label>
                <input type="text" name="dci" value="{{ old('dci') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Code CIP13</label>
                <input type="text" name="code_cip13" value="{{ old('code_cip13') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Forme</label>
                <input type="text" name="forme" value="{{ old('forme') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Dosage</label>
                <input type="text" name="dosage" value="{{ old('dosage') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Classe</label>
                <input type="text" name="classe" value="{{ old('classe') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Laboratoire</label>
                <input type="text" name="laboratoire" value="{{ old('laboratoire') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Prix achat</label>
                <input type="number" step="0.01" name="prix_achat" value="{{ old('prix_achat') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Prix vente</label>
                <input type="number" step="0.01" name="prix_vente" value="{{ old('prix_vente') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
            <div>
                <label class="inline-flex items-center gap-2 mt-1">
                    <input type="checkbox" name="remboursable" value="1" {{ old('remboursable') ? 'checked' : '' }} class="rounded border-gray-300">
                    <span class="text-sm text-gray-700">Remboursable</span>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Taux remboursement (%)</label>
                <input type="number" step="0.01" name="taux_remboursement" value="{{ old('taux_remboursement') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm">
            </div>
        </div>

        <div class="flex items-center justify-between pt-4">
            <a href="{{ route('medicaments.index') }}" class="text-gray-600 hover:underline">← Retour</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
