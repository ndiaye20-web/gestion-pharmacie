<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900"> Gestion du Stock</h1>
        <p class="text-gray-600">Interface de gestion des stocks et commandes fournisseurs</p>
    </div>

    <!-- Messages -->
    @if (session()->has('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Onglets -->
    <div class="mb-6">
        <nav class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
            <button wire:click="$set('activeTab', 'inventory')"
                    class="flex-1 py-2 px-4 text-sm font-medium rounded-md {{ $activeTab === 'inventory' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                 Inventaire
            </button>
            <button wire:click="$set('activeTab', 'low-stock')"
                    class="flex-1 py-2 px-4 text-sm font-medium rounded-md {{ $activeTab === 'low-stock' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                 Stock Faible
            </button>
            <button wire:click="$set('activeTab', 'orders')"
                    class="flex-1 py-2 px-4 text-sm font-medium rounded-md {{ $activeTab === 'orders' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                 Commandes
            </button>
        </nav>
    </div>

    <!-- Contenu des onglets -->
    @if($activeTab === 'inventory')
        <!-- Inventaire -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4"> État des Stocks</h2>
                <div class="flex gap-4">
                    <input type="text" wire:model.live.debounce.300ms="search"
                           placeholder="Rechercher un médicament..."
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Médicament</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Achat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Vente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($medicaments as $medicament)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $medicament->nom_commercial }}</div>
                                        <div class="text-sm text-gray-500">{{ $medicament->forme }} · {{ $medicament->dosage }}</div>
                                        <div class="text-xs text-gray-400">CIP: {{ $medicament->code_cip13 }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $medicament->lots_sum_quantite < 10 ? 'bg-red-100 text-red-800' :
                                           ($medicament->lots_sum_quantite < 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $medicament->lots_sum_quantite ?? 0 }} unités
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($medicament->prix_achat, 2, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($medicament->prix_vente, 2, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button wire:click="addToOrder({{ $medicament->id }})"
                                            class="text-blue-600 hover:text-blue-900">Ajouter à commande</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @elseif($activeTab === 'low-stock')
        <!-- Stock faible -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4"> Médicaments en Stock Faible</h2>
                <p class="text-gray-600">Ces médicaments ont moins de 10 unités en stock</p>
            </div>

            @if($lowStockMedicaments->isEmpty())
                <div class="text-center py-12">
                    <div class="text-6xl mb-4"></div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tous les stocks sont corrects</h3>
                    <p class="text-gray-500">Aucun médicament n'est en rupture de stock</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($lowStockMedicaments as $medicament)
                        <div class="border border-red-200 bg-red-50 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $medicament->nom_commercial }}</h3>
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                    {{ $medicament->lots_sum_quantite ?? 0 }} unités
                                </span>
                            </div>
                            <p class="text-xs text-gray-600 mb-3">{{ $medicament->forme }} · {{ $medicament->dosage }}</p>
                            <button wire:click="addToOrder({{ $medicament->id }})"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition">
                                Commander
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    @elseif($activeTab === 'orders')
        <!-- Création de commande -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Sélection des médicaments -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4"> Nouvelle Commande</h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fournisseur</label>
                    <select wire:model="fournisseur_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Sélectionner un fournisseur</option>
                        @foreach($fournisseurs as $fournisseur)
                            <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                        @endforeach
                    </select>
                </div>

                @if(!empty($selectedMedicaments))
                    <div class="space-y-3 mb-4">
                        <h3 class="font-medium text-gray-900">Médicaments sélectionnés:</h3>
                        @foreach($selectedMedicaments as $id => $item)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 text-sm">{{ $item['medicament']->nom_commercial }}</h4>
                                    <p class="text-xs text-gray-600">{{ number_format($item['prix_achat'], 2, ',', ' ') }} FCFA × {{ $item['quantity'] }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="number" wire:model="selectedMedicaments.{{ $id }}.quantity"
                                           min="1" class="w-16 px-2 py-1 border border-gray-300 rounded text-sm">
                                    <button wire:click="removeFromOrder({{ $id }})"
                                            class="text-red-600 hover:text-red-800">×</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center text-lg font-bold mb-4">
                            <span>Total:</span>
                            <span class="text-green-600">{{ number_format($totalOrder, 2, ',', ' ') }} FCFA</span>
                        </div>

                        <button wire:click="createOrder"
                                @if(!$fournisseur_id) disabled @endif
                                class="w-full bg-green-500 hover:bg-green-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white py-3 px-4 rounded-lg font-semibold transition">
                             Créer la commande
                        </button>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Aucun médicament sélectionné pour la commande</p>
                @endif
            </div>

            <!-- Historique des commandes -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4"> Commandes Récentes</h2>

                <div class="space-y-3">
                    @foreach(\App\Models\CommandeFournisseur::with('fournisseur')->orderBy('date_commande', 'desc')->limit(5)->get() as $commande)
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-medium text-gray-900">#{{ $commande->id }}</span>
                                <span class="text-xs px-2 py-1 rounded-full
                                    {{ $commande->statut === 'reçue' ? 'bg-green-100 text-green-800' :
                                       ($commande->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600">{{ $commande->fournisseur->nom }}</p>
                            <p class="text-xs text-gray-500">{{ $commande->date_commande->format('d/m/Y') }}</p>
                            <p class="text-sm font-medium text-green-600">{{ number_format($commande->total, 2, ',', ' ') }} FCFA</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <a href="{{ route('commandes.index') }}" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-center font-medium transition block">
                        Voir toutes les commandes
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Actions rapides -->
    <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4"> Actions Rapides</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('medicaments.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-lg text-center font-medium transition">
                 Médicaments
            </a>
            <a href="{{ route('lots.index') }}" class="bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg text-center font-medium transition">
                 Lots
            </a>
            <a href="{{ route('commandes.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white py-3 px-4 rounded-lg text-center font-medium transition">
                 Commandes
            </a>
            <a href="{{ route('dashboard.preparateur') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-3 px-4 rounded-lg text-center font-medium transition">
                 Dashboard
            </a>
        </div>
    </div>
</div>
