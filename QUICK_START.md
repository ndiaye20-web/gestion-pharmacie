#  GUIDE RAPIDE - Configuration Dashboard & Restrictions

## Étape 1: Exécuter la Migration (30 secondes)

```bash
php artisan migrate
```

## Étape 2: Créer les Utilisateurs de Test (1 minute)

```bash
php artisan tinker
```

Copie-colle ce code exactement dans tinker:

```php
User::create(['name' => 'Admin User', 'email' => 'admin@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'admin', 'is_active' => true]);
User::create(['name' => 'Pharmacien User', 'email' => 'pharmacien@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'pharmacien', 'is_active' => true]);
User::create(['name' => 'Caissier User', 'email' => 'caissier@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'caissier', 'is_active' => true]);
User::create(['name' => 'Vendor User', 'email' => 'vendor@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'vendor', 'is_active' => true]);
User::create(['name' => 'Préparateur User', 'email' => 'preparateur@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'preparateur', 'is_active' => true]);
exit
```

## Étape 3: C'est Prêt! 

Visitez: `http://localhost:8000`

##  Comptes de Test

### Admin (Accès Total)
```
Email: admin@pharmacy.test
Password: password
```

### Pharmacien (Patients & Ordonnances)
```
Email: pharmacien@pharmacy.test
Password: password
```

### Vendor (Ventes)
```
Email: vendor@pharmacy.test
Password: password
```

### Préparateur (Ventes & Médicaments)
```
Email: preparateur@pharmacy.test
Password: password
```

##  Ce que Vous Verrez

### Dashboard Admin 
- Vue complète du système
- Gestion des utilisateurs
- Commandes fournisseurs
- Tous les modules accessibles

### Dashboard Pharmacien 
- Patients récents
- Ordonnances en attente
- Médicaments en stock faible
- Lots expirés

### Dashboard Vendor 
- Mes ventes uniquement
- Performance quotidienne
- Statistiques ventes
- Actions ventes rapides

### Dashboard Préparateur 
- Activité journalière
- Dernière vente
- Ventes et médicaments uniquement

##  Test Rapide (2 minutes)

1. **Connectez-vous en Admin** → Vous devez voir:
   - Tous les modules dans "Accès Rapide"
   - Badge rouge "ADMIN"
   - Dashboard avec stats utilisateurs

2. **Déconnectez-vous, Connectez-vous en Vendeur** → Vous devez voir:
   - UNIQUEMENT "Ventes" dans "Accès Rapide"
   - Badge vert "VENDOR"
   - Dashboard avec stats ventes

3. **Essayez d'accéder à `/medicaments` en tant que Vendeur** → Message:
   ```
   "Accès non autorisé. Vous n'avez pas les permissions nécessaires."
   ```

##  Fichiers Modifiés/Créés

```
 database/migrations/2026_05_04_000000_fix_role_column_size.php
 app/Http/Middleware/CheckRole.php
 app/Http/Controllers/DashboardController.php
 resources/views/dashboard.blade.php
 resources/views/dashboard-sections/admin.blade.php
 resources/views/dashboard-sections/pharmacien.blade.php
 resources/views/dashboard-sections/vendor.blade.php
 resources/views/dashboard-sections/preparateur.blade.php
 routes/web.php
 bootstrap/app.php
 app/Models/User.php
 TESTING_GUIDE.md (guide détaillé)
```

##  Si ça Ne Marche Pas

```bash
# Vider les caches
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Recharger les migrations
php artisan migrate:rollback
php artisan migrate
```

##  Documentation Complète

Pour des tests détaillés et des scénarios avancés, voir: **TESTING_GUIDE.md**

---

**Vous êtes maintenant prêt à tester le système!** 
