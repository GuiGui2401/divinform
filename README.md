# Ferme Divinform

Monorepo de l'application **Ferme Divinform** — un site de vente directe de produits
fermiers (produits laitiers, viandes, œufs, animaux d'élevage, laine, visites de la ferme)
avec un backend Laravel et un frontend React.

## Architecture

- `divinform-api/` : backend API REST Laravel 12 (JWT) — sert `https://admin.divinform.com`
- `divinform-react/` : frontend React/Vite (vitrine + dashboard) — sert `https://divinform.com`

Le schéma de données (catégories → produits, product_specs, settings, users) est générique.
Tout le contenu de la ferme et l'identité du site vivent dans :
- `divinform-api/config/site_settings.php` (registre central des réglages/branding)
- `divinform-api/database/seeders/` (catégories, produits, utilisateurs)

## Installation globale

Ce dépôt contient deux projets distincts. Installe d'abord les dépendances de chacun.

### Backend Laravel

```bash
cd divinform-api
composer install
cp .env.example .env        # puis renseigner DB_*, APP_URL, FRONTEND_URL
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve --port=8000
```

### Frontend React

```bash
cd divinform-react
npm install
cp .env.example .env.local  # VITE_API_URL=http://localhost:8000/api
npm run dev
```

## Organisation des répertoires

### `divinform-api`

- `app/` : logique applicative, modèles, contrôleurs, ressources
- `bootstrap/`, `config/`, `database/` : configuration Laravel (dont `config/site_settings.php`)
- `public/` : point d'entrée web
- `routes/` : routes API et console
- `storage/` : fichiers générés, sessions, logs
- `tests/` : tests PHPUnit

### `divinform-react`

- `src/api/` : clients API et appels réseau (JWT via `divinform_token`)
- `src/components/` : composants UI et layout
- `src/hooks/` : hooks React personnalisés
- `src/pages/` : pages publiques et admin
- `src/store/` : état Redux
- `src/utils/` : utilitaires et données de référence
- `public/img/` : images de la ferme (servies à `/img/*.jpg`)

## Démarrage rapide (dev)

1. Lance d'abord le backend :
   - `cd divinform-api`
   - `php artisan serve --port=8000`

2. Lance ensuite le frontend :
   - `cd divinform-react`
   - `npm run dev`

3. Ouvre le frontend dans ton navigateur :
   - `http://localhost:5173`

## Déploiement (production)

- **Frontend** : `cd divinform-react && npm run build` → le dossier `dist/` est servi
  par nginx sur `https://divinform.com` (mode SPA).
- **Backend** : `divinform-api/public` est servi par nginx + php-fpm sur
  `https://admin.divinform.com`. Base MySQL `c0divinform`.
  `.env` doit définir `FRONTEND_URL=https://divinform.com` (CORS) et l'`open_basedir`
  du pool php-fpm doit inclure la racine de l'app (au-dessus de `public/`).

## Notes

- Le frontend est conçu pour fonctionner avec un backend Laravel via API.
- Le fichier `.gitignore` à la racine ignore les dépendances, les fichiers
  d'environnement et les fichiers temporaires des deux projets.

## Liens utiles

- Backend Laravel : `divinform-api/README.md`
- Frontend React : `divinform-react/README.md`
