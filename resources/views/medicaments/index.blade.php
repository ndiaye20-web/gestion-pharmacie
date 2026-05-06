@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Gestion des Médicaments</h1>
        <a href="{{ route('medicaments.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
            Ajouter un Médicament
        </a>
    </div>

    @if ($medicaments->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <p class="text-yellow-700 font-medium">Aucun médicament enregistré pour le moment.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nom Commercial</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">DCI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Dosage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Prix Vente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($medicaments as $medicament)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-gray-800 font-medium">{{ $medicament->nom_commercial }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $medicament->dci ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ $medicament->dosage ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-gray-800 font-medium">{{ number_format($medicament->prix_vente, 2, ',', ' ') }} FCFA</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('medicaments.edit', $medicament->id) }}" class="text-blue-600 hover:text-blue-800 mr-3">Éditer</a>
                                <form action="{{ route('medicaments.destroy', $medicament->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Êtes-vous sûr?')">Supprimer</button>
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
