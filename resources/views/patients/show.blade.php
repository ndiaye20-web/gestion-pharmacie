@extends('layouts.app')

@section('title', 'Fiche patient')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">Fiche patient</h2>
            <p class="text-sm text-slate-500">Informations et historique du patient.</p>
        </div>
        <a href="{{ route('patients.edit', $patient) }}" class="inline-flex items-center rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Modifier</a>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Détails</h3>
            <div class="space-y-3 text-sm text-slate-700">
                <div><strong>Nom :</strong> {{ $patient->nom }}</div>
                <div><strong>Prénom :</strong> {{ $patient->prenom }}</div>
                <div><strong>Téléphone :</strong> {{ $patient->telephone ?? 'Non renseigné' }}</div>
                <div><strong>Date de naissance :</strong> {{ optional($patient->date_naissance)->format('d/m/Y') ?? 'Non renseignée' }}</div>
                <div><strong>Numéro de sécu :</strong> {{ $patient->numero_secu ?? 'Non renseigné' }}</div>
                <div><strong>Mutuelle :</strong> {{ $patient->mutuelle ?? 'Non renseigné' }}</div>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Santé</h3>
            <div class="space-y-3 text-sm text-slate-700">
                <div><strong>Allergies :</strong> {{ $patient->allergies ?? 'Aucune' }}</div>
                <div><strong>Historique :</strong> {{ $patient->historique ?? 'Aucun historique' }}</div>
            </div>
        </div>
    </div>

    <div class="mt-8 grid gap-4 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Ordonnances</h3>
            @if($patient->ordonnances->isEmpty())
                <p class="text-sm text-slate-500">Aucune ordonnance enregistrée.</p>
            @else
                <ul class="space-y-3 text-sm text-slate-700">
                    @foreach($patient->ordonnances as $ordonnance)
                        <li class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="flex items-center justify-between gap-2">
                                <div>#{{ $ordonnance->id }}</div>
                                <div class="text-xs font-semibold uppercase tracking-[.2em] text-slate-500">{{ ucfirst($ordonnance->statut) }}</div>
                            </div>
                            <div class="text-slate-600">Prescrit le {{ optional($ordonnance->date_prescription)->format('d/m/Y') }}</div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Ventes</h3>
            @if($patient->ventes->isEmpty())
                <p class="text-sm text-slate-500">Aucune vente associée.</p>
            @else
                <ul class="space-y-3 text-sm text-slate-700">
                    @foreach($patient->ventes as $vente)
                        <li class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="flex items-center justify-between gap-2">
                                <div>#{{ $vente->id }}</div>
                                <span class="text-slate-600">{{ optional($vente->date)->format('d/m/Y') }}</span>
                            </div>
                            <div class="text-slate-700">Total: {{ number_format($vente->total, 2, ',', ' ') }} FCFA</div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
