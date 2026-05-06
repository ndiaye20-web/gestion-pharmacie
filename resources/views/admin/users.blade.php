@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6" x-data="{
    editModal: false,
    editUser: { id: null, name: '', email: '', role: '', is_active: false },
    openEditModal(id, name, email, role, is_active) {
        this.editUser = { id, name, email, role, is_active };
        this.editModal = true;
    }
}">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Gestion des utilisateurs</h1>
            <p class="text-sm text-slate-600">Créez un caissier, un préparateur, un pharmacien ou un patient.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">
            ← Retour au dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-4 text-rose-800">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[1.2fr_1fr]">
        <div class="bg-white rounded-3xl p-6 shadow-sm">
            <h2 class="text-2xl font-semibold text-slate-900 mb-4">Créer un nouvel utilisateur</h2>
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nom complet</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Mot de passe</label>
                        <input type="password" name="password" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Confirmation</label>
                        <input type="password" name="password_confirmation" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                    </div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Rôle</label>
                        <select name="role" required class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                            <option value="admin">Admin</option>
                            <option value="pharmacien">Pharmacien</option>
                            <option value="preparateur">Préparateur</option>
                            <option value="caissier">Caissier</option>
                            <option value="vendor">Vendor</option>
                            <option value="patient">Patient</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-3">
                        <label class="flex items-center gap-3 text-sm text-slate-700">
                            <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-slate-300 text-slate-600 focus:ring-slate-500"> Actif
                        </label>
                    </div>
                </div>
                <button type="submit" class="rounded-2xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">Créer l'utilisateur</button>
            </form>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm">
            <h2 class="text-2xl font-semibold text-slate-900 mb-4">Utilisateurs existants</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left divide-y divide-slate-200">
                    <thead class="bg-slate-50 text-slate-600 uppercase tracking-[.18em] text-xs">
                        <tr>
                            <th class="px-4 py-3">Nom</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Rôle</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-3">{{ $user->name }}</td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3"><span>{{ ucfirst($user->role) }}</span></td>
                                <td class="px-4 py-3">{!! $user->is_active ? '<span class="text-emerald-600 font-semibold">Actif</span>' : '<span class="text-rose-600 font-semibold">Bloqué</span>' !!}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <button @click="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', {{ $user->is_active ? 'true' : 'false' }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Modifier</button>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div x-show="editModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="editModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="editModal = false" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div x-show="editModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form :action="`/admin/users/${editUser.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Modifier l'utilisateur</h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                                    <input type="text" x-model="editUser.name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" x-model="editUser.email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Rôle</label>
                                    <select x-model="editUser.role" name="role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="admin">Admin</option>
                                        <option value="pharmacien">Pharmacien</option>
                                        <option value="preparateur">Préparateur</option>
                                        <option value="caissier">Caissier</option>
                                        <option value="vendor">Vendor</option>
                                        <option value="patient">Patient</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" x-model="editUser.is_active" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-700">Actif</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nouveau mot de passe (optionnel)</label>
                                    <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                                    <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" :action="`/admin/users/${editUser.id}`" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Mettre à jour
                    </button>
                    <button type="button" @click="editModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
