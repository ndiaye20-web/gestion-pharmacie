#  Guide Complet de Test - Restrictions de Rôles

##  Table des Matières
1. [Configuration Initiale](#configuration-initiale)
2. [Rôles Disponibles](#rôles-disponibles)
3. [Restrictions par Rôle](#restrictions-par-rôle)
4. [Tests via Terminal](#tests-via-terminal)
5. [Tests via Interface Web](#tests-via-interface-web)
6. [Commandes Artisan Utiles](#commandes-artisan-utiles)

---

## Configuration Initiale

### 1. Exécuter la Migration
```bash
php artisan migrate
```

### 2. Créer des Utilisateurs de Test
Exécutez ces commandes dans `php artisan tinker`:

```php
// Créer un Admin
$admin = User::create([
    'name' => 'Admin User',
    'email' => 'admin@pharmacy.test',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'is_active' => true,
]);

// Créer un Pharmacien
$pharmacien = User::create([
    'name' => 'Pharmacien User',
    'email' => 'pharmacien@pharmacy.test',
    'password' => bcrypt('password'),
    'role' => 'pharmacien',
    'is_active' => true,
]);

// Créer un Vendeur
$vendor = User::create([
    'name' => 'Vendor User',
    'email' => 'vendor@pharmacy.test',
    'password' => bcrypt('password'),
    'role' => 'vendor',
    'is_active' => true,
]);

// Créer un Préparateur
$preparateur = User::create([
    'name' => 'Préparateur User',
    'email' => 'preparateur@pharmacy.test',
    'password' => bcrypt('password'),
    'role' => 'preparateur',
    'is_active' => true,
]);
```

---

##  Rôles Disponibles

| Rôle | Couleur | Description |
|------|--------|------------|
| **admin** |  Rouge | Accès total, gestion utilisateurs, commandes |
| **pharmacien** |  Bleu | Gestion patients, ordonnances, médicaments |
| **vendor** |  Vert | Gestion ventes, points de vente |
| **preparateur** |  Violet | Opérateur ventes, gestion médicaments basique |

---

##  Restrictions par Rôle

### Admin (Accès Total) 
-  Tous les modules
-  Gestion des utilisateurs
-  Commandes fournisseurs
-  Médicaments
-  Ventes
-  Ordonnances
-  Patients

### Pharmacien (Santé) 
-  Médicaments
-  Lots
-  Patients
-  Ordonnances
-  Ventes (lecture seule via dashboard)
-  Commandes fournisseurs
-  Utilisateurs

### Vendor (Ventes) 
-  Ventes
-  Dashboard personnel
-  Médicaments
-  Patients
-  Ordonnances
-  Commandes
-  Utilisateurs

### Préparateur (Opérateur) 
-  Ventes
-  Médicaments
-  Lots
-  Patients (lecture)
-  Ordonnances
-  Commandes

---

##  Tests via Terminal

### Test 1: Accès Admin
```bash
# Accès autorisé
php artisan tinker
>>> Auth::loginUsingId(1); // ID de l'admin
>>> Auth::check(); // true
>>> Auth::user()->role; // "admin"
```

### Test 2: Restrictions de Rôle
```php
// Dans tinker, avec user connecté
>>> Auth::user()->role; // Affiche le rôle
```

### Test 3: Test HTTP des Routes
```bash
# Avec cURL (remplacer TOKEN et USER_ID)
curl -X GET http://localhost:8000/medicaments \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

##  Tests via Interface Web

### Scénario de Test 1: Test Admin
1. Connectez-vous avec: `admin@pharmacy.test` / `password`
2. Vérifiez l'affichage du badge  Admin
3. Accédez à:
   -  Médicaments (doit fonctionner)
   -  Lots (doit fonctionner)
   -  Ventes (doit fonctionner)
   -  Ordonnances (doit fonctionner)
   -  Patients (doit fonctionner)
   -  Commandes (doit fonctionner)
   -  Fournisseurs (doit fonctionner)

### Scénario de Test 2: Test Pharmacien
1. Connectez-vous avec: `pharmacien@pharmacy.test` / `password`
2. Vérifiez le badge  Pharmacien
3. Accédez à:
   -  Médicaments (doit fonctionner)
   -  Patients (doit fonctionner)
   -  Ordonnances (doit fonctionner)
   -  Ventes (bouton masqué dans accès rapide)
   -  Commandes (erreur 403)

### Scénario de Test 3: Test Vendeur
1. Connectez-vous avec: `vendor@pharmacy.test` / `password`
2. Vérifiez le badge  Vendor
3. Accédez à:
   -  Ventes (doit fonctionner)
   -  Dashboard spécifique vendeur
   -  Médicaments (erreur 403)
   -  Patients (erreur 403)
   -  Ordonnances (erreur 403)

### Scénario de Test 4: Test Préparateur
1. Connectez-vous avec: `preparateur@pharmacy.test` / `password`
2. Vérifiez le badge  Préparateur
3. Accédez à:
   -  Ventes (doit fonctionner)
   -  Médicaments (doit fonctionner)
   -  Lots (doit fonctionner)
   -  Ordonnances (erreur 403)
   -  Commandes (erreur 403)

---

##  Commandes Artisan Utiles

### Vérifier les Routes
```bash
php artisan route:list
```

### Générer une URL de Test
```php
# Dans tinker
>>> route('medicaments.index'); // URL complète
```

### Activer/Désactiver un Utilisateur
```php
# Dans tinker
>>> $user = User::find(1);
>>> $user->update(['is_active' => false]);
// Après déconnexion, l'utilisateur ne peut plus se connecter
```

### Voir les Utilisateurs
```php
# Dans tinker
>>> User::all();
>>> User::where('role', 'admin')->get();
```

---

##  Vérification de Sécurité

### Test 1: Tentative d'Accès Non Autorisé
```bash
# Connecté en tant que vendeur, accès à médicaments
# Devrait afficher: "Accès non autorisé. Vous n'avez pas les permissions nécessaires."
```

### Test 2: Utilisateur Inactif
```php
# Dans tinker
>>> $user = User::find(1);
>>> $user->update(['is_active' => false]);
# Visitez le site - vous serez immédiatement déconnecté
```

### Test 3: Tentative d'Accès sans Authentification
```
# Visitez /medicaments sans être connecté
# Devrait rediriger vers /login
```

---

##  Dashboard Spécifiques

### Admin Dashboard ‍
- Vue d'ensemble utilisateurs
- Statistiques par rôle
- Commandes fournisseurs récentes
- Utilisateurs récents

### Pharmacien Dashboard 
- Patients récents
- Ordonnances en attente
- Stock faible
- Lots expirés

### Vendor Dashboard 
- Mes ventes
- Performance quotidienne
- Statistiques hebdomadaires
- Actions rapides de vente

### Préparateur Dashboard 
- Activité journalière
- Dernière vente
- Actions rapides

---

##  Débogage

### Afficher l'Utilisateur Actuel
```php
# Dans tinker ou contrôleur
>>> dd(auth()->user());
>>> dd(auth()->user()->role);
>>> dd(auth()->user()->is_active);
```

### Afficher le Message d'Erreur 403
```
# Pour voir le message d'erreur précis, vérifiez app/Http/Middleware/CheckRole.php
```

### Logs de Tentatives d'Accès
```bash
tail -f storage/logs/laravel.log
```

---

##  Checklist de Test Complète

### Avant de Lancer en Production
- [ ] Migration exécutée sans erreur
- [ ] 5 utilisateurs de test créés
- [ ] Admin peut accéder à tous les modules
- [ ] Pharmacien ne peut pas accéder aux ventes
- [ ] Vendor ne peut pas accéder aux patients
- [ ] Préparateur ne peut pas accéder aux ordonnances
- [ ] Utilisateurs inactifs sont déconnectés
- [ ] Messages d'erreur 403 affichés correctement
- [ ] Dashboard affiche les bonnes données par rôle
- [ ] Badges de rôle s'affichent correctement

---

##  Déploiement

Avant de déployer:
1. Exécutez: `php artisan migrate --force`
2. Créez les utilisateurs de production avec les rôles appropriés
3. Testez chaque rôle dans l'environnement de production
4. Vérifiez les logs pour les erreurs 403

---

##  Support & Dépannage

### Erreur 403 non Attendue?
1. Vérifiez le rôle de l'utilisateur: `Auth::user()->role`
2. Vérifiez que le middleware est enregistré dans `bootstrap/app.php`
3. Videz le cache: `php artisan cache:clear`

### Migration Non Appliquée?
```bash
php artisan migrate:rollback
php artisan migrate
```

### Routes Non Mises à Jour?
```bash
php artisan route:cache
php artisan route:clear
```

---

**Créé le:** 3 Mai 2026  
**Système:** Gestion Pharmacy v1.0
