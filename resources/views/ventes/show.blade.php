@extends('layouts.app')

@section('title', 'Détail de la vente')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900"> Vente #{{ $vente->id }}</h2>
            <p class="text-sm text-slate-500">Détail de la transaction et informations de ticket.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('ventes.edit', $vente) }}" class="inline-flex items-center rounded-2xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-200">Modifier</a>
            <a href="{{ route('tickets.pdf', $vente->id) }}" class="inline-flex items-center rounded-2xl bg-red-100 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-200">Télécharger PDF</a>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3 mb-6">
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-lg font-semibold text-slate-900 mb-3">Informations</h3>
            <div class="space-y-3 text-sm text-slate-700">
                <div><strong>Client :</strong> {{ $vente->patient->nom ?? 'Client anonyme' }} {{ $vente->patient->prenom ?? '' }}</div>
                <div><strong>Mode paiement :</strong> {{ $vente->mode_paiement ?? 'Non défini' }}</div>
                <div><strong>Pharmacien :</strong> {{ $vente->pharmacien->name ?? 'N/A' }}</div>
                <div><strong>Date :</strong> {{ optional($vente->date)->format('d/m/Y H:i') }}</div>
                <div><strong>Ticket :</strong> {{ $vente->ticket_numero ?? 'N/A' }}</div>
            </div>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 lg:col-span-2">
            <h3 class="text-lg font-semibold text-slate-900 mb-3">Lignes de vente</h3>
            @if($vente->ligneVentes->isEmpty())
                <p class="text-sm text-slate-500">Aucun article enregistré.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-100 text-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-left">Médicament</th>
                                <th class="px-4 py-3 text-left">Quantité</th>
                                <th class="px-4 py-3 text-left">Prix unitaire</th>
                                <th class="px-4 py-3 text-left">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($vente->ligneVentes as $ligne)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-4 text-slate-800">{{ $ligne->medicament->nom_commercial }}</td>
                                    <td class="px-4 py-4 text-slate-700">{{ $ligne->quantite }}</td>
                                    <td class="px-4 py-4 text-slate-700">{{ number_format($ligne->prix, 2, ',', ' ') }} FCFA</td>
                                    <td class="px-4 py-4 text-slate-800">{{ number_format($ligne->prix * $ligne->quantite, 2, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-right text-lg font-semibold text-slate-900">
        Total vente : {{ number_format($vente->total, 2, ',', ' ') }} FCFA
    </div>
</div>
