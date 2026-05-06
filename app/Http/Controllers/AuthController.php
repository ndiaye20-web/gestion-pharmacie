<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended($this->dashboardRouteFor(Auth::user()))->with('success', 'Connecté avec succès!');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Déconnecté avec succès!');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'patient',
            'is_active' => true,
        ]);

        $nameParts = explode(' ', trim($validated['name']), 2);
        Patient::create([
            'user_id' => $user->id,
            'nom' => $nameParts[0] ?? $validated['name'],
            'prenom' => $nameParts[1] ?? '',
        ]);

        Auth::login($user);

        // Redirection selon le rôle
        return $this->redirectAfterRegistration($user);
    }

    private function redirectAfterRegistration(User $user)
    {
        $message = 'Bienvenue ' . $user->name . '! Votre compte a été créé avec succès.';

        switch ($user->role) {
            case 'admin':
                return redirect()->route('dashboard')->with('success', $message . ' Vous avez accès à toutes les fonctionnalités administratives.');
            case 'pharmacien':
                return redirect()->route('dashboard.pharmacien')->with('success', $message . ' Vous pouvez gérer les médicaments, ordonnances et patients.');
            case 'preparateur':
                return redirect()->route('dashboard.preparateur')->with('success', $message . ' Gestion stock, commandes fournisseurs, réceptions.');
            case 'caissier':
                return redirect()->route('dashboard.caissier')->with('success', $message . ' Ventes au comptoir, encaissement, tickets.');
            case 'vendor':
                return redirect()->route('dashboard')->with('success', $message . ' Vous pouvez gérer les ventes et consulter les statistiques.');
            case 'patient':
                return redirect()->route('dashboard.patient')->with('success', $message . ' Espace personnel, historique ordonnances, rappels.');
            default:
                return redirect()->route('dashboard')->with('success', $message);
        }
    }

    private function dashboardRouteFor(User $user)
    {
        switch ($user->role) {
            case 'pharmacien':
                return route('dashboard.pharmacien');
            case 'preparateur':
                return route('dashboard.preparateur');
            case 'caissier':
                return route('dashboard.caissier');
            case 'patient':
                return route('dashboard.patient');
            default:
                return route('dashboard');
        }
    }
}
