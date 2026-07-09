# Patch — Connexion Frontend React → Backend Laravel

Ce dossier contient les fichiers à **remplacer** dans le projet `divinform-react/`.

## Fichiers inclus dans ce patch

```
src/
├── api/
│   ├── axios.js          ← baseURL alignée sur /api (sans /v1)
│   ├── auth.js           ← appels /auth/*
│   ├── products.js       ← appels /v1/* (public) + /admin/* (sécurisé)
│   ├── categories.js     ← appels /v1/* (public) + /admin/* (sécurisé)
│   └── settings.js       ← appels /admin/settings + /admin/stats + /admin/users
├── store/slices/
│   ├── authSlice.js      ← login/logout via API réelle (plus de fakeFetch)
│   ├── productsSlice.js  ← CRUD via API réelle
│   └── categoriesSlice.js← CRUD via API réelle
└── pages/admin/
    ├── Dashboard.jsx     ← stats réelles depuis /admin/stats
    ├── Settings.jsx      ← lecture/écriture depuis /admin/settings
    └── Users.jsx         ← CRUD depuis /admin/users

.env.local                ← à placer à la racine du projet React
```

## Comment appliquer

```bash
# Depuis la racine de divinform-react/
cp -r chemin/vers/patch/src/api/*           src/api/
cp -r chemin/vers/patch/src/store/slices/*  src/store/slices/
cp -r chemin/vers/patch/src/pages/admin/*   src/pages/admin/
cp    chemin/vers/patch/.env.local          .env.local
```

## Configuration .env.local

```env
VITE_API_URL=http://localhost:8000/api
VITE_WHATSAPP_NUMBER=237696809909
```

En production :
```env
VITE_API_URL=https://admin.divinform.com/api
```

## Vérifier que le backend tourne

```bash
# Dans divinform-api/
php artisan serve --port=8000

# Tester un endpoint public
curl http://localhost:8000/api/v1/products
curl http://localhost:8000/api/v1/categories
```

## Démarrer le frontend

```bash
# Dans divinform-react/
npm run dev
# → http://localhost:5173
```

## Test de connexion admin

1. Ouvrir http://localhost:5173/admin/login
2. Email : admin@divinform.com
3. Mot de passe : Admin@2025

## Notes importantes

- Le fichier `src/utils/mockData.js` peut être conservé (il n'est plus utilisé par les slices).
- Si tu vois des erreurs CORS, vérifie que `FRONTEND_URL=http://localhost:5173` est bien dans le `.env` Laravel.
- Pour les uploads d'images, s'assurer que `php artisan storage:link` a été exécuté.
