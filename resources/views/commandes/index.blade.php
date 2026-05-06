@extends('layouts.app')

@section('title', 'Commandes fournisseurs')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">Commandes fournisseurs</h2>
            <p class="text-sm text-slate-500">Suivi des commandes et réception de stock.</p>
        </div>
        <a href="{{ route('commandes.create') }}" class="inline-flex items-center rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">+ Nouvelle commande</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-100 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Fournisseur</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($commandes as $commande)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-4 text-slate-800">#{{ $commande->id }}</td>
                        <td class="px-4 py-4 text-slate-800">{{ $commande->fournisseur->nom }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ optional($commande->date_commande)->format('d/m/Y') }}</td>
                        <td class="px-4 py-4">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $commande->statut === 'reçue' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($commande->statut) }}</span>
                        </td>
                        <td class="px-4 py-4 space-x-2">
                            <a href="{{ route('commandes.show', $commande) }}" class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-200">Voir</a>
                            <a href="{{ route('commandes.edit', $commande) }}" class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 hover:bg-amber-200">Modifier</a>
                            @if($commande->statut !== 'reçue')
                                <a href="{{ route('commandes.reception', $commande->id) }}" class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 hover:bg-emerald-200">Réceptionner</a>
                            @endif
                            <form action="{{ route('commandes.destroy', $commande) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette commande ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 hover:bg-rose-200">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">Aucune commande trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
