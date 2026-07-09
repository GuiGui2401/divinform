# C.F Divin Élevage

Monorepo de l'application **C.F Divin Élevage** — le site d'un **centre de formation
en élevage et en agriculture**, adossé à une ferme-école en activité.

Le site s'articule en deux volets, dans cet ordre :

1. **Le centre de formation** (cœur du site) : catalogue de formations, sessions
   programmées, demandes d'inscription en ligne.
2. **La ferme** (volet secondaire) : les produits issus des ateliers pédagogiques,
   proposés en vente directe.

## Architecture

- `divinform-api/` : backend API REST Laravel 12 (JWT) — sert `https://admin.divinform.com`
- `divinform-react/` : frontend React/Vite (vitrine + dashboard) — sert `https://divinform.com`

Deux domaines métier cohabitent dans le schéma :
- `formations` → `formation_sessions` → `inscriptions` (le centre de formation)
- `categories` → `products` → `product_specs` (la ferme)

L'identité du site et tous les textes de la page d'accueil vivent dans :
- `divinform-api/config/site_settings.php` (registre central des réglages/branding)
- `divinform-api/database/seeders/` (formations, catégories, produits, utilisateurs)

> ⚠️ `config/site_settings.php` est **lu depuis le cache de configuration**.
> Toute modification du registre exige `php artisan config:clear && php artisan config:cache`
> pour être prise en compte, y compris par les seeders.

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

## Bascule « ferme » → « centre de formation »

Le site a d'abord été livré orienté vente de produits fermiers. La bascule vers le
centre de formation se fait en quatre commandes, **dans cet ordre** :

```bash
cd divinform-api
php artisan migrate --force                     # crée formations, formation_sessions, inscriptions
php artisan config:clear && php artisan config:cache   # indispensable : recharge site_settings.php
php artisan db:seed --class=FormationSeeder     # catalogue de formations de démarrage
php artisan db:seed --class=IdentitySeeder      # bascule les textes du site
php artisan route:clear && php artisan route:cache     # active /v1/formations et /v1/inscriptions
```

`IdentitySeeder` **préserve** les réglages déjà personnalisés depuis le back-office
(nom du site, slogan, logo, téléphones, WhatsApp, réseaux sociaux) et ne remplace que
les textes restés orientés « ferme ». La liste exacte est en tête du fichier.

Puis, côté frontend :

```bash
cd divinform-react && npm run build
```

### Numéros de téléphone

Les numéros sont saisis au **format national gabonais** (`060337821`). La fonction
`toE164()` de `src/utils/contact.js` retire le zéro initial pour construire les liens
`wa.me` et `tel:` : un lien `wa.me/241060337821` (avec le zéro) pointe vers un tout
autre compte WhatsApp que `wa.me/24160337821`.

## Notes

- Le frontend est conçu pour fonctionner avec un backend Laravel via API.
- Le fichier `.gitignore` à la racine ignore les dépendances, les fichiers
  d'environnement et les fichiers temporaires des deux projets.

## Liens utiles

- Backend Laravel : `divinform-api/README.md`
- Frontend React : `divinform-react/README.md`
