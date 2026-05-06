<!-- Admin Dashboard Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Gestion des Utilisateurs -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold text-gray-800"> Gestion Utilisateurs</h3>
                <p class="text-gray-500 text-sm">Créer ou afficher les comptes par rôle.</p>
            </div>
            <a href="{{ route('admin.users') }}" class="rounded-2xl bg-slate-950 px-4 py-2 text-white hover:bg-slate-800 transition">
                Gérer les utilisateurs
            </a>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $data['nbUsers'] }}</p>
                <p class="text-gray-600 text-sm">Utilisateurs Total</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg text-center">
                <p class="text-2xl font-bold text-green-600">{{ $data['activeUsers'] }}</p>
                <p class="text-gray-600 text-sm">Actifs</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg text-center">
                <p class="text-2xl font-bold text-purple-600">{{ $data['roleCounts']->count() }}</p>
                <p class="text-gray-600 text-sm">Rôles</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Rôle</th>
                        <th class="px-4 py-2 text-left">Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['roleCounts'] as $roleCount)
                        <tr class="border-b">
                            <td class="px-4 py-2"><span>{{ $roleCount->role }}</span></td>
                            <td class="px-4 py-2 font-bold">{{ $roleCount->count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gestion des Commandes Fournisseurs -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Commandes Fournisseurs</h3>
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-orange-50 p-4 rounded-lg text-center">
                <p class="text-2xl font-bold text-orange-600">{{ $data['commandesPendantes'] }}</p>
                <p class="text-gray-600 text-sm">En Attente</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg text-center">
                <p class="text-2xl font-bold text-green-600">{{ $data['commandesRecues'] }}</p>
                <p class="text-gray-600 text-sm">Reçues</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg text-center">
                <p class="text-2xl font-bold text-purple-600">{{ number_format($data['totalCommandes'], 0, ',', ' ') }} FCFA</p>
                <p class="text-gray-600 text-sm">Total</p>
            </div>
        </div>
    </div>
</div>

<!-- Utilisateurs Récents -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4"> Utilisateurs Récents</h3>
        <div class="space-y-3">
            @forelse ($data['recentUsers'] as $user)
                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                    </div>
                    <span>{{ $user->role }}</span>
                </div>
            @empty
                <p class="text-gray-500">Aucun utilisateur</p>
            @endforelse
        </div>
    </div>

    <!-- Commandes Récentes -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Commandes Récentes</h3>
        <div class="space-y-3">
            @forelse ($data['recentCommands'] as $cmd)
                <div class="flex justify-between items-center border-b pb-2">
                    <div>
                        <p class="font-semibold text-gray-800">Commande #{{ $cmd->id }}</p>
                        <p class="text-xs text-gray-500">{{ $cmd->date_commande->format('d/m/Y') }}</p>
                    </div>
                    <span class="font-bold text-purple-600">{{ number_format($cmd->total, 0, ',', ' ') }} FCFA</span>
                </div>
            @empty
                <p class="text-gray-500">Aucune commande</p>
            @endforelse
        </div>
    </div>
</div>
