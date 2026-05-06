@extends('layouts.app')

@section('title', 'Patients')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">Patients</h2>
            <p class="text-sm text-slate-500">Gestion des fiches patients et suivi des dossiers.</p>
        </div>
        <a href="{{ route('patients.create') }}" class="inline-flex items-center rounded-2xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
            + Ajouter un patient
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-100 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3 text-left">Prénom</th>
                    <th class="px-4 py-3 text-left">Téléphone</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($patients as $p)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-4 text-slate-800">{{ $p->nom }}</td>
                        <td class="px-4 py-4 text-slate-800">{{ $p->prenom }}</td>
                        <td class="px-4 py-4 text-slate-600">{{ $p->telephone ?? '-' }}</td>
                        <td class="px-4 py-4 text-slate-600 space-x-2">
                            <a href="{{ route('patients.show', $p) }}" class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-200">Voir</a>
                            <a href="{{ route('patients.edit', $p) }}" class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 hover:bg-amber-200">Modifier</a>
                            <form action="{{ route('patients.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce patient ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700 hover:bg-rose-200">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-slate-500">Aucun patient enregistré pour le moment.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
