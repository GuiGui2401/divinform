# Ferme Divinform — Backend Laravel 12

API REST sécurisée de la **Ferme Divinform** (vente directe de produits fermiers).

**Stack :** Laravel 12 · PHP 8.2 · MySQL · JWT Auth (tymon/jwt-auth) · Intervention Image v3

---

## ⚡ Installation

```bash
# 1. Dépendances
composer install

# 2. Environnement
cp .env.example .env    # ou créer .env à la main
# → Éditer .env : DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD, FRONTEND_URL, APP_URL

# 3. Clés
php artisan key:generate
php artisan jwt:secret

# 4. Base de données
php artisan migrate
php artisan db:seed

# 5. Symlink storage
php artisan storage:link

# 6. Démarrer
php artisan serve --port=8000
```

> Le schéma (categories / products / product_specs / settings / users) est générique.
> Tout le contenu de la ferme vit dans les seeders (`database/seeders/`) et le registre
> de réglages `config/site_settings.php`. Pour recharger le contenu :
> `php artisan migrate:fresh --seed`.

---

## 🔐 Crédentiels par défaut

| Rôle        | Email                  | Mot de passe |
|-------------|------------------------|--------------|
| Super Admin | admin@divinform.com    | Admin@2025   |
| Éditeur     | gestion@divinform.com  | Editor@2025  |

> ⚠️ Changer ces mots de passe en production.

---

## 📡 Endpoints

### Public (sans auth)
```
POST   /api/auth/login
GET    /api/v1/categories
GET    /api/v1/categories/{slug}
GET    /api/v1/products              ?search= &category= &featured= &page=
GET    /api/v1/products/{slug}
POST   /api/v1/products/{id}/view
POST   /api/v1/products/{id}/contact
GET    /api/v1/settings
```

### Admin (Bearer JWT requis)
```
GET    /api/auth/me
POST   /api/auth/logout
POST   /api/auth/refresh

GET    /api/admin/stats
GET|POST|PUT|DELETE  /api/admin/categories/{id?}
GET|POST|PUT|DELETE  /api/admin/products/{id?}
POST   /api/admin/products/{id}/images
DELETE /api/admin/products/{id}/images/{index}
GET|PUT  /api/admin/settings
GET|POST|PUT|DELETE  /api/admin/users/{id?}
```

---

## 🧪 Tests

```bash
php artisan test
php artisan test --coverage
```

---

## 🚀 Production (déploiement actuel)

Servi sur **https://admin.divinform.com** (hébergement ISPConfig, nginx + php-fpm 8.2).

- Document root nginx : `.../divinform/divinform-api/public`
- Base MySQL : `c0divinform`
- `.env` : `APP_ENV=production`, `APP_URL=https://admin.divinform.com`,
  `FRONTEND_URL=https://divinform.com` (indispensable pour le CORS),
  drivers `file`/`sync` (pas de tables sessions/cache/jobs).

```nginx
server {
    listen 443 ssl;
    server_name admin.divinform.com;
    root /var/www/.../divinform/divinform-api/public;
    index index.php;

    location / { try_files $uri $uri/ /index.php?$query_string; }
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

> ⚠️ App Laravel : `open_basedir` du pool php-fpm doit inclure la **racine de l'app**
> (au-dessus de `public/`), sinon `vendor/` et `storage/` sont inaccessibles.

```bash
# Optimisations production
php artisan config:cache
php artisan route:cache
php artisan optimize
```

---

**Contact :** contact@divinform.com · +237 696 809 909
