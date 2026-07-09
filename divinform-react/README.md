# Medex65 — Frontend React

Application web vitrine + dashboard admin pour MEDEX SARL.

**Stack :** React 18 · Vite · Redux Toolkit · React Router v6 · Tailwind CSS · React Hook Form

---

## 🚀 Démarrage rapide

```bash
# 1. Installer les dépendances
npm install

# 2. Copier le fichier d'environnement
cp .env.example .env.local

# 3. Lancer en développement
npm run dev
# → http://localhost:5173
```

## 🔐 Accès admin (mode démo)

| Champ    | Valeur                   |
|----------|--------------------------|
| URL      | http://localhost:5173/admin/login |
| Email    | admin@medex65.com     |
| Password | Admin@2025               |

> En mode démo, l'app utilise des données mock locales.
> Pour connecter le vrai backend Laravel, remplace les `fakeFetch` dans les slices Redux par les appels `productsAPI` / `categoriesAPI` depuis `src/api/`.

---

## 📁 Structure

```
src/
├── api/              # Instances Axios + endpoints
│   ├── axios.js      # Intercepteurs JWT
│   ├── auth.js
│   ├── products.js
│   ├── categories.js
│   └── settings.js
├── components/
│   ├── layout/       # PublicLayout, AdminLayout, Navbar, Footer, ProtectedRoute
│   ├── public/       # ProductCard, CategoryCard, ProductModal, SearchBar, WhatsAppFAB
│   ├── admin/        # AdminSidebar
│   └── ui/           # Spinner, Badge, Modal
├── hooks/
│   ├── useAuth.js
│   └── useProducts.js
├── pages/
│   ├── public/       # Home, ProductDetail, CategoryPage
│   └── admin/        # Login, Dashboard, Products, Categories, Settings, Users
├── store/
│   ├── index.js
│   └── slices/       # authSlice, productsSlice, categoriesSlice, uiSlice
└── utils/
    ├── contact.js    # waLink, callLink, mailLink
    └── mockData.js   # Données de démonstration
```

---

## 🔌 Connexion au backend Laravel

Dans chaque slice Redux, remplace le bloc `fakeFetch` par l'appel API réel :

```js
// Avant (mock)
export const fetchProducts = createAsyncThunk('products/fetchAll', async (params) => {
  await fakeFetch()
  return { data: MOCK_PRODUCTS, ... }
})

// Après (API réelle)
import { productsAPI } from '@/api/products'
export const fetchProducts = createAsyncThunk('products/fetchAll', async (params, { rejectWithValue }) => {
  try {
    const res = await productsAPI.getAll(params)
    return res.data
  } catch (err) {
    return rejectWithValue(err.response?.data?.message)
  }
})
```

---

## 🏗️ Build de production

```bash
npm run build
# → dist/ (à déployer sur ton serveur ou CDN)
```

---

## 📞 Contact Medex65

- **Tél :** +237 696 809 909 / +237 696 534 179
- **Email :** info@medex237.com
- **WhatsApp :** +237 696 809 909
- **Adresse :** Bafoussam, Cameroun — Quartier Haoussa
