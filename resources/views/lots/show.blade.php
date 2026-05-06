@extends('layouts.app')

@section('title', 'Détail du lot')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">Détail du lot</h2>
            <p class="text-sm text-slate-500">Informations détaillées sur le lot sélectionné.</p>
        </div>
        <a href="{{ route('lots.edit', $lot) }}" class="inline-flex items-center rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Modifier le lot</a>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Données du lot</h3>
            <div class="space-y-3 text-sm text-slate-700">
                <div><strong>Médicament :</strong> {{ $lot->medicament->nom_commercial }}</div>
                <div><strong>Numéro de lot :</strong> {{ $lot->numero_lot }}</div>
                <div><strong>Quantité :</strong> {{ $lot->quantite }}</div>
                <div><strong>Expiration :</strong> {{ $lot->date_expiration->format('d/m/Y') }}</div>
                <div><strong>Statut :</strong> {{ ucfirst($lot->statut) }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
