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

Trois domaines métier cohabitent dans le schéma :
- `formations` → `formation_sessions` → `inscriptions` (le centre de formation)
- `categories` → `products` → `product_specs` (la vitrine)
- `farm_units` → `farm_batches` / `farm_animals`, `feed_items` → `feed_movements`,
  `health_events` (la gestion de l'exploitation)

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

## Comptes d'administration

Aucun mot de passe n'est écrit en dur. `UserSeeder` lit `ADMIN_PASSWORD` /
`EDITOR_PASSWORD` dans l'environnement, ou génère un mot de passe aléatoire affiché
une seule fois dans la console. Il ne réinitialise jamais un compte existant.

```bash
ADMIN_PASSWORD='…' EDITOR_PASSWORD='…' php artisan db:seed --class=UserSeeder
```

Pour créer un compte « fermier » (accès à la gestion de l'exploitation uniquement),
passer par **Admin → Utilisateurs** et choisir le rôle *Fermier*.

> Historique : la page de connexion affichait les identifiants de démonstration
> (`admin@divinform.com / Admin@2025`) et ceux-ci étaient valides en production.
> L'affichage a été retiré, les mots de passe ont été changés, et le seeder ne
> contient plus de valeur en clair. Les anciens mots de passe présents dans
> l'historique Git ne donnent plus accès à rien.

## Gestion de l'exploitation

Outil interne de suivi d'élevage, accessible sous `/admin/ferme`. Réservé aux rôles
`super_admin` et `farm_manager` (routes `admin/farm/*`). Un fermier ne voit ni le
contenu du site ni les utilisateurs ; la barre latérale se filtre selon son rôle.

### Deux compteurs dérivés, jamais incrémentés

C'est le cœur de la conception, et la raison pour laquelle ce module ne dérive pas :

- **Stock d'un aliment** = rejeu de tout son historique de `feed_movements`
  (`FeedItem::recomputeStock()`). Un `entree` ajoute, `sortie`/`perte` retranchent,
  `ajustement` **fixe** le stock (inventaire physique). Si le stock devient négatif à
  une date quelconque — y compris via une saisie antidatée — une `StockException` est
  levée et la transaction est annulée : rien n'est écrit.
- **Effectif d'une bande** = `initial_qty` moins la somme des `health_events` de type
  `mortalite` (`FarmBatch::recomputeHeadcount()`). Supprimer une mortalité saisie par
  erreur restaure donc l'effectif automatiquement.

Il n'existe volontairement **pas** de table « rations » : une ration distribuée est un
mouvement `sortie` portant un `farm_batch_id`. Stocks et alimentation partagent ainsi
la même source de vérité, et l'indice de consommation (`feedConversionRatio()`) se
calcule en sommant les sorties d'une bande.

### Jeu de démonstration

`php artisan db:seed --class=FarmDemoSeeder` crée 3 ateliers, 2 bandes, 1 truie,
2 aliments et leur historique. Toutes les entrées portent le suffixe `[DÉMO]`.
Pour les retirer (les bandes, animaux, mouvements et événements suivent en cascade) :

```bash
php artisan tinker --execute="
  App\Models\FeedItem::where('name','like','%[DÉMO]%')->get()->each->delete();
  App\Models\FarmUnit::where('name','like','%[DÉMO]%')->get()->each->delete();
"
```

### Lien avec le catalogue

`farm_batches.product_id` rattache une bande à un produit. Le stock vendable d'un
produit est **calculé** (`withSum('availableBatches')`) comme la somme des effectifs
des bandes au statut `disponible`. Aucune colonne `stock` n'est maintenue sur
`products` : la ferme reste l'unique source de vérité. Le champ `farm_stock` de
`ProductResource` vaut `null` tant que les tables de la ferme n'existent pas.

### Réponses d'erreur de l'API (nginx)

Le vhost ISPConfig de `admin.divinform.com` active `fastcgi_intercept_errors on` dans
`location @php`, avec `error_page 401 /error/401.html` (et 400/403/404/405/500/502/503).
Nginx intercepte alors les réponses d'erreur de Laravel et sert un fichier statique.
Tant que `divinform-api/public/error/` était **vide**, le fichier manquant provoquait un
404, lui-même intercepté, et `recursive_error_pages on` bouclait jusqu'à un **500 HTML** :

```
[error] rewrite or internal redirection cycle while internally redirecting to "/error/404.html"
```

Toute réponse non-2xx de l'API (401 jeton expiré, 403 rôle insuffisant, 404 slug inconnu)
devenait donc un 500 — seul le 422 passait, n'étant pas dans la liste `error_page`.

Deux protections sont en place :

1. `divinform-api/public/error/*.html` — les 8 pages sont versionnées. Elles suffisent
   à casser la boucle : nginx sert la page avec **le code HTTP d'origine**.
2. `fastcgi_intercept_errors off;` dans `location @php` du vhost — nginx laisse alors
   passer le JSON de Laravel intact (`{"message":"Token invalide."}`).

> ⚠️ **ISPConfig régénère le vhost** à chaque modification du site depuis le panneau,
> ce qui rétablirait `on`. Pour rendre le réglage durable, recopier la ligne dans le
> champ « Directives nginx » de la fiche du site. Si elle est perdue, les pages
> statiques du point 1 évitent le retour du 500.

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
