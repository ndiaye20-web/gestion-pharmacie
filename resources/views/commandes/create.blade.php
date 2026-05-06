@extends('layouts.app')

@section('title', 'Nouvelle commande fournisseur')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-slate-900">Nouvelle commande fournisseur</h2>
        <p class="text-sm text-slate-500">Sélectionnez un fournisseur et indiquez les médicaments à commander.</p>
    </div>

    <form method="POST" action="{{ route('commandes.store') }}" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700">Fournisseur</label>
            <select name="fournisseur_id" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200" required>
                <option value="" disabled {{ old('fournisseur_id') ? '' : 'selected' }}>-- Sélectionnez un fournisseur --</option>
                @foreach($fournisseurs as $f)
                    <option value="{{ $f->id }}" {{ old('fournisseur_id') == $f->id ? 'selected' : '' }}>{{ $f->nom }}</option>
                @endforeach
            </select>
            @error('fournisseur_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-slate-900">Médicaments</h3>
            @foreach($medicaments as $med)
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm">
                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="font-semibold text-slate-900">{{ $med->nom_commercial }}</div>
                            <div class="text-sm text-slate-500">{{ $med->forme }} - {{ $med->dosage }}</div>
                        </div>
                        <div class="grid w-full gap-3 md:w-auto md:grid-cols-2">
                            <label class="block text-sm font-medium text-slate-700">Quantité</label>
                            <input type="number" name="medicaments[{{ $med->id }}]" value="{{ old('medicaments.'.$med->id, 0) }}" min="0" class="rounded-2xl border border-slate-200 bg-white px-3 py-2 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                            <label class="block text-sm font-medium text-slate-700">Prix d'achat</label>
                            <input type="number" step="0.01" name="prix[{{ $med->id }}]" value="{{ old('prix.'.$med->id) }}" placeholder="0.00" class="rounded-2xl border border-slate-200 bg-white px-3 py-2 focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                        </div>
                    </div>
                </div>
            @endforeach
            @error('medicaments')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between gap-4 pt-3">
            <a href="{{ route('commandes.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">← Retour à la liste</a>
            <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Créer la commande</button>
        </div>
    </form>
</div>
@endsection
