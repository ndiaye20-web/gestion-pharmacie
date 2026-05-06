<!-- Patient Dashboard Section -->
<div class="grid grid-cols-1 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Espace patient</h3>
        <p class="text-gray-600 mb-6">{{ $data['message'] ?? 'Bienvenue dans votre espace patient. Retrouvez ici vos informations et rappels.' }}</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 rounded-lg p-4">
                <p class="text-sm text-gray-600">Compte créé le</p>
                <p class="text-xl font-semibold text-gray-800 mt-2">{{ $data['accountCreated'] ?? 'N/A' }}</p>
            </div>
            <div class="bg-white rounded-lg border border-gray-100 p-4">
                <p class="text-sm text-gray-600">Ordonnances totales</p>
                <p class="text-xl font-semibold text-gray-800 mt-2">{{ $data['totalOrdonnances'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-lg border border-gray-100 p-4">
                <p class="text-sm text-gray-600">En attente</p>
                <p class="text-xl font-semibold text-gray-800 mt-2">{{ $data['ordonnancesEnAttente'] ?? 0 }}</p>
            </div>
            <div class="bg-white rounded-lg border border-gray-100 p-4">
                <p class="text-sm text-gray-600">Rappels actifs</p>
                <p class="text-xl font-semibold text-gray-800 mt-2">{{ $data['rappels'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Dernières ordonnances</h3>
        @if ($data['ordonnances']->isEmpty())
            <p class="text-gray-500">Aucune ordonnance trouvée pour le moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Médecin</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Statut</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Renouvellements</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($data['ordonnances'] as $ordonnance)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $ordonnance->id }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $ordonnance->medecin }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ optional($ordonnance->date_prescription)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $ordonnance->statut)) }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $ordonnance->renouvellements }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
