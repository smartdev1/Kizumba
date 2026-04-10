# United Kizdom World Congress (UKWC) — Site officiel

Site de billetterie et de présentation du festival **UKWC 2026** (kizomba, Cotonou, Bénin).

**Stack :**

- **Frontend** : Nuxt 3 (Vue 3 + Pinia + Tailwind CSS) — port `3000`
- **Backend** : Laravel 11 (API REST + Sanctum) — port `8000`
- **Base de données** : MySQL
- **Paiement** : PayDunya (mode test en local)

---

## Prérequis

| Outil    | Version minimale |
| -------- | ---------------- |
| Node.js  | 18+              |
| npm      | 9+               |
| PHP      | 8.3+             |
| Composer | 2+               |
| MySQL    | 8+               |

---

## 1. Cloner le projet

```bash
git clone <url-du-repo>
cd Kizumba
```

---

## 2. Backend Laravel

### 2.1 Installer les dépendances

```bash
cd backend
composer install
```

### 2.2 Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

Ouvrir `backend/.env` et ajuster :

```env
# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kizumba
DB_USERNAME=root
DB_PASSWORD=

# URL de l'app (ne pas changer pour le dev local)
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000

# Compte admin créé au seeding
ADMIN_NAME="Admin UKWC"
ADMIN_EMAIL="admin@ukwc.com"
ADMIN_PASSWORD="ukwc2026admin"

# Paiement PayDunya (mode test)
PAYDUNYA_MODE=test
PAYDUNYA_MASTER_KEY=<votre-clé>
PAYDUNYA_PRIVATE_KEY=<votre-clé>
PAYDUNYA_TOKEN=<votre-token>
PAYDUNYA_RETURN_URL=http://localhost:3000/checkout
PAYDUNYA_CANCEL_URL=http://localhost:3000/shop
PAYDUNYA_CALLBACK_URL=http://localhost:8000/api/webhooks/paydunya

# Email (optionnel en local, désactiver ou utiliser Mailtrap)
MAIL_MAILER=log
```

> **Note :** En local, mettre `MAIL_MAILER=log` évite de configurer un serveur SMTP. Les emails seront écrits dans `storage/logs/laravel.log`.

### 2.3 Créer la base de données

```sql
-- Dans MySQL
CREATE DATABASE kizumba CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2.4 Migrer et seeder

```bash
php artisan migrate
php artisan db:seed
```

Le seeder crée automatiquement le compte admin défini dans `.env` (`ADMIN_EMAIL` / `ADMIN_PASSWORD`).

### 2.5 Lancer le backend

```bash
# Serveur API uniquement
php artisan serve

# OU : serveur + queue (recommandé pour les emails et paiements)
composer run dev
```

Le backend est accessible sur **<http://localhost:8000>**.

---

## 3. Frontend Nuxt

### 3.1 Installer les dépendances

```bash
# Depuis la racine du projet (pas dans /backend)
cd ..   # si vous étiez dans /backend
npm install
```

### 3.2 Configurer l'environnement

```bash
cp .env.example .env
```

Le fichier `.env` du frontend contient :

```env
NUXT_PUBLIC_API_BASE_URL=/api-proxy
NUXT_API_BACKEND_URL=http://localhost:8000/api
```

Ces valeurs sont correctes pour le dev local, **aucune modification nécessaire**.

### 3.3 Lancer le frontend

```bash
npm run dev
```

Le site est accessible sur **<http://localhost:3000>**.

---

## 4. Vérification

| URL                                      | Description             |
| ---------------------------------------- | ----------------------- |
| <http://localhost:3000>                  | Page d'accueil publique |
| <http://localhost:3000/shop>             | Boutique de billets     |
| <http://localhost:3000/admin/login>      | Interface admin         |
| <http://localhost:8000/api/tickets>      | Endpoint API (JSON)     |

**Identifiants admin :**

- Email : `admin@ukwc.com`
- Mot de passe : `ukwc2026admin`

---

## 5. Architecture

```text
Kizumba/
├── [Frontend Nuxt]         ← racine du projet
│   ├── pages/              ← routes publiques et admin
│   ├── components/         ← composants Vue
│   ├── stores/             ← état global (Pinia)
│   ├── composables/        ← useApi(), useAdminApi()
│   ├── server/routes/      ← proxy API (api-proxy → backend)
│   └── assets/             ← images, polices, CSS
│
└── backend/                ← API Laravel
    ├── app/
    │   ├── Models/         ← Ticket, Payment, Artist, PromoCode…
    │   ├── Http/Controllers/Api/    ← endpoints publics
    │   └── Http/Controllers/Admin/ ← endpoints admin (auth requise)
    ├── database/migrations/
    ├── routes/api.php
    └── storage/
```

**Flux des requêtes :**

```text
Navigateur → Nuxt (/api-proxy/…) → [proxy serveur Nuxt] → Laravel (/api/…) → MySQL
```

Le proxy Nuxt (`server/routes/api-proxy/[...path].ts`) évite les problèmes CORS en dev.

---

## 6. Commandes utiles

### Backend

```bash
# Relancer toutes les migrations (repart de zéro)
php artisan migrate:fresh --seed

# Créer un admin manuellement via tinker
php artisan tinker
>>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@ukwc.com','password'=>bcrypt('motdepasse'),'role'=>'admin'])

# Voir les logs en temps réel
php artisan pail

# Écouter la queue manuellement
php artisan queue:listen
```

### Frontend

```bash
npm run build    # Build de production
npm run preview  # Prévisualiser le build de production
```

---

## 7. Fonctionnalités principales

- Présentation des artistes et du programme
- Vente de billets avec tarification early bird
- Codes promo (réduction fixe ou pourcentage)
- Paiement via PayDunya (CB, mobile money)
- Génération de QR codes et envoi des billets par email
- Interface admin : gestion des billets, artistes, commandes, codes promo, validation QR

---

## 8. Dépannage fréquent

**`php artisan serve` ne démarre pas**
→ Vérifier que PHP 8.3+ est installé : `php -v`

**Erreur de connexion à la BDD**
→ Vérifier que MySQL tourne et que `DB_DATABASE=kizumba` existe

**Frontend ne charge pas les billets**
→ S'assurer que le backend tourne sur le port 8000 (`php artisan serve`)

**Emails non reçus**
→ En local, utiliser `MAIL_MAILER=log` ; les emails sont dans `backend/storage/logs/laravel.log`

**Webhook PayDunya ne reçoit rien**
→ Normal en local sans tunnel (ngrok). Les paiements peuvent être validés manuellement via l'interface admin.
