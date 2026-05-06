@extends('layouts.app')

@section('title', 'Modifier le lot')

@section('content')
<div class="rounded-3xl bg-white p-6 shadow-sm">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-slate-900"> Modifier le lot</h2>
        <p class="text-sm text-slate-500">Mettez à jour les informations du lot et la date d'expiration.</p>
    </div>

    <form method="POST" action="{{ route('lots.update', $lot) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-slate-700">Médicament</label>
            <select name="medicament_id" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200" required>
                @foreach($medicaments as $med)
                    <option value="{{ $med->id }}" {{ $lot->medicament_id == $med->id ? 'selected' : '' }}>{{ $med->nom_commercial }}</option>
                @endforeach
            </select>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-slate-700">Numéro de lot</label>
                <input type="text" name="numero_lot" value="{{ old('numero_lot', $lot->numero_lot) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700">Quantité</label>
                <input type="number" name="quantite" value="{{ old('quantite', $lot->quantite) }}" min="0" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700">Date d'expiration</label>
            <input type="date" name="date_expiration" value="{{ old('date_expiration', $lot->date_expiration->format('Y-m-d')) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200" required>
        </div>

        <div class="flex items-center justify-between gap-4 pt-3">
            <a href="{{ route('lots.index') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900">← Retour à la liste</a>
            <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection
