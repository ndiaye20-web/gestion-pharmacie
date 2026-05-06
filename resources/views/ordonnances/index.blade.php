@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Gestion des Ordonnances</h1>
        <a href="{{ route('ordonnances.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
            Nouvelle Ordonnance
        </a>
    </div>

    @if ($ordonnances->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-700 font-medium">Aucune ordonnance enregistrée pour le moment.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Médecin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date Prescription</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($ordonnances as $ord)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-gray-800 font-medium">{{ $ord->patient->nom }} {{ $ord->patient->prenom ?? '' }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $ord->medecin }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $ord->date_prescription->format('d/m/Y') ?? 'N/A' }}</td>
                            <td class="px-6 py-3">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($ord->statut == 'en_attente')
                                        bg-yellow-100 text-yellow-800
                                    @elseif($ord->statut == 'traitee')
                                        bg-green-100 text-green-800
                                    @else
                                        bg-gray-100 text-gray-800
                                    @endif
                                ">
                                    {{ ucfirst($ord->statut) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                @if($ord->statut == 'en_attente')
                                    <a href="{{ route('ordonnances.vente', $ord->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm inline-block">
                                        Transformer en vente
                                    </a>
                                @else
                                    <span class="text-gray-500 text-sm">Déjà traitée</span>
                                @endif
                                <a href="{{ route('ordonnances.edit', $ord->id) }}" class="text-blue-600 hover:text-blue-800 ml-2">Éditer</a>
                                <form action="{{ route('ordonnances.destroy', $ord->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 ml-2" onclick="return confirm('Êtes-vous sûr?')">Supprimer</button>
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
