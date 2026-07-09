# Medex65

Repository monorepo pour l’application Medex65 avec un backend Laravel et un frontend React.

## Architecture

- `medex65-api/` : backend API REST Laravel 11
- `medex65-react/` : frontend React/Vite

## Installation globale

Ce dépôt contient deux projets distincts. Installe d'abord les dépendances pour chaque projet séparément.

### Backend Laravel

```bash
cd medex65-api
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve --port=8000
```

### Frontend React

```bash
cd medex65-react
npm install
cp .env.example .env.local
npm run dev
```

## Organisation des répertoires

### `medex65-api`

- `app/` : logique applicative, modèles, contrôleurs, ressources
- `bootstrap/`, `config/`, `database/` : configuration Laravel
- `public/` : point d’entrée web
- `routes/` : routes API et console
- `storage/` : fichiers générés, sessions, logs
- `tests/` : tests PHPUnit

### `medex65-react`

- `src/api/` : clients API et appels réseau
- `src/components/` : composants UI et layout
- `src/hooks/` : hooks React personnalisés
- `src/pages/` : pages publiques et admin
- `src/store/` : état Redux
- `src/utils/` : utilitaires et données mock

## Démarrage rapide

1. Lance d’abord le backend :
   - `cd medex65-api`
   - `php artisan serve --port=8000`

2. Lance ensuite le frontend :
   - `cd medex65-react`
   - `npm run dev`

3. Ouvre le frontend dans ton navigateur :
   - `http://localhost:5173`

## Notes

- Le frontend est conçu pour fonctionner avec un backend Laravel via API.
- Le fichier `.gitignore` à la racine est configuré pour ignorer les dépendances, les fichiers d’environnement et les fichiers temporaires des deux projets.

## Liens utiles

- Backend Laravel : `medex65-api/README.md`
- Frontend React : `medex65-react/README.md`
