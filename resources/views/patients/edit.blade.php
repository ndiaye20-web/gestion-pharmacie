@extends('layouts.app')

@section('title', 'Modifier un patient')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-slate-900"> Modifier le patient</h2>
        <p class="text-sm text-slate-500">Mettez à jour les informations patient si nécessaire.</p>
    </div>

    <form method="POST" action="{{ route('patients.update', $patient) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-700">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $patient->nom) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom', $patient->prenom) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200" required>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-700">Date de naissance</label>
                <input type="date" name="date_naissance" value="{{ old('date_naissance', $patient->date_naissance) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $patient->telephone) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-700">Numéro de sécurité sociale</label>
                <input type="text" name="numero_secu" value="{{ old('numero_secu', $patient->numero_secu) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Mutuelle</label>
                <input type="text" name="mutuelle" value="{{ old('mutuelle', $patient->mutuelle) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Allergies</label>
            <textarea name="allergies" rows="3" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">{{ old('allergies', $patient->allergies) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Historique</label>
            <textarea name="historique" rows="3" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">{{ old('historique', $patient->historique) }}</textarea>
        </div>

        <div class="flex items-center justify-between gap-4 pt-3">
            <a href="{{ route('patients.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">← Retour à la liste</a>
            <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Modifier</button>
        </div>
    </form>
</div>
@endsection
