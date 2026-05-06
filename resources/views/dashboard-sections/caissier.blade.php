<!DOCTYPE html>
<!-- Caissier Dashboard Section - Ventes Focus -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Statistiques Ventes -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Mes Ventes</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-green-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-green-600">{{ $data['ventes'] ?? 0 }}</p>
                <p class="text-gray-600 text-sm">Total Ventes</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-blue-600">{{ number_format($data['ventesAujourdhui'] ?? 0, 0, ',', ' ') }} FCFA</p>
                <p class="text-gray-600 text-sm">Aujourd'hui</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-purple-600">{{ number_format($data['ventesSemaine'] ?? 0, 0, ',', ' ') }} FCFA</p>
                <p class="text-gray-600 text-sm">Cette semaine</p>
            </div>
        </div>
        <a href="{{ route('ventes.create') }}" class="block w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg text-center font-semibold transition">
            Nouvelle Vente
        </a>
    </div>

    <!-- Dernière Vente -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Dernière Transaction</h3>
        @if (!empty($data['derniereVente']))
            <div class="bg-green-50 p-6 rounded-lg">
                <p class="text-xl font-bold text-green-600">Vente #{{ $data['derniereVente']->id }}</p>
                <p class="text-2xl font-bold mt-2">{{ number_format($data['derniereVente']->total, 0, ',', ' ') }} FCFA</p>
                <p class="text-sm text-gray-500 mt-3">{{ $data['derniereVente']->created_at->format('d/m/Y H:i') }}</p>
                <p class="text-sm text-gray-500">Client: {{ $data['derniereVente']->patient->nom ?? 'Client anonyme' }} {{ $data['derniereVente']->patient->prenom ?? '' }}</p>
            </div>
        @else
            <p class="text-gray-500">Aucune vente enregistrée</p>
        @endif
    </div>
</div>

<!-- Actions Rapides Caissier -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">Actions Rapides</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('ventes.create') }}" class="block bg-emerald-500 hover:bg-emerald-600 text-white py-4 rounded-lg text-center font-bold text-lg transition">
            Nouvelle Vente Express
        </a>
        <a href="{{ route('ventes.index') }}" class="block bg-blue-500 hover:bg-blue-600 text-white py-4 rounded-lg text-center font-bold text-lg transition">
            Historique Ventes
        </a>
    </div>
</div>
