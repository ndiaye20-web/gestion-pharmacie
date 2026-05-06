<!-- Staff Dashboard Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">Activité Journalière</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-lg border-l-4 border-blue-500">
            <p class="text-gray-600 text-sm font-semibold">VENTES ENREGISTRÉES</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $data['ventes'] }}</p>
            <p class="text-sm text-gray-600 mt-2">Total depuis le début</p>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-lg border-l-4 border-green-500">
            <p class="text-gray-600 text-sm font-semibold">MONTANT AUJOURD'HUI</p>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ number_format($data['ventesAujourdhui'], 2, ',', ' ') }} FCFA</p>
            <p class="text-sm text-gray-600 mt-2">Chiffre d'affaires du jour</p>
        </div>
    </div>
</div>

<!-- Dernière Vente -->
@if ($data['derniereVente'])
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Dernière Vente</h3>
        <div class="border-l-4 border-purple-500 pl-4">
            <p class="font-semibold text-gray-800">Vente #{{ $data['derniereVente']->id }}</p>
            <p class="text-gray-600">Montant: <strong>{{ number_format($data['derniereVente']->total, 2, ',', ' ') }} FCFA</strong></p>
            <p class="text-gray-600">Date: <strong>{{ $data['derniereVente']->created_at->format('d/m/Y H:i:s') }}</strong></p>
        </div>
    </div>
@endif

<!-- Actions Rapides -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">Mes Actions</h3>
    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('ventes.create') }}" class="block bg-green-500 hover:bg-green-600 text-white py-4 rounded-lg text-center font-semibold transition">
            Créer une Vente
        </a>
        <a href="{{ route('ventes.index') }}" class="block bg-purple-500 hover:bg-purple-600 text-white py-4 rounded-lg text-center font-semibold transition">
            Mes Ventes
        </a>
    </div>
</div>
