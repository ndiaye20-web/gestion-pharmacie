@extends('layouts.app')

@section('title', 'Nouvelle vente')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-slate-900">Nouvelle vente</h2>
        <p class="text-sm text-slate-500">Sélectionnez les médicaments, le client et le mode de paiement.</p>
    </div>

    @if(session('error'))
        <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-700 mb-6">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('ventes.store') }}" class="space-y-6">
        @csrf

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-700">Client (optionnel)</label>
                <select name="patient_id" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    <option value="">Client ponctuel</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->nom }} {{ $patient->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Mode de paiement</label>
                <input type="text" name="mode_paiement" value="Espèces" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($medicaments as $med)
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $med->nom_commercial }}</p>
                            <p class="text-sm text-slate-500">{{ $med->forme }} · {{ $med->dosage }}</p>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ number_format($med->prix_vente, 2, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700">Quantité</label>
                        <input type="number" min="0" name="medicaments[{{ $med->id }}]" value="0" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-between gap-4 pt-3">
            <a href="{{ route('ventes.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">← Retour à l’historique</a>
            <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Valider la vente</button>
        </div>
    </form>
</div>
@endsection
