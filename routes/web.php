<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicamentController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\OrdonnanceController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\CommandeFournisseurController;

// Routes d'authentification (sans auth middleware)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Page d'accueil publique (guest) et tableau de bord authentifié
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard/caissier', [DashboardController::class, 'index'])->middleware('auth','role:caissier')->name('dashboard.caissier');
Route::get('/pos', [DashboardController::class, 'pos'])->middleware('auth','role:caissier')->name('pos');
Route::get('/dashboard/pharmacien', [DashboardController::class, 'index'])->middleware('auth','role:pharmacien')->name('dashboard.pharmacien');
Route::get('/dashboard/preparateur', [DashboardController::class, 'index'])->middleware('auth','role:preparateur')->name('dashboard.preparateur');
Route::get('/stock', [DashboardController::class, 'stock'])->middleware('auth','role:preparateur')->name('stock');
Route::get('/dashboard/patient', [DashboardController::class, 'index'])->middleware('auth','role:patient')->name('dashboard.patient');

Route::middleware('auth')->group(function () {

    // Médicaments et Lots: admin, pharmacien, preparateur
    Route::middleware('role:admin,pharmacien,preparateur')->group(function () {
        Route::resource('medicaments', MedicamentController::class);
        Route::resource('lots', LotController::class);
    });

    // Ventes et Tickets: admin, caissier, preparateur, vendor
    Route::middleware('role:admin,caissier,preparateur,vendor')->group(function () {
        Route::resource('ventes', VenteController::class);
        Route::get('/ventes/{id}/ticket', [TicketController::class, 'generatePDF'])->name('tickets.pdf');
    });

    // Ordonnances: admin, pharmacien
    Route::middleware('role:admin,pharmacien')->group(function () {
        Route::resource('ordonnances', OrdonnanceController::class);
        Route::get('ordonnances/{id}/vente', [OrdonnanceController::class, 'transformer'])
            ->name('ordonnances.vente');
    });

    // Patients: admin, pharmacien, preparateur
    Route::middleware('role:admin,pharmacien,preparateur')->group(function () {
        Route::resource('patients', PatientController::class);
    });

    // Fournisseurs et Commandes: admin + preparateur
    Route::middleware('role:admin,preparateur')->group(function () {
        Route::resource('commandes', CommandeFournisseurController::class);
        Route::get('commandes/{id}/reception',
            [CommandeFournisseurController::class, 'reception']
        )->name('commandes.reception');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('fournisseurs', FournisseurController::class);

        Route::get('admin/users', [DashboardController::class, 'users'])->name('admin.users');
        Route::post('admin/users', [DashboardController::class, 'storeUser'])->name('admin.users.store');
        Route::put('admin/users/{user}', [DashboardController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('admin/users/{user}', [DashboardController::class, 'deleteUser'])->name('admin.users.destroy');
    });
});
