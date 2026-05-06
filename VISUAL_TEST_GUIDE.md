#  GUIDE VISUEL - Comment Tester les Restrictions

##  Table des Matières
1. [Setup Initial](#setup-initial)
2. [Test Admin](#test-admin)
3. [Test Pharmacien](#test-pharmacien)
4. [Test Vendor](#test-vendor)
5. [Test Préparateur](#test-preparateur)
6. [Test Sécurité](#test-sécurité)

---

##  Setup Initial (5 minutes)

### 1⃣ Exécuter la Migration
```bash
cd c:\xampp\htdocs\Gestion_de_Pharmacie
php artisan migrate
```
**Résultat attendu:**  Migration créée sans erreur

---

### 2⃣ Créer les Utilisateurs de Test

**Option A: Avec Tinker (Recommandé)**
```bash
php artisan tinker
```

Copiez-collez ceci dans tinker (une ligne à la fois):

```php
User::create(['name' => 'Admin User', 'email' => 'admin@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'admin', 'is_active' => true]);
```

```php
User::create(['name' => 'Pharmacien User', 'email' => 'pharmacien@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'pharmacien', 'is_active' => true]);
User::create(['name' => 'Caissier User', 'email' => 'caissier@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'caissier', 'is_active' => true]);
```

```php
User::create(['name' => 'Vendor User', 'email' => 'vendor@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'vendor', 'is_active' => true]);
```

```php
User::create(['name' => 'Préparateur User', 'email' => 'preparateur@pharmacy.test', 'password' => bcrypt('password'), 'role' => 'preparateur', 'is_active' => true]);
```

```php
exit
```

**Résultat attendu:**  5 messages "Illuminate\Database\Eloquent\Model"

### 3⃣ Vérifier que les Utilisateurs sont Créés

Toujours dans tinker:
```php
User::all();
```

**Résultat attendu:**  Liste de 6 utilisateurs (1 ancien + 5 nouveaux)

---

##  Test Admin - Accès Total

### Étape 1: Se Connecter
```
URL: http://localhost:8000/login
Email: admin@pharmacy.test
Password: password
```

### Étape 2: Vérifier le Dashboard
Après connexion, vous devez voir:

 **Badge rouge "ADMIN"** en haut à droite  
 **Nom:** Admin User  
 **Email:** admin@pharmacy.test

### Étape 3: Vérifier les KPI
Les 4 cartes principales doivent afficher:
```
 Médicaments: X
 Ventes: X
 Chiffre d'Affaires: X€
 Stock Total: X
```

### Étape 4: Vérifier les Données Admin
Vous devez voir:
```
 Gestion Utilisateurs
   • Utilisateurs Total: 5
   • Utilisateurs Actifs: 5
   • Rôles: Admin, Pharmacien, Vendor, Préparateur

 Commandes Fournisseurs
   • En Attente: 0
   • Reçues: 0
   • Total: 0€
```

### Étape 5: Tester l'Accès Rapide
Cliquez sur "Accès Rapide". Vous devez voir:
```
 → Médicaments
 → Lots
 → Ventes
 → Nouvelle Vente
 → Ordonnances
 → Commandes
```
**TOUS les liens doivent être présents!**

### Étape 6: Vérifier l'Accès Complet
Cliquez sur chaque lien:
```
→ Médicaments     Doit fonctionner
→ Lots            Doit fonctionner
→ Ventes          Doit fonctionner
→ Ordonnances     Doit fonctionner
→ Commandes       Doit fonctionner
```

### Résultat  Test Admin Réussi
L'admin a accès à TOUS les modules!

---

##  Test Pharmacien - Patients & Ordonnances

### Étape 1: Se Déconnecter
Cliquez sur **" Déconnexion"** en haut à droite

### Étape 2: Se Connecter en Pharmacien
```
Email: pharmacien@pharmacy.test
Password: password
```

### Étape 3: Vérifier le Badge
Vous devez voir le badge **bleu "PHARMACIST"**

### Étape 4: Vérifier le Dashboard Pharmacien
Vous devez voir:
```
 Patients
   • Total: X
   • Bouton "Voir tous les patients"

 Ordonnances
   • Complétées: X
   • Total: X
   • Bouton "Gérer les ordonnances"
```

### Étape 5: Vérifier l'Accès Rapide
Vous devez voir:
```
 → Médicaments
 → Lots
 Pas de "Ventes"
 Pas de "Commandes"
```

### Étape 6: Tester les Restrictions
1. Cliquez sur → Médicaments →  Doit fonctionner
2. Cliquez sur → Ordonnances →  Doit fonctionner
3. Essayez d'accéder à `/ventes` (tapez dans URL) →  Erreur 403

### Résultat Attendu pour Erreur 403
```
Accès non autorisé. Vous n'avez pas les 
permissions nécessaires.
```

### Résultat  Test Pharmacien Réussi
Le pharmacien ne peut accéder qu'aux modules autorisés!

---

##  Test Vendor - Ventes Uniquement

### Étape 1: Se Déconnecter & Se Reconnecter
```
Email: vendor@pharmacy.test
Password: password
```

### Étape 2: Vérifier le Badge
Badge **vert "VENDOR"** doit s'afficher

### Étape 3: Vérifier le Dashboard Vendor
Vous devez voir:
```
 Mes Ventes
   • Total: X
   • Aujourd'hui: X€

 Cette Semaine
   • Total (7 derniers jours): X€

 Performance Quotidienne
   • Graphique sur 7 jours
```

### Étape 4: Vérifier l'Accès Rapide
Vous devez voir SEULEMENT:
```
 → Ventes
 → Nouvelle Vente
 Pas de Médicaments
 Pas de Patients
 Pas d'Ordonnances
 Pas de Commandes
```

### Étape 5: Tester les Restrictions
1. Cliquez sur → Ventes →  Doit fonctionner
2. Essayez `/medicaments` (URL direct) →  Erreur 403
3. Essayez `/patients` (URL direct) →  Erreur 403
4. Essayez `/ordonnances` (URL direct) →  Erreur 403

### Résultat  Test Vendor Réussi
Le vendeur ne peut accéder qu'aux ventes!

---

##  Test Préparateur - Opérateur

### Étape 1: Se Déconnecter & Se Reconnecter
```
Email: preparateur@pharmacy.test
Password: password
```

### Étape 2: Vérifier le Badge
Badge **violet "STAFF"** doit s'afficher

### Étape 3: Vérifier le Dashboard Préparateur
Vous devez voir:
```
 Activité Journalière
   • Ventes enregistrées: X
   • Montant aujourd'hui: X€

 Dernière Vente
   • Affichage de la dernière vente
```

### Étape 4: Vérifier l'Accès Rapide
Vous devez voir:
```
 → Médicaments
 → Lots
 → Ventes
 → Nouvelle Vente
 Pas d'Ordonnances
 Pas de Commandes
```

### Étape 5: Tester les Restrictions
1. Cliquez sur → Ventes →  OK
2. Cliquez sur → Médicaments →  OK
3. Essayez `/ordonnances` →  Erreur 403
4. Essayez `/commandes` →  Erreur 403

### Résultat  Test Préparateur Réussi
Le preparateur peut accéder à ventes et médicaments!

---

##  Test Sécurité - Utilisateur Désactivé

### Étape 1: Désactiver un Utilisateur
Ouvrez un terminal tinker:
```bash
php artisan tinker
>>> User::find(1)->update(['is_active' => false]);
>>> exit
```

### Étape 2: Essayer de Se Reconnecter
1. Se déconnecter (si connecté)
2. Essayer de se connecter avec: `admin@pharmacy.test` / `password`

### Résultat Attendu 
```
Votre compte a été désactivé.
(redirection vers login)
```

### Étape 3: Réactiver l'Utilisateur
```bash
php artisan tinker
>>> User::find(1)->update(['is_active' => true]);
>>> exit
```

### Étape 4: Se Reconnecter
Devrait fonctionner à nouveau! 

---

##  Résumé des Tests

| Test | Statut | Notes |
|------|--------|-------|
| Admin accès total |  | Tous les modules visibles |
| Admin dashboard |  | Affiche stats utilisateurs |
| Pharmacien restrictions |  | Pas accès ventes |
| Pharmacien dashboard |  | Affiche patients/ordonnances |
| Vendor accès ventes |  | Uniquement ventes |
| Vendor dashboard |  | Stats ventes personnelles |
| Préparateur restrictions |  | Pas accès ordonnances |
| Préparateur dashboard |  | Activité journalière |
| Utilisateur désactivé |  | Déconnexion immédiate |
| Erreur 403 |  | Message clair |

---

##  Captures d'Écran Attendues

### Dashboard Admin
```

   Gestion Pharmacy               ADMIN         
  Admin User (admin@pharmacy.test)                   

   Médicaments: X |  Ventes: X |  CA: X€      
   Utilisateurs |  Commandes |  Ordonnances  
   Graphique ventes 7 jours                        

```

### Dashboard Vendor
```

   Gestion Pharmacy              VENDOR         
  Vendor User (vendor@pharmacy.test)                 

   Mes Ventes: X | Aujourd'hui: X€                
   Cette Semaine: X€                              
   Performance Quotidienne                         
   Nouvelle Vente   Historique                  

```

---

##  Si Quelque Chose Ne Marche Pas

### Erreur: "Class not found"
```bash
php artisan cache:clear
php artisan config:clear
```

### Erreur: "migration not found"
```bash
php artisan migrate:rollback
php artisan migrate
```

### Erreur: "Invalid role"
```bash
php artisan tinker
>>> User::find(1)->role; # Vérifiez le rôle
```

### Les Boutons d'Accès Rapide ne Changent Pas?
```bash
php artisan view:clear
# Recharger la page dans le navigateur (Ctrl+Shift+R)
```

---

##  Checklist Final

- [ ] Migration exécutée
- [ ] 5 utilisateurs créés
- [ ] Admin accès total OK
- [ ] Pharmacien restrictions OK
- [ ] Vendor accès limité OK
- [ ] Préparateur accès limité OK
- [ ] Erreurs 403 affichées
- [ ] Utilisateur désactivé fonctionne
- [ ] Tous les dashboards affichent les bonnes données

---

**Félicitations! Votre système est complet et sécurisé!** 

**Prêt pour la production!** 
