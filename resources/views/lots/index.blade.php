@extends('layouts.app')

@section('title', 'Gestion des Lots')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Lots</h1>
            <p class="text-gray-600 mt-2">Suivi des lots de médicaments, des dates d’expiration et des quantités disponibles.</p>
        </div>
        <a href="{{ route('lots.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
            Ajouter un Lot
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Tous les lots</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Médicament</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">N° lot</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Expiration</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($lots as $lot)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-800">{{ $lot->medicament->nom_commercial }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $lot->numero_lot }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $lot->quantite }}</td>
                                <td class="px-6 py-4 text-gray-800">
                                    {{ $lot->date_expiration->format('d/m/Y') }}
                                    @if($lot->date_expiration->isPast())
                                        <span class="ml-2 text-xs px-2 py-1 rounded-full bg-red-100 text-red-700">Expiré</span>
                                    @elseif($lot->date_expiration->diffInDays(now()) <= 90)
                                        <span class="ml-2 text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">Bientôt</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Lots expirés</h3>
                @if($expires->isEmpty())
                    <p class="text-gray-600">Aucun lot expiré.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($expires as $lot)
                            <li class="border rounded-xl p-4 bg-red-50">
                                <div class="font-semibold text-gray-800">{{ $lot->medicament->nom_commercial }}</div>
                                <div class="text-sm text-gray-600">Expiré le {{ $lot->date_expiration->format('d/m/Y') }}</div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Lots bientôt expirés</h3>
                @if($soon->isEmpty())
                    <p class="text-gray-600">Aucun lot proche de l’expiration.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($soon as $lot)
                            <li class="border rounded-xl p-4 bg-orange-50">
                                <div class="font-semibold text-gray-800">{{ $lot->medicament->nom_commercial }}</div>
                                <div class="text-sm text-gray-600">Expiration le {{ $lot->date_expiration->format('d/m/Y') }}</div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
