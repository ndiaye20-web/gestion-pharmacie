<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion Pharmacie</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .role-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .role-admin { background-color: #ef4444; color: white; }
        .role-pharmacien { background-color: #3b82f6; color: white; }
        .role-caissier { background-color: #10b981; color: white; }
        .role-preparateur { background-color: #8b5cf6; color: white; }
        .role-vendor { background-color: #f59e0b; color: white; }
        .role-guest { background-color: #6b7280; color: white; }
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50">
    @auth
        <!-- Navigation Professionnelle (Authenticated) -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-3xl font-bold text-blue-600">Gestion Pharmacie</h1>
                        <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="text-right">
                            <p class="text-gray-700 font-semibold">{{ $user->name }}</p>
                            <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    @else
        <!-- Navigation Simplifiée (Guest) - Merge from welcome -->
        <nav class="bg-white/80 backdrop-blur-md shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-3xl font-bold text-blue-600">Gestion Pharmacie</h1>
                        <span class="role-badge role-guest">Visiteur</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            Se Connecter
                        </a>
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            S'Inscrire
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    @endauth

    <!-- Contenu Principal -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Messages de succès/erreur -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <p class="font-bold">Succès</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <p class="font-bold">Erreur</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @guest
            <!-- Hero Section from Welcome (Merged) -->
            <div class="text-center py-20 hero-gradient text-white rounded-3xl mb-12">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">Bienvenue dans Gestion Pharmacie</h1>
                <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto opacity-90">Le système de gestion pharmaceutique complet pour votre pharmacie. Gérez stocks, ventes, ordonnances et plus encore.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center max-w-md mx-auto">
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:-translate-y-1">
                        Commencer
                    </a>
                    <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                        Créer un compte
                    </a>
                </div>
            </div>

            <!-- Aperçu Stats pour Guests -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-white rounded-xl shadow-xl p-8 text-center">
                    <div class="text-4xl mb-2">Médicaments</div>
                    <p class="text-3xl font-bold text-blue-600">{{ $nbMedicaments }}</p>
                    <p class="text-gray-600 font-semibold">Médicaments disponibles</p>
                </div>
                <div class="bg-white rounded-xl shadow-xl p-8 text-center">
                    <div class="text-4xl mb-2">Commandes</div>
                    <p class="text-3xl font-bold text-orange-600">{{ $stockTotal }}</p>
                    <p class="text-gray-600 font-semibold">Unités en stock</p>
                </div>
                <div class="bg-white rounded-xl shadow-xl p-8 text-center">
                    <div class="text-4xl mb-2">Revenu</div>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($totalVentes, 0, ',', ' ') }} FCFA</p>
                    <p class="text-gray-600 font-semibold">Chiffre d'affaires total</p>
                </div>
                <div class="bg-white rounded-xl shadow-xl p-8 text-center">
                    <div class="text-4xl mb-2">Statistiques</div>
                    <p class="text-3xl font-bold text-purple-600">{{ $nbVentes }}</p>
                    <p class="text-gray-600 font-semibold">Ventes effectuées</p>
                </div>
            </div>

            <!-- Call to Action Final -->
            <div class="text-center py-16 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-3xl">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Prêt à transformer votre pharmacie ?</h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Rejoignez des centaines de pharmaciens qui optimisent leur gestion quotidienne.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-lg hover:shadow-xl transition-all">
                        Créer un compte gratuit
                    </a>
                    <a href="{{ route('login') }}" class="border-2 border-blue-600 text-blue-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-blue-600 hover:text-white transition-all">
                        Démo du système
                    </a>
                </div>
            </div>
        @else
            <!-- Alertes Critiques (Authenticated only) -->
            @if ($expires > 0)
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-6">
                    <p class="font-bold">Alerte critique</p>
                    <p><strong>{{ $expires }}</strong> lot(s) expiré(s) détecté(s). Action requise!</p>
                </div>
            @endif
            @if ($lowStock > 0)
                <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 px-4 py-3 rounded mb-6">
                    <p class="font-bold">Stock faible</p>
                    <p><strong>{{ $lowStock }}</strong> médicament(s) en stock faible (moins de 10 unités)</p>
                </div>
            @endif

            <!-- En-tête Auth -->
            <div class="mb-8">
                <h2 class="text-4xl font-bold text-gray-800 mb-2">Bienvenue, {{ $user->name }}!</h2>
                <p class="text-gray-600">Tableau de bord - {{ now()->format('d M Y H:i') }}</p>
            </div>

            <!-- Cartes KPI Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-xl transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm uppercase tracking-wide font-semibold">Médicaments</p>
                            <p class="text-4xl font-bold text-blue-600 mt-3">{{ $nbMedicaments }}</p>
                            <p class="text-gray-500 text-xs mt-2">Total en catalogue</p>
                        </div>
                        <div class="text-3xl text-gray-400">Médicaments</div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-xl transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm uppercase tracking-wide font-semibold">Ventes</p>
                            <p class="text-4xl font-bold text-green-600 mt-3">{{ $nbVentes }}</p>
                            <p class="text-gray-500 text-xs mt-2">Transactions enregistrées</p>
                        </div>
                        <div class="text-3xl text-gray-400">Ventes</div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500 hover:shadow-xl transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm uppercase tracking-wide font-semibold">Chiffre d'Affaires</p>
                            <p class="text-4xl font-bold text-purple-600 mt-3">{{ number_format($totalVentes, 2, ',', ' ') }} FCFA</p>
                            <p class="text-gray-500 text-xs mt-2">Revenu total</p>
                        </div>
                        <div class="text-3xl text-gray-400">CA</div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500 hover:shadow-xl transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm uppercase tracking-wide font-semibold">Stock Total</p>
                            <p class="text-4xl font-bold text-orange-600 mt-3">{{ $stockTotal }}</p>
                            <p class="text-gray-500 text-xs mt-2">Unités en stock</p>
                        </div>
                        <div class="text-3xl text-gray-400">Stock</div>
                    </div>
                </div>
            </div>

            <!-- Sections Spécifiques au Rôle -->
            @if (!empty($user->role) && $user->role !== 'guest')
                @if ($user->role === 'admin')
                    @include('dashboard-sections.admin', ['data' => $additionalData])
                @elseif ($user->role === 'pharmacien')
                    @include('dashboard-sections.pharmacien', ['data' => $additionalData])
                @elseif ($user->role === 'caissier')
                    @include('dashboard-sections.caissier', ['data' => $additionalData])
                @elseif ($user->role === 'preparateur')
                    @include('dashboard-sections.staff', ['data' => $additionalData])
                @elseif ($user->role === 'vendor')
                    @include('dashboard-sections.vendor', ['data' => $additionalData])
                @elseif ($user->role === 'patient')
                    @include('dashboard-sections.patient', ['data' => $additionalData])
                @endif
            @endif

            <!-- Graphique des Ventes -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Ventes (7 derniers jours)</h2>
                    <canvas id="ventesChart" height="80"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Accès Rapide</h2>
                    <div class="space-y-3">
                        @if (in_array($user->role, ['admin', 'pharmacien', 'preparateur']))
                            <a href="{{ route('medicaments.index') }}" class="block bg-blue-50 hover:bg-blue-100 p-3 rounded-lg text-blue-600 font-medium transition">
                                → Médicaments
                            </a>
                        @endif
                        @if (in_array($user->role, ['admin', 'pharmacien', 'preparateur']))
                            <a href="{{ route('lots.index') }}" class="block bg-green-50 hover:bg-green-100 p-3 rounded-lg text-green-600 font-medium transition">
                                → Lots
                            </a>
                        @endif
                        @if (in_array($user->role, ['admin', 'caissier', 'preparateur', 'vendor']))
                            <a href="{{ route('ventes.index') }}" class="block bg-purple-50 hover:bg-purple-100 p-3 rounded-lg text-purple-600 font-medium transition">
                                → Ventes
                            </a>
                        @endif
                        @if (in_array($user->role, ['admin', 'caissier', 'vendor']))
                            <a href="{{ route('ventes.create') }}" class="block bg-orange-50 hover:bg-orange-100 p-3 rounded-lg text-orange-600 font-medium transition">
                                → Nouvelle Vente
                            </a>
                        @endif
                        @if (in_array($user->role, ['admin', 'pharmacien']))
                            <a href="{{ route('ordonnances.index') }}" class="block bg-red-50 hover:bg-red-100 p-3 rounded-lg text-red-600 font-medium transition">
                                → Ordonnances
                            </a>
                        @endif
                        @if (in_array($user->role, ['admin']))
                            <a href="{{ route('commandes.index') }}" class="block bg-indigo-50 hover:bg-indigo-100 p-3 rounded-lg text-indigo-600 font-medium transition">
                                → Commandes
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-100 rounded-lg p-6 text-center text-gray-600">
                <p>Gestion Pharmacie © 2026 - Système de gestion pharmaceutique</p>
                <p class="text-xs mt-2">Dernière mise à jour: {{ now()->format('d/m/Y H:i:s') }}</p>
            </div>
        @endauth
    </div>

    <!-- Script Chart.js (only for auth users) -->
    @auth
    <script>
        const ctx = document.getElementById('ventesChart').getContext('2d');
        const ventesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($joursLabels) !!},
                datasets: [{
                    label: 'Ventes (FCFA)',
                    data: {!! json_encode($ventesParJour) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: { size: 12, weight: '600' },
                            padding: 15,
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + ' FCFA';
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endauth
</body>
</html>
