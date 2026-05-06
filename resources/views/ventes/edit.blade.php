@extends('layouts.app')

@section('title', 'Modifier la vente')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-slate-900"> Modifier la vente</h2>
        <p class="text-sm text-slate-500">Ajustez le client ou le mode de paiement de la transaction.</p>
    </div>

    <form method="POST" action="{{ route('ventes.update', $vente) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-700">Client</label>
                <select name="patient_id" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    <option value="">Client anonyme</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ optional($vente->patient)->id === $patient->id ? 'selected' : '' }}>{{ $patient->nom }} {{ $patient->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Mode de paiement</label>
                <input type="text" name="mode_paiement" value="{{ old('mode_paiement', $vente->mode_paiement) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
            </div>
        </div>

        <div class="flex items-center justify-between gap-4 pt-3">
            <a href="{{ route('ventes.show', $vente) }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">← Retour au détail</a>
            <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Enregistrer</button>
        </div>
    </form>
</div>
