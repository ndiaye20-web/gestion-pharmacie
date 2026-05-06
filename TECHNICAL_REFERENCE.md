#  RÉFÉRENCE TECHNIQUE - Dashboard & Restrictions

##  Architecture du Système

```

         Utilisateur Authentifié             
         (avec rôle & is_active)             

             
             

      Middleware CheckRole                   
  (Vérifie rôle + utilisateur actif)        

             
              Rôle valide? → Accès Accordé 
              Rôle invalide? → Erreur 403 
```

##  Matrice de Permissions

| Route | Admin | Pharmacien | Caissier | Préparateur | Vendor | Patient |
|-------|:-----:|:----------:|:--------:|:-----------:|:------:|:-------:|
| `/medicaments` | ✓ | ✓ |  | ✓ |  |  |
| `/lots` | ✓ | ✓ |  | ✓ |  |  |
| `/ventes` | ✓ |  | ✓ | ✓ | ✓ |  |
| `/patients` | ✓ | ✓ |  | ✓ |  |  |
| `/ordonnances` | ✓ | ✓ |  |  |  |  |
| `/commandes` | ✓ |  |  | ✓ |  |  |
| `/fournisseurs` | ✓ |  |  |  |  |  |
| `/dashboard/caissier` |  |  | ✓ |  |  |  |
| `/dashboard/pharmacien` |  | ✓ |  |  |  |  |
| `/dashboard/preparateur` |  |  |  | ✓ |  |  |
| `/dashboard/patient` |  |  |  |  |  | ✓ |
| `/pos` |  |  | ✓ |  |  |  |
| `/stock` |  |  |  | ✓ |  |  |
| `/` (Dashboard) | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |

##  Composants Techniques

### 1. Migration (Database)
**Fichier:** `database/migrations/2026_05_04_000000_fix_role_column_size.php`

Ajoute deux colonnes à la table `users`:
- `role` (string): admin, pharmacien, caissier, preparateur, vendor, patient
- `is_active` (boolean): pour désactiver rapidement un compte

### 2. Middleware (Sécurité)
**Fichier:** `app/Http/Middleware/CheckRole.php`

Fonction:
```php
public function handle($request, Closure $next, ...$roles)
{
    // 1. Vérifier l'authentification
    // 2. Vérifier que l'utilisateur est actif
    // 3. Vérifier que le rôle est dans la liste autorisée
}
```

### 3. Contrôleur Dashboard
**Fichier:** `app/Http/Controllers/DashboardController.php`

Récupère différentes données selon le rôle:
```php
public function index()
{
    // Données générales (tous les rôles)
    $nbMedicaments = Medicament::count();
    
    // Données spécifiques au rôle
    if ($user->role === 'admin') {
        $additionalData = $this->getAdminData();
    } else if ($user->role === 'pharmacien') {
        $additionalData = $this->getPharmacienData();
    }
    // etc...
}
```

### 4. Routes avec Restrictions
**Fichier:** `routes/web.php`

```php
// Exemple: Accessible à Admin, Pharmacien, Préparateur
Route::middleware('role:admin,pharmacien,preparateur')->group(function () {
    Route::resource('medicaments', MedicamentController::class);
});

// Exemple: Accessible à Admin UNIQUEMENT
Route::middleware('role:admin')->group(function () {
    Route::resource('commandes', CommandeFournisseurController::class);
});
```

### 5. Vues Dynamiques (Frontend)
**Fichier:** `resources/views/dashboard.blade.php`

```blade
@if ($user->role === 'admin')
    @include('dashboard-sections.admin', ['data' => $additionalData])
@elseif ($user->role === 'pharmacien')
    @include('dashboard-sections.pharmacien', ['data' => $additionalData])
@endif
```

##  Flux Complet d'une Requête

```
1. Utilisateur visite /medicaments
   ↓
2. Laravel vérifie middleware 'auth' → Est-il connecté?
    NON → Redirection /login
    OUI → Continuer
   ↓
3. Laravel vérifie middleware 'role:admin,pharmacien,preparateur'
    Rôle Non Autorisé → Erreur 403
    Rôle Autorisé → Continuer
   ↓
4. Vérifie que is_active === true
    is_active = false → Déconnexion + redirection /login
    is_active = true → Continuer
   ↓
5. Exécute MedicamentController@index
   ↓
6. Retourne vue 'medicaments.index' avec données
```

