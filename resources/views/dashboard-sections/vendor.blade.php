<!-- Vendor Dashboard Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Statistiques de Ventes -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Mes Ventes</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-blue-600">{{ $data['mesVentes'] }}</p>
                <p class="text-gray-600 text-sm">Total</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-green-600">{{ number_format($data['ventesAujourdhui'], 0, ',', ' ') }} FCFA</p>
                <p class="text-gray-600 text-sm">Aujourd'hui</p>
            </div>
        </div>
    </div>

    <!-- Statistiques Hebdomadaires -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Cette Semaine</h3>
        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="bg-purple-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-purple-600">{{ number_format($data['ventesHebdomadaires'], 0, ',', ' ') }} FCFA</p>
                <p class="text-gray-600 text-sm">Total (7 derniers jours)</p>
            </div>
        </div>
    </div>
</div>

<!-- Performance Section -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">Performance Quotidienne</h3>
    <div class="grid grid-cols-7 gap-2">
        @foreach ($data['ventes7j'] as $date => $count)
            <div class="bg-gradient-to-b from-blue-50 to-blue-100 p-4 rounded-lg text-center border-l-4 border-blue-500">
                <p class="text-xs text-gray-600">{{ \Carbon\Carbon::parse($date)->format('D') }}</p>
                <p class="text-2xl font-bold text-blue-600">{{ $count }}</p>
                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($date)->format('d/m') }}</p>
            </div>
        @endforeach
    </div>
</div>

<!-- Action Rapide -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">Actions Rapides</h3>
    <div class="grid grid-cols-2 gap-4">
        <a href="{{ route('ventes.create') }}" class="block bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg text-center font-semibold transition">
            Nouvelle Vente
        </a>
        <a href="{{ route('ventes.index') }}" class="block bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg text-center font-semibold transition">
            Historique
        </a>
    </div>
</div>
