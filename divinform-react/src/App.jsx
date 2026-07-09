import React, { lazy, Suspense } from 'react'
import { Routes, Route, Navigate } from 'react-router-dom'
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

const PageLoader = () => (
  <div className="min-h-screen flex items-center justify-center bg-off-white">
    <Spinner size="lg" />
  </div>
)

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
          <Route index element={<Navigate to="dashboard" replace />} />
          <Route path="dashboard"    element={<Dashboard />} />
          <Route path="formations"   element={<Formations />} />
          <Route path="inscriptions" element={<Inscriptions />} />
          <Route path="produits"     element={<Products />} />
          <Route path="categories"   element={<Categories />} />
          <Route path="parametres"   element={<Settings />} />
          <Route path="utilisateurs" element={<Users />} />
        </Route>

        {/* ── FALLBACK ── */}
        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </Suspense>
  )
}
