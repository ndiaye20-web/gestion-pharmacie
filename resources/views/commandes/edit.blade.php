@extends('layouts.app')

@section('title', 'Modifier la commande')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-slate-900"> Modifier la commande</h2>
        <p class="text-sm text-slate-500">Ajustez le fournisseur ou le statut avant réception.</p>
    </div>

    <form method="POST" action="{{ route('commandes.update', ['commande' => $commandeFournisseur->id]) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700">Fournisseur</label>
            <select name="fournisseur_id" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200" required>
                @foreach($fournisseurs as $fournisseur)
                    <option value="{{ $fournisseur->id }}" {{ $commandeFournisseur->fournisseur_id === $fournisseur->id ? 'selected' : '' }}>{{ $fournisseur->nom }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Statut</label>
            <select name="statut" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200" required>
                <option value="en_attente" {{ $commandeFournisseur->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="reçue" {{ $commandeFournisseur->statut === 'reçue' ? 'selected' : '' }}>Reçue</option>
            </select>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Lignes de commande</h3>
            <ul class="space-y-3 text-sm text-slate-700">
                @foreach($commandeFournisseur->lignes as $ligne)
                    <li class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <span>{{ $ligne->medicament->nom_commercial }}</span>
                            <span class="text-slate-500">{{ $ligne->quantite }} unité(s)</span>
                        </div>
                        <div class="text-slate-600">Prix achat: {{ number_format($ligne->prix_achat, 2, ',', ' ') }} FCFA</div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="flex items-center justify-between gap-4 pt-3">
            <a href="{{ route('commandes.show', $commandeFournisseur) }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">← Retour au détail</a>
            <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
