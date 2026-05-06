@extends('layouts.app')

@section('title', 'Détails du Médicament')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-lg shadow px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Détails du Médicament</h1>

    <div class="space-y-4 text-gray-700">
        <p><strong>Nom commercial:</strong> {{ $medicament->nom_commercial }}</p>
        <p><strong>DCI:</strong> {{ $medicament->dci ?? 'N/A' }}</p>
        <p><strong>Code CIP13:</strong> {{ $medicament->code_cip13 }}</p>
        <p><strong>Forme:</strong> {{ $medicament->forme }}</p>
        <p><strong>Dosage:</strong> {{ $medicament->dosage }}</p>
        <p><strong>Classe:</strong> {{ $medicament->classe ?? 'N/A' }}</p>
        <p><strong>Laboratoire:</strong> {{ $medicament->laboratoire ?? 'N/A' }}</p>
        <p><strong>Remboursable:</strong> {{ $medicament->remboursable ? 'Oui' : 'Non' }}</p>
        <p><strong>Taux de remboursement:</strong> {{ $medicament->taux_remboursement ?? 'N/A' }}%</p>
        <p><strong>Prix d'achat:</strong> {{ number_format($medicament->prix_achat, 2, ',', ' ') }} FCFA</p>
        <p><strong>Prix de vente:</strong> {{ number_format($medicament->prix_vente, 2, ',', ' ') }} FCFA</p>
    </div>

    <div class="mt-8 flex items-center justify-between">
        <a href="{{ route('medicaments.index') }}" class="text-gray-600 hover:underline">← Retour</a>
        <a href="{{ route('medicaments.edit', $medicament->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">Éditer</a>
    </div>
</div>
@endsection
