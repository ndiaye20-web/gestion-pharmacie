@extends('layouts.app')

@section('title', 'Détails de l\'ordonnance')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-lg shadow px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Détails de l'ordonnance</h1>

    <div class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Patient</p>
                <p class="text-lg font-medium text-gray-800">{{ $ordonnance->patient->nom }} {{ $ordonnance->patient->prenom ?? '' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Médecin</p>
                <p class="text-lg font-medium text-gray-800">{{ $ordonnance->medecin }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Date de prescription</p>
                <p class="text-lg font-medium text-gray-800">{{ $ordonnance->date_prescription->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut</p>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium {{ $ordonnance->statut === 'traitee' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($ordonnance->statut) }}
                </span>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">Médicaments</h2>
            <div class="space-y-3">
                @foreach($ordonnance->lignes as $ligne)
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <p class="font-semibold text-gray-800">{{ $ligne->medicament->nom_commercial }}</p>
                        <p class="text-sm text-gray-600">Quantité: {{ $ligne->quantite }}</p>
                        <p class="text-sm text-gray-600">Posologie: {{ $ligne->posologie ?? 'Aucune' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-between pt-6">
            <a href="{{ route('ordonnances.index') }}" class="text-gray-600 hover:underline">← Retour</a>
            <div class="space-x-2">
                <a href="{{ route('ordonnances.edit', $ordonnance->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">Éditer</a>
                <a href="{{ route('ordonnances.vente', $ordonnance->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Transformer en vente</a>
            </div>
        </div>
    </div>
</div>
@endsection
