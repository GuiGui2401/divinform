import axios from 'axios'

// Base = http://localhost:8000/api
// Les routes publiques ajoutent /v1/... dans leurs fichiers
// Les routes admin ajoutent /admin/...
// Les routes auth ajoutent /auth/...
const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
  timeout: 15000,
})

// ── Injecter le token JWT ─────────────────────────────────
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('divinform_token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

// ── Gérer l'expiration du token ───────────────────────────
api.interceptors.response.use(
  (res) => res,
  (err) => {
    if (err.response?.status === 401) {
      localStorage.removeItem('divinform_token')
      // Rediriger vers login seulement si on est sur une page admin
      if (window.location.pathname.startsWith('/admin')) {
        window.location.href = '/admin/login'
      }
    }
    return Promise.reject(err)
  }
)

export default api
