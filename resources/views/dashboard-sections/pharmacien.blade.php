<!-- Pharmacist Dashboard Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Gestion des Patients -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Patients</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-blue-600">{{ $data['nbPatients'] }}</p>
                <p class="text-gray-600 text-sm">Total</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-purple-600">{{ $data['ordonnancesEnAttente'] }}</p>
                <p class="text-gray-600 text-sm">Ordonnances Attente</p>
            </div>
        </div>
        <a href="{{ route('patients.index') }}" class="block w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-center font-semibold transition">
            Voir tous les patients →
        </a>
    </div>

    <!-- Gestion des Ordonnances -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Ordonnances</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-green-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-green-600">{{ $data['ordonnancesCompletees'] }}</p>
                <p class="text-gray-600 text-sm">Complétées</p>
            </div>
            <div class="bg-orange-50 p-4 rounded-lg text-center">
                <p class="text-3xl font-bold text-orange-600">{{ $data['nbOrdonnances'] }}</p>
                <p class="text-gray-600 text-sm">Total</p>
            </div>
        </div>
        <a href="{{ route('ordonnances.index') }}" class="block w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg text-center font-semibold transition">
            Gérer les ordonnances →
        </a>
    </div>
</div>

<!-- Patients et Ordonnances Récentes -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Patients Récents -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Patients Récents</h3>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @forelse ($data['recentPatients'] as $patient)
                <div class="border-l-4 border-blue-500 pl-3 pb-3 border-b">
                    <p class="font-semibold text-gray-800">{{ $patient->nom }} {{ $patient->prenom }}</p>
                    <p class="text-xs text-gray-500">Téléphone: {{ $patient->telephone ?? 'N/A' }}</p>
                </div>
            @empty
                <p class="text-gray-500">Aucun patient</p>
            @endforelse
        </div>
    </div>

    <!-- Ordonnances Récentes -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Ordonnances Récentes</h3>
        <div class="space-y-3 max-h-96 overflow-y-auto">
            @forelse ($data['recentOrdonnances'] as $ordonnance)
                <div class="border-l-4 border-green-500 pl-3 pb-3 border-b">
                    <p class="font-semibold text-gray-800">Ordonnance #{{ $ordonnance->id }}</p>
                    <p class="text-xs text-gray-500">Statut:
                        @if ($ordonnance->statut === 'en_attente')
                            <span class="text-orange-600">En attente</span>
                        @elseif ($ordonnance->statut === 'traitee')
                            <span class="text-green-600">Terminée</span>
                        @endif
                    </p>
                    <p class="text-xs text-gray-500">Date: {{ $ordonnance->date_prescription->format('d/m/Y') }}</p>
                </div>
            @empty
                <p class="text-gray-500">Aucune ordonnance</p>
            @endforelse
        </div>
    </div>
</div>
