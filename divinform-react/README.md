# Ferme Divinform — Frontend React

Site vitrine + dashboard d'administration de la **Ferme Divinform** (vente directe de produits fermiers).

**Stack :** React 18 · Vite · Redux Toolkit · React Router v6 · Tailwind CSS · React Hook Form · Axios

---

## 🚀 Démarrage rapide

```bash
# 1. Installer les dépendances
npm install

# 2. Configurer l'API (développement)
cp .env.example .env.local     # ou créer .env.local
#   VITE_API_URL=http://localhost:8000/api
#   VITE_WHATSAPP_NUMBER=237696809909

# 3. Lancer en développement
npm run dev
# → http://localhost:5173
```

Le frontend consomme le backend Laravel (`divinform-api`). En dev, Vite proxifie `/api`
vers `http://localhost:8000` (voir `vite.config.js`) ; en prod, l'URL vient de `VITE_API_URL`.

## 🔐 Accès admin

| Champ    | Valeur                              |
|----------|-------------------------------------|
| URL      | `/admin/login`                      |
| Email    | admin@divinform.com                 |
| Password | Admin@2025                          |

> L'application est **branchée sur l'API réelle** (les slices Redux appellent le backend
> via `src/api/`). Le jeton JWT est stocké dans `localStorage['divinform_token']`.
> `src/utils/mockData.js` n'est plus utilisé au runtime (données de référence uniquement).

---

## 🎨 Thème

Palette « ferme » — vert prairie & terre — définie dans `tailwind.config.js`
(les clés `blue-*` conservent leur nom mais portent des valeurs vertes) et dans
`src/index.css`. Les images de la ferme sont dans `public/img/` et servies à la racine
du site (`/img/*.jpg`).

## 📁 Structure

```
src/
├── api/              # Axios + endpoints (auth, products, categories, settings, media)
│   └── axios.js      # Intercepteurs JWT (divinform_token)
├── components/
│   ├── layout/       # PublicLayout, AdminLayout, Navbar, Footer, ProtectedRoute
│   ├── public/       # ProductCard, CategoryCard, ProductModal, SearchBar, WhatsAppFAB
│   ├── admin/        # AdminSidebar, ImageUploader
│   └── ui/           # Spinner, Badge, Modal
├── hooks/            # useAuth, useProducts, useSettings
├── pages/
│   ├── public/       # Home, ProductDetail, CategoryPage
│   └── admin/        # Login, Dashboard, Products, Categories, Settings, Users
├── store/
│   ├── index.js
│   └── slices/       # authSlice, productsSlice, categoriesSlice, settingsSlice, uiSlice
└── utils/            # contact.js, settingsStore.js, mockData.js (référence)
```

---

## 🏗️ Build & déploiement de production

```bash
# .env.production (chargé automatiquement par vite build)
#   VITE_API_URL=https://admin.divinform.com/api
#   VITE_WHATSAPP_NUMBER=237696809909

npm run build
# → dist/  (servi par nginx sur https://divinform.com)
```

Déploiement actuel : le dossier `dist/` est servi sur **https://divinform.com**
(hébergement ISPConfig, nginx en mode SPA : `try_files $uri /index.html`).

---

## 📞 Contact — Ferme Divinform

- **Tél :** +237 696 809 909 / +237 696 534 179
- **Email :** contact@divinform.com
- **WhatsApp :** +237 696 809 909
- **Web :** www.divinform.com
