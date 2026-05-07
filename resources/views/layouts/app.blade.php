<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="/manifest.json">
    <title>@yield('title', 'Gestion Pharmacie')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <header class="bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-4">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-xl font-semibold text-slate-900">Gestion Pharmacie</h1>
                    <p class="text-sm text-slate-500">Interface back-office professionnelle</p>
                </div>
            </div>
            <div class="flex items-center gap-3 text-sm text-slate-600">
                @auth
                    <span>Connecté en tant que <strong>{{ Auth::user()->name }}</strong></span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">Se connecter</a>
                @endauth
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-6 px-4 py-6">
        <aside class="w-full lg:w-72 rounded-3xl bg-slate-950 p-5 text-slate-100 shadow-sm">
            <h2 class="mb-4 text-base font-semibold uppercase tracking-[.25em] text-slate-300">Navigation</h2>
            <nav class="space-y-2 text-sm">
                @auth
                    @php
                        $role = Auth::user()->role;
                        $dashboardRoute = match($role) {
                            'caissier' => route('dashboard.caissier'),
                            'pharmacien' => route('dashboard.pharmacien'),
                            'preparateur' => route('dashboard.preparateur'),
                            'patient' => route('dashboard.patient'),
                            default => route('dashboard'),
                        };
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->routeIs('dashboard*') ? 'bg-slate-800' : '' }}">Mon tableau de bord</a>

                    @if(in_array($role, ['admin', 'pharmacien', 'preparateur']))
                        <a href="{{ route('medicaments.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->is('medicaments*') ? 'bg-slate-800' : '' }}">Médicaments</a>
                        <a href="{{ route('lots.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->is('lots*') ? 'bg-slate-800' : '' }}">Lots</a>
                        @if($role === 'preparateur')
                            <a href="{{ route('stock') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->routeIs('stock') ? 'bg-slate-800' : '' }}"> Gestion Stock</a>
                        @endif
                    @endif

                    @if(in_array($role, ['admin', 'caissier', 'preparateur', 'vendor']))
                        <a href="{{ route('ventes.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->is('ventes*') ? 'bg-slate-800' : '' }}">Ventes</a>
                        @if($role === 'caissier')
                            <a href="{{ route('pos') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->routeIs('pos') ? 'bg-slate-800' : '' }}"> Caisse POS</a>
                        @endif
                    @endif

                    @if(in_array($role, ['admin', 'pharmacien']))
                        <a href="{{ route('ordonnances.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->is('ordonnances*') ? 'bg-slate-800' : '' }}">Ordonnances</a>
                    @endif

                    @if(in_array($role, ['admin', 'pharmacien', 'preparateur']))
                        <a href="{{ route('patients.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->is('patients*') ? 'bg-slate-800' : '' }}">Patients</a>
                    @endif

                    @if($role === 'admin')
                        <a href="{{ route('admin.users') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->routeIs('admin.users') ? 'bg-slate-800' : '' }}">Gérer les utilisateurs</a>
                    @endif

                    @if(in_array($role, ['admin']))
                        <a href="{{ route('fournisseurs.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->is('fournisseurs*') ? 'bg-slate-800' : '' }}">Fournisseurs</a>
                        <a href="{{ route('commandes.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->is('commandes*') ? 'bg-slate-800' : '' }}">Commandes</a>
                    @endif

                    @if($role === 'patient')
                        <a href="{{ route('dashboard.patient') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->routeIs('dashboard.patient') ? 'bg-slate-800' : '' }}">Mon espace patient</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->routeIs('login') ? 'bg-slate-800' : '' }}">Se connecter</a>
                    <a href="{{ route('register') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-800 {{ request()->routeIs('register') ? 'bg-slate-800' : '' }}">S'inscrire</a>
                @endauth
            </nav>
        </aside>

        <main class="flex-1">
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-800">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
