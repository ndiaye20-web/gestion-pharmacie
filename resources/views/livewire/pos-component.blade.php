<div class="max-w-7xl mx-auto p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900"> Caisse - Point de Vente</h1>
        <p class="text-gray-600">Interface tactile pour les ventes en pharmacie</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Catalogue des médicaments -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4"> Catalogue Médicaments</h2>

                    <!-- Recherche et Scan -->
                    <div class="flex gap-4 mb-4">
                        <div class="flex-1">
                            <input type="text" wire:model.live.debounce.300ms="search"
                                   placeholder="Rechercher par nom ou CIP..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <button type="button" onclick="startScan()"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                             Scanner
                        </button>
                    </div>
                </div>

                <!-- Grille des médicaments -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                    @foreach($medicaments as $medicament)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition cursor-pointer"
                             wire:click="addMedicament({{ $medicament->id }})">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $medicament->nom_commercial }}</h3>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $medicament->code_cip13 }}</span>
                            </div>
                            <p class="text-xs text-gray-600 mb-2">{{ $medicament->forme }} · {{ $medicament->dosage }}</p>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-green-600">{{ number_format($medicament->prix_vente, 2, ',', ' ') }} FCFA</span>
                                <span class="text-xs text-gray-500">Stock: {{ $medicament->lots->sum('quantite') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Panier et Validation -->
        <div class="space-y-6">
            <!-- Panier -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4"> Panier</h2>

                @if(empty($selectedMedicaments))
                    <p class="text-gray-500 text-center py-8">Aucun médicament sélectionné</p>
                @else
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($selectedMedicaments as $id => $medicament)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 text-sm">{{ $medicament->nom_commercial }}</h4>
                                    <p class="text-xs text-gray-600">{{ number_format($medicament->prix_vente, 2, ',', ' ') }} FCFA × {{ $quantities[$id] ?? 0 }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button wire:click="updateQuantity({{ $id }}, {{ ($quantities[$id] ?? 0) - 1 }})"
                                            class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-full flex items-center justify-center text-sm">-</button>
                                    <span class="w-8 text-center font-medium">{{ $quantities[$id] ?? 0 }}</span>
                                    <button wire:click="updateQuantity({{ $id }}, {{ ($quantities[$id] ?? 0) + 1 }})"
                                            class="w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-full flex items-center justify-center text-sm">+</button>
                                    <button wire:click="removeMedicament({{ $id }})"
                                            class="w-8 h-8 bg-gray-200 hover:bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-sm">×</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span>Total:</span>
                            <span class="text-green-600">{{ number_format($total, 2, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Informations client et paiement -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4"> Client & Paiement</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client</label>
                        <select wire:model="patient_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Client occasionnel</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->nom }} {{ $patient->prenom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mode de paiement</label>
                        <select wire:model="mode_paiement" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="Espèces"> Espèces</option>
                            <option value="Carte bancaire"> Carte bancaire</option>
                            <option value="Chèque"> Chèque</option>
                            <option value="Virement"> Virement</option>
                        </select>
                    </div>

                    <button wire:click="processSale"
                            @if(empty($selectedMedicaments)) disabled @endif
                            class="w-full bg-green-500 hover:bg-green-600 disabled:bg-gray-300 disabled:cursor-not-allowed text-white py-3 px-4 rounded-lg font-semibold text-lg transition">
                         Valider la vente ({{ number_format($total, 2, ',', ' ') }} FCFA)
                    </button>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4"> Actions</h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('ventes.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg text-center font-medium transition">
                         Historique
                    </a>
                    <a href="{{ route('dashboard.caissier') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg text-center font-medium transition">
                         Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scanner Modal (caché par défaut) -->
    <div id="scanner-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl p-6 max-w-md w-full">
                <h3 class="text-lg font-semibold mb-4"> Scanner CIP/EAN13</h3>
                <div id="scanner-container" class="mb-4">
                    <video id="scanner-video" class="w-full rounded-lg"></video>
                </div>
                <div class="flex gap-3">
                    <button onclick="stopScan()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg">
                        Annuler
                    </button>
                    <input type="text" id="manual-code" placeholder="Ou saisir manuellement"
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <button onclick="manualScan()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let scanner = null;

        function startScan() {
            document.getElementById('scanner-modal').classList.remove('hidden');
            // Ici on pourrait intégrer une vraie bibliothèque de scan comme QuaggaJS
            // Pour l'instant, on simule avec un input manuel
        }

        function stopScan() {
            document.getElementById('scanner-modal').classList.add('hidden');
            if (scanner) {
                scanner.stop();
            }
        }

        function manualScan() {
            const code = document.getElementById('manual-code').value.trim();
            if (code) {
                $wire.scanCode(code);
                stopScan();
                document.getElementById('manual-code').value = '';
            }
        }

        // Écouter les événements Livewire
        document.addEventListener('livewire:loaded', () => {
            $wire.on('medicament-added', (data) => {
                // Notification de succès
                showNotification('Médicament ajouté: ' + data.name, 'success');
            });

            $wire.on('medicament-not-found', () => {
                showNotification('Code non reconnu', 'error');
            });

            $wire.on('sale-completed', (data) => {
                showNotification('Vente enregistrée!', 'success');
                // Ici on pourrait ouvrir automatiquement le ticket PDF
                window.open('/ventes/' + data.vente_id + '/ticket', '_blank');
            });
        });

        function showNotification(message, type) {
            // Simple notification temporaire
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Raccourcis clavier
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                $wire.processSale();
            }
        });
    </script>
</div>
