# Medex65 — Backend Laravel 11

API REST sécurisée pour MEDEX SARL.

**Stack :** Laravel 11 · PHP 8.2 · MySQL 8 · JWT Auth · Intervention Image v3

---

## ⚡ Installation

```bash
# 1. Dépendances
composer install

# 2. Environnement
cp .env.example .env
# → Éditer .env : DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD, FRONTEND_URL

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

---

## 🔐 Crédentiels par défaut

| Rôle        | Email                    | Mot de passe |
|-------------|--------------------------|--------------|
| Super Admin | admin@medex65.com     | Admin@2025   |
| Éditeur     | products@medex65.com  | Editor@2025  |

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

## 🚀 Production Nginx

```nginx
server {
    listen 443 ssl;
    server_name api.medex65.com;
    root /var/www/medex65-api/public;
    index index.php;

    location / { try_files $uri $uri/ /index.php?$query_string; }
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

```bash
# Optimisations production
php artisan config:cache
php artisan route:cache
php artisan optimize
```

---

**Contact :** info@medex237.com · +237 696 809 909 · Bafoussam, Cameroun
