<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicament;
use App\Models\Lot;
use App\Models\Vente;
use App\Models\Patient;
use App\Models\Fournisseur;
use App\Models\CommandeFournisseur;
use App\Models\Ordonnance;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function stock()
    {
        return view('stock');
    }

    public function pos()
    {
        return view('pos');
    }

    public function users()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:admin,pharmacien,preparateur,caissier,vendor,patient',
            'is_active' => 'nullable|boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'is_active' => $request->has('is_active'),
        ]);

        if ($validated['role'] === 'patient') {
            if (! $user->patient) {
                $nameParts = explode(' ', trim($validated['name']), 2);
                Patient::create([
                    'user_id' => $user->id,
                    'nom' => $nameParts[0] ?? $validated['name'],
                    'prenom' => $nameParts[1] ?? '',
                ]);
            }
        }

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès.');
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,pharmacien,preparateur,caissier,vendor,patient',
            'is_active' => 'nullable|boolean',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|confirmed|min:6',
            ]);
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function deleteUser(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès.');
    }

    public function index()
    {
$user = auth()->user() ?? (object)['name' => 'Visiteur', 'role' => 'guest', 'email' => ''];

        // Données générales (accessibles à tous)
        $nbMedicaments = Medicament::count();
        $nbVentes = Vente::count();
        $totalVentes = Vente::sum('total');
        $stockTotal = Lot::sum('quantite');

        // Alertes lots expirés
        $expires = Lot::where('date_expiration', '<', Carbon::today())->count();

        // Alertes stock faible (moins de 10 unités par médicament)
        $lowStock = Medicament::withSum('lots', 'quantite')
            ->get()
            ->filter(function ($medicament) {
                return $medicament->lots_sum_quantite < 10;
            })
            ->count();

        // Données pour le graphique (ventes des 7 derniers jours)
        $ventesParJour = [];
        $joursLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $joursLabels[] = $date->format('d/m');
            $total = Vente::whereDate('created_at', $date)->sum('total');
            $ventesParJour[] = $total;
        }

        // Données additionnelles selon le rôle
        $additionalData = [];

        if (auth()->check()) {
            switch ($user->role) {
                case 'admin':
                    $additionalData = $this->getAdminData();
                    break;
                case 'pharmacien':
                    $additionalData = $this->getPharmacistData();
                    break;
                case 'caissier':
                    $additionalData = $this->getCaissierData();
                    break;
                case 'preparateur':
                    $additionalData = $this->getStaffData();
                    break;
                case 'vendor':
                    $additionalData = $this->getVendorData();
                    break;
                case 'patient':
                    $additionalData = $this->getPatientData();
                    break;
            }
        }

        return view('dashboard', compact(
            'nbMedicaments',
            'nbVentes',
            'totalVentes',
            'stockTotal',
            'expires',
            'lowStock',
            'ventesParJour',
            'joursLabels',
            'additionalData',
            'user'
        ));
    }

    private function getAdminData()
    {
        return [
            'nbUsers' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'nbFournisseurs' => Fournisseur::count(),
            'totalCommandes' => CommandeFournisseur::sum('total'),
            'commandesPendantes' => CommandeFournisseur::where('statut', 'en_attente')->count(),
            'commandesRecues' => CommandeFournisseur::where('statut', 'reçue')->count(),
            'recentCommands' => CommandeFournisseur::orderBy('date_commande', 'desc')->limit(5)->get(),
            'recentUsers' => User::orderBy('created_at', 'desc')->limit(5)->get(),
            'roleCounts' => User::selectRaw('role, count(*) as count')->groupBy('role')->get(),
        ];
    }

    private function getPharmacistData()
    {
        return [
            'nbPatients' => Patient::count(),
            'nbOrdonnances' => Ordonnance::count(),
            'ordonnancesEnAttente' => Ordonnance::where('statut', 'en_attente')->count(),
            'ordonnancesCompletees' => Ordonnance::where('statut', 'traitee')->count(),
            'medicamentsRecherches' => Medicament::count(),
            'recentPatients' => Patient::orderBy('id', 'desc')->limit(5)->get(),
            'recentOrdonnances' => Ordonnance::orderBy('date_prescription', 'desc')->limit(5)->get(),
        ];
    }

    private function getCaissierData()
    {
        $derniereVente = Vente::with('patient')->orderBy('created_at', 'desc')->first();

        return [
            'ventes' => Vente::count(),
            'ventesAujourdhui' => Vente::whereDate('created_at', Carbon::today())->sum('total'),
            'ventesSemaine' => Vente::where('date', '>=', Carbon::today()->subDays(6))->sum('total'),
            'derniereVente' => $derniereVente,
        ];
    }

    private function getVendorData()
    {
        return [
            'mesVentes' => Vente::count(),
            'montantVentes' => Vente::sum('total'),
            'ventesAujourdhui' => Vente::whereDate('created_at', Carbon::today())->sum('total'),
            'ventesHebdomadaires' => Vente::where('created_at', '>=', Carbon::now()->subWeek())->sum('total'),
            'ventes7j' => $this->getVentes7Jours(),
        ];
    }

    private function getStaffData()
    {
        return [
            'ventes' => Vente::count(),
            'ventesAujourdhui' => Vente::whereDate('created_at', Carbon::today())->sum('total'),
            'derniereVente' => Vente::orderBy('created_at', 'desc')->first(),
        ];
    }

    private function getPatientData()
    {
        $patient = auth()->user()->patient;

        if (!$patient) {
            return [
                'message' => 'Votre dossier patient n’est pas encore lié. Contactez votre pharmacie pour l’activer.',
                'ordonnances' => collect(),
                'totalOrdonnances' => 0,
                'ordonnancesEnAttente' => 0,
                'rappels' => 0,
                'accountCreated' => auth()->user()->created_at ? auth()->user()->created_at->format('d/m/Y') : null,
            ];
        }

        $ordonnances = $patient->ordonnances()->orderBy('date_prescription', 'desc')->limit(5)->get();

        return [
            'message' => 'Suivez votre historique d’ordonnances, vos rappels et vos renouvellements.',
            'patient' => $patient,
            'ordonnances' => $ordonnances,
            'totalOrdonnances' => $patient->ordonnances()->count(),
            'ordonnancesEnAttente' => $patient->ordonnances()->where('statut', 'en_attente')->count(),
            'rappels' => $patient->ordonnances()->where('renouvellements', '>', 0)->count(),
            'accountCreated' => auth()->user()->created_at ? auth()->user()->created_at->format('d/m/Y') : null,
        ];
    }

    private function getVentes7Jours()
    {
        $ventes = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $ventes[$date->format('Y-m-d')] = Vente::whereDate('created_at', $date)->count();
        }
        return $ventes;
    }
}
