@extends('layouts.app')

@section('title', 'Historique des Ventes')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">Historique des ventes</h2>
            <p class="text-sm text-slate-500">Suivi des transactions, tickets et recapitulatif.</p>
        </div>
        <a href="{{ route('ventes.create') }}" class="inline-flex items-center rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">+ Nouvelle vente</a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded mb-6">
            {{ session('warning') }}
        </div>
    @endif

    @if($ventes->isEmpty())
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded mb-6">
            Aucune vente trouvée pour le moment.
        </div>
    @else
        <div class="overflow-x-auto rounded-3xl border border-slate-200 bg-slate-50 shadow-sm">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-100 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">#ID</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Client</th>
                        <th class="px-4 py-3 text-left">Mode paiement</th>
                        <th class="px-4 py-3 text-left">Montant</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach ($ventes as $vente)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 text-slate-800">#{{ str_pad($vente->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ optional($vente->date)->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-4 text-slate-800">{{ $vente->patient->nom ?? 'Client anonyme' }} {{ $vente->patient->prenom ?? '' }}</td>
                            <td class="px-4 py-4 text-slate-600">{{ $vente->mode_paiement ?? 'Non défini' }}</td>
                            <td class="px-4 py-4 text-slate-800 font-semibold text-emerald-700">{{ number_format($vente->total, 0, ',', ' ') }} FCFA</td>
                            <td class="px-4 py-4 space-x-2">
                                <a href="{{ route('ventes.show', $vente) }}" class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-200">Voir</a>
                                <a href="{{ route('tickets.pdf', $vente->id) }}" class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 hover:bg-red-200">PDF</a>
                                <form action="{{ route('ventes.destroy', $vente) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette vente ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 hover:bg-rose-200">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
