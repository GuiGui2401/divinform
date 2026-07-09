import { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { fetchProducts, selectAllProducts } from '@/store/slices/productsSlice'
import { fetchCategories, selectCategories } from '@/store/slices/categoriesSlice'
import { settingsAPI } from '@/api/settings'
import { useNavigate } from 'react-router-dom'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

export default function Dashboard() {
  const dispatch   = useDispatch()
  const products   = useSelector(selectAllProducts)
  const categories = useSelector(selectCategories)
  const navigate   = useNavigate()
  const [stats, setStats]   = useState(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    const el = document.getElementById('admin-page-title')
    if (el) el.textContent = 'Vue d\'ensemble'

    const load = async () => {
      try {
        const [, , statsRes] = await Promise.all([
          dispatch(fetchProducts()),
          dispatch(fetchCategories()),
          settingsAPI.getStats(),
        ])
        setStats(statsRes.data.data)
      } catch {
        toast.error('Erreur lors du chargement des statistiques')
      } finally {
        setLoading(false)
      }
    }
    load()
  }, [dispatch])

  const statCards = [
    { label: 'Produits actifs',   icon: '🏥', value: stats?.products_count  ?? products.length,    bg: 'rgba(10,61,143,0.08)',  trend: '↑ +2 ce mois' },
    { label: 'Catégories',        icon: '🗂️', value: stats?.categories_count ?? categories.length,  bg: 'rgba(39,174,96,0.08)',  trend: 'Stable' },
    { label: 'Vues ce mois',      icon: '👁️', value: stats?.views_total      ?? '—',                bg: 'rgba(26,111,196,0.08)', trend: '↑ +18%' },
    { label: 'Contacts WhatsApp', icon: '💬', value: stats?.contacts_total   ?? '—',                bg: 'rgba(231,76,60,0.08)',  trend: '↑ +8 cette sem.' },
  ]

  if (loading) {
    return (
      <div className="flex justify-center items-center py-20">
        <Spinner size="lg" />
      </div>
    )
  }

  return (
    <div>
      {/* Stats */}
      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        {statCards.map((s) => (
          <div key={s.label} className="stat-card">
            <div className="rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                 style={{ background: s.bg, width: 52, height: 52 }}>
              {s.icon}
            </div>
            <div>
              <div className="font-display font-extrabold text-dark text-2xl">{s.value}</div>
              <div className="text-gray-med text-xs mt-0.5">{s.label}</div>
              <div className="text-green text-xs font-semibold mt-1">{s.trend}</div>
            </div>
          </div>
        ))}
      </div>

      {/* Top produits */}
      {stats?.top_products?.length > 0 && (
        <div className="admin-card mb-6">
          <div className="p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">Top produits consultés</h2>
          </div>
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>
                  {['Produit', 'Vues', 'Contacts'].map((h) => (
                    <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {stats.top_products.map((p) => (
                  <tr key={p.id} className="border-t border-gray-100 hover:bg-off-white/50">
                    <td className="px-5 py-3 font-semibold text-dark text-sm">{p.name}</td>
                    <td className="px-5 py-3 text-sm text-blue-mid font-semibold">{p.views_count}</td>
                    <td className="px-5 py-3 text-sm text-green font-semibold">{p.contact_count}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Produits récents */}
      <div className="admin-card">
        <div className="flex items-center justify-between p-6 border-b border-gray-100">
          <h2 className="font-display font-bold text-dark">Produits récents</h2>
          <button onClick={() => navigate('/admin/produits')} className="btn-blue text-xs">
            Voir tous →
          </button>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-off-white">
              <tr>
                {['Produit', 'Catégorie', 'Statut', 'Actions'].map((h) => (
                  <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                ))}
              </tr>
            </thead>
            <tbody>
              {products.slice(0, 6).map((p) => {
                const cat = categories.find((c) => c.id === p.category_id)
                return (
                  <tr key={p.id} className="border-t border-gray-100 hover:bg-off-white/50">
                    <td className="px-5 py-3.5">
                      <div className="font-semibold text-dark text-sm">{p.name}</div>
                      <div className="text-xs text-gray-med mt-0.5">{p.short_desc?.slice(0, 50)}…</div>
                    </td>
                    <td className="px-5 py-3.5 text-sm text-gray-med">
                      {cat ? `${cat.icon} ${cat.name}` : '—'}
                    </td>
                    <td className="px-5 py-3.5">
                      <span className={`text-xs font-bold px-2.5 py-1 rounded-full
                        ${p.active !== false ? 'bg-green/10 text-green' : 'bg-gray-100 text-gray-med'}`}>
                        {p.active !== false ? 'Actif' : 'Brouillon'}
                      </span>
                    </td>
                    <td className="px-5 py-3.5">
                      <button
                        onClick={() => navigate('/admin/produits')}
                        className="text-xs bg-blue-mid/10 text-blue-mid hover:bg-blue-mid/20
                                   px-3 py-1.5 rounded-lg transition-colors border-0 cursor-pointer"
                      >
                        Éditer
                      </button>
                    </td>
                  </tr>
                )
              })}
            </tbody>
          </table>
        </div>
      </div>

      {/* Répartition par catégorie */}
      {stats?.by_category?.length > 0 && (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
          {stats.by_category.map((c) => (
            <div key={c.name}
                 className="bg-white rounded-xl shadow-card p-5 flex items-center gap-4">
              <span className="text-3xl">{c.icon}</span>
              <div>
                <div className="font-display font-semibold text-dark text-sm">{c.name}</div>
                <div className="text-gray-med text-xs mt-0.5">{c.count} produit{c.count > 1 ? 's' : ''}</div>
              </div>
            </div>
          ))}
        </div>
      )}

      {/* Quick actions */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
        {[
          { label: 'Ajouter un produit',   icon: '➕', to: '/admin/produits',   color: 'bg-blue-dark' },
          { label: 'Gérer les catégories', icon: '🗂️', to: '/admin/categories', color: 'bg-green' },
          { label: 'Paramètres du site',   icon: '⚙️', to: '/admin/parametres', color: 'bg-dark-2' },
        ].map((a) => (
          <button
            key={a.label}
            onClick={() => navigate(a.to)}
            className={`${a.color} text-white rounded-xl p-5 text-left
                         hover:opacity-90 transition-opacity cursor-pointer border-0 w-full`}
          >
            <div className="text-2xl mb-2">{a.icon}</div>
            <div className="font-display font-semibold text-sm">{a.label}</div>
          </button>
        ))}
      </div>
    </div>
  )
}
