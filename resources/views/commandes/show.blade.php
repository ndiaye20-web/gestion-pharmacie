@extends('layouts.app')

@section('title', 'Détail de la commande')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">Commande #{{ $commandeFournisseur->id }}</h2>
            <p class="text-sm text-slate-500">Détails du fournisseur, des lignes et du statut de réception.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('commandes.edit', $commandeFournisseur) }}" class="inline-flex items-center rounded-2xl bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-700 hover:bg-amber-200">Modifier</a>
            @if($commandeFournisseur->statut !== 'reçue')
                <a href="{{ route('commandes.reception', $commandeFournisseur->id) }}" class="inline-flex items-center rounded-2xl bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-200">Réceptionner</a>
            @endif
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2 mb-6">
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Fournisseur</h3>
            <p class="text-sm text-slate-700">{{ $commandeFournisseur->fournisseur->nom }}</p>
            <p class="text-sm text-slate-500">Commande du {{ optional($commandeFournisseur->date_commande)->format('d/m/Y') }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Résumé</h3>
            <div class="space-y-3 text-sm text-slate-700">
                <div><strong>Statut :</strong> {{ ucfirst($commandeFournisseur->statut) }}</div>
                <div><strong>Total estimé :</strong> {{ number_format($commandeFournisseur->total ?? 0, 0, ',', ' ') }} FCFA</div>
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-900 mb-4">Lignes de commande</h3>
        @if($commandeFournisseur->lignes->isEmpty())
            <p class="text-sm text-slate-500">Aucune ligne enregistrée.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Médicament</th>
                            <th class="px-4 py-3 text-left">Quantité</th>
                            <th class="px-4 py-3 text-left">Prix achat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($commandeFournisseur->lignes as $ligne)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-4 text-slate-800">{{ $ligne->medicament->nom_commercial }}</td>
                                <td class="px-4 py-4 text-slate-700">{{ $ligne->quantite }}</td>
                                <td class="px-4 py-4 text-slate-700">{{ number_format($ligne->prix_achat, 0, ',', ' ') }} FCFA</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