##  Modèle de Données

### Table Users
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'pharmacien', 'vendor', 'preparateur') DEFAULT 'preparateur',
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Exemple de Requête
```php
// Obtenir tous les admins actifs
$admins = User::where('role', 'admin')
              ->where('is_active', true)
              ->get();
```

##  Dashboard Personnalisés

### Données Admin
```php
[
    'nbUsers' => int,
    'activeUsers' => int,
    'nbFournisseurs' => int,
    'totalCommandes' => decimal,
    'commandesPendantes' => int,
    'commandesRecues' => int,
    'recentCommands' => Collection,
    'recentUsers' => Collection,
    'roleCounts' => Collection
]
```

### Données Pharmacien
```php
[
    'nbPatients' => int,
    'nbOrdonnances' => int,
    'ordonnancesEnAttente' => int,
    'ordonnancesCompletees' => int,
    'medicamentsRecherches' => int,
    'recentPatients' => Collection,
    'recentOrdonnances' => Collection
]
```

### Données Vendor
```php
[
    'miesVentes' => int,
    'montantVentes' => decimal,
    'ventesAujourdhui' => decimal,
    'ventesHebdomadaires' => decimal,
    'ventes7j' => array
]
```

### Données Préparateur
```php
[
    'ventes' => int,
    'ventesAujourdhui' => decimal,
    'derniereVente' => Model
]
```

##  Points de Vérification

### Vérifier l'Authentification
```php
if (auth()->check()) {
    echo "Connecté en tant que: " . auth()->user()->name;
}
```

### Vérifier le Rôle
```php
if (auth()->user()->role === 'admin') {
    echo "Vous êtes Admin";
}
```

### Vérifier l'Activation
```php
if (auth()->user()->is_active) {
    echo "Compte actif";
} else {
    echo "Compte désactivé";
}
```

##  Exemples de Test

### Test Avec Artisan Tinker

```bash
php artisan tinker

# Authentifier en tant qu'admin
>>> Auth::loginUsingId(1);

# Vérifier le rôle
>>> Auth::user()->role;
// "admin"

# Vérifier l'état
>>> Auth::user()->is_active;
// true

# Désactiver l'utilisateur
>>> Auth::user()->update(['is_active' => false]);

# À la prochaine requête, il sera déconnecté
```

### Test Avec Postman/Curl

```bash
# 1. Obtenir le cookie de session en vous connectant
curl -c cookies.txt -X POST http://localhost:8000/login \
  -d "email=admin@pharmacy.test&password=password"

# 2. Accéder à une route protégée avec le cookie
curl -b cookies.txt http://localhost:8000/medicaments
```

##  Statistiques Dashboard

### Graphique Ventes (7 Jours)
- Type: Chart.js Line Chart
- Données: `$ventesParJour` (array de nombres)
- Labels: `$joursLabels` (array de dates)
- Formattage: Valeurs en euros

### Cartes KPI
- **Médicaments**: Nombre total de médicaments
- **Ventes**: Nombre total de transactions
- **Chiffre d'Affaires**: Total en euros
- **Stock**: Unités totales

##  Sécurité

### Protections Implémentées
1.  Authentification obligatoire
2.  Vérification du rôle
3.  Vérification de l'activation
4.  Erreur 403 explicite

### Meilleures Pratiques
1. Jamais de rôle stocké côté client
2. Vérification du rôle à chaque requête
3. Logs des tentatives d'accès non autorisé
4. Déconnexion auto si désactivé

##  Débogage

### Logger l'Authentification
```php
// Dans un contrôleur
Log::info('Utilisateur ' . auth()->user()->name . ' accède à medicaments');
```

### Logger les Erreurs 403
```php
// Dans bootstrap/app.php ou middleware personnalisé
Log::warning('Accès refusé: ' . auth()->user()->email . ' tentant d\'accéder à ' . $request->path());
```

---

**Système complet de gestion de rôles et permissions**  
**Créé:** 3 Mai 2026
