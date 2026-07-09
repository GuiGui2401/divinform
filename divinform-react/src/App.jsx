import React, { lazy, Suspense } from 'react'
import { Routes, Route, Navigate } from 'react-router-dom'
import { useSelector } from 'react-redux'
import { selectRole } from '@/store/slices/authSlice'
import PublicLayout from '@/components/layout/PublicLayout'
import AdminLayout  from '@/components/layout/AdminLayout'
import ProtectedRoute from '@/components/layout/ProtectedRoute'
import Spinner from '@/components/ui/Spinner'

// Public pages — lazy loaded
const Home            = lazy(() => import('@/pages/public/Home'))
const FormationDetail = lazy(() => import('@/pages/public/FormationDetail'))
const ProductDetail   = lazy(() => import('@/pages/public/ProductDetail'))
const CategoryPage    = lazy(() => import('@/pages/public/CategoryPage'))

// Admin pages — lazy loaded
const Login        = lazy(() => import('@/pages/admin/Login'))
const Dashboard    = lazy(() => import('@/pages/admin/Dashboard'))
const Formations   = lazy(() => import('@/pages/admin/Formations'))
const Inscriptions = lazy(() => import('@/pages/admin/Inscriptions'))
const Products     = lazy(() => import('@/pages/admin/Products'))
const Categories   = lazy(() => import('@/pages/admin/Categories'))
const Settings     = lazy(() => import('@/pages/admin/Settings'))
const Users        = lazy(() => import('@/pages/admin/Users'))

// Gestion de l'exploitation — lazy loaded
const FarmDashboard = lazy(() => import('@/pages/admin/farm/FarmDashboard'))
const FarmUnits     = lazy(() => import('@/pages/admin/farm/FarmUnits'))
const FarmBatches   = lazy(() => import('@/pages/admin/farm/FarmBatches'))
const FarmAnimals   = lazy(() => import('@/pages/admin/farm/FarmAnimals'))
const FarmFeed      = lazy(() => import('@/pages/admin/farm/FarmFeed'))
const FarmHealth    = lazy(() => import('@/pages/admin/farm/FarmHealth'))

const PageLoader = () => (
  <div className="min-h-screen flex items-center justify-center bg-off-white">
    <Spinner size="lg" />
  </div>
)

/**
 * Un gestionnaire de ferme n'a pas accès au tableau de bord du site :
 * on l'envoie directement sur sa propre vue.
 */
function AdminHome() {
  const role = useSelector(selectRole)
  return <Navigate to={role === 'farm_manager' ? 'ferme' : 'dashboard'} replace />
}

export default function App() {
  return (
    <Suspense fallback={<PageLoader />}>
      <Routes>
        {/* ── PUBLIC ── */}
        <Route element={<PublicLayout />}>
          <Route index element={<Home />} />
          <Route path="formation/:slug" element={<FormationDetail />} />
          <Route path="categorie/:slug" element={<CategoryPage />} />
          <Route path="produit/:slug"   element={<ProductDetail />} />
        </Route>

        {/* ── ADMIN ── */}
        <Route path="admin/login" element={<Login />} />
        <Route path="admin" element={
          <ProtectedRoute>
            <AdminLayout />
          </ProtectedRoute>
        }>
          <Route index element={<AdminHome />} />
          <Route path="dashboard"    element={<Dashboard />} />
          <Route path="formations"   element={<Formations />} />
          <Route path="inscriptions" element={<Inscriptions />} />
          <Route path="produits"     element={<Products />} />
          <Route path="categories"   element={<Categories />} />
          <Route path="parametres"   element={<Settings />} />
          <Route path="utilisateurs" element={<Users />} />

          {/* Gestion de l'exploitation */}
          <Route path="ferme"          element={<FarmDashboard />} />
          <Route path="ferme/ateliers" element={<FarmUnits />} />
          <Route path="ferme/bandes"   element={<FarmBatches />} />
          <Route path="ferme/animaux"  element={<FarmAnimals />} />
          <Route path="ferme/aliments" element={<FarmFeed />} />
          <Route path="ferme/sante"    element={<FarmHealth />} />
        </Route>

        {/* ── FALLBACK ── */}
        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </Suspense>
  )
}
