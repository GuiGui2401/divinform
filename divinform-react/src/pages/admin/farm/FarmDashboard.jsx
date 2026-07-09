import { useEffect, useState } from 'react'
import { useNavigate } from 'react-router-dom'
import { farmAPI, fmtDate } from '@/api/farm'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

export default function FarmDashboard() {
  const [data, setData]       = useState(null)
  const [loading, setLoading] = useState(true)
  const navigate = useNavigate()

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = 'Vue de la ferme'
    farmAPI.dashboard()
      .then((res) => setData(res.data.data))
      .catch(() => toast.error('Impossible de charger la vue de la ferme'))
      .finally(() => setLoading(false))
  }, [])

  if (loading) return <div className="flex justify-center py-20"><Spinner size="lg" /></div>
  if (!data)   return null

  const cards = [
    { label: 'Effectif total',   icon: '🐔', value: data.headcount,      hint: `${data.batches_open} bande(s) en cours` },
    { label: 'Ateliers actifs',  icon: '🏠', value: data.units_count,    hint: 'Sites de production' },
    { label: 'Animaux suivis',   icon: '🐄', value: data.animals_alive,  hint: 'Individus identifiés' },
    { label: 'Aliments en stock',icon: '🌽', value: data.feed_items_count, hint: `${data.low_stock.length} sous le seuil`, to: '/admin/ferme/aliments' },
  ]

  return (
    <div>
      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        {cards.map((c) => (
          <div key={c.label}
               onClick={c.to ? () => navigate(c.to) : undefined}
               className={`stat-card ${c.to ? 'cursor-pointer hover:shadow-md transition-shadow' : ''}`}>
            <div className="rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                 style={{ background: 'rgba(46,90,31,0.08)', width: 52, height: 52 }}>
              {c.icon}
            </div>
            <div>
              <div className="font-display font-extrabold text-dark text-2xl">{c.value}</div>
              <div className="text-gray-med text-xs mt-0.5">{c.label}</div>
              <div className="text-gray-med/70 text-xs mt-1">{c.hint}</div>
            </div>
          </div>
        ))}
      </div>

      {/* Alertes de réapprovisionnement */}
      {data.low_stock.length > 0 && (
        <div className="admin-card mb-6 border-l-4 border-l-red-400">
          <div className="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 className="font-display font-bold text-dark">⚠️ Stocks sous le seuil d'alerte</h2>
            <button onClick={() => navigate('/admin/ferme/aliments')}
                    className="text-xs text-blue-mid hover:underline bg-transparent border-0 cursor-pointer">
              Réapprovisionner →
            </button>
          </div>
          <div className="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {data.low_stock.map((f) => (
              <div key={f.id} className="border border-red-100 bg-red-50/40 rounded-xl px-4 py-3">
                <div className="font-semibold text-dark text-sm">{f.name}</div>
                <div className="text-xs text-red-600 mt-1">
                  {f.current_qty} {f.unit} restant — seuil {f.alert_threshold} {f.unit}
                </div>
              </div>
            ))}
          </div>
        </div>
      )}

      {/* Rappels de vaccination */}
      {data.vaccines_due.length > 0 && (
        <div className="admin-card mb-6">
          <div className="p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">💉 Rappels sous 14 jours</h2>
          </div>
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>
                  {['Échéance', 'Concerne', 'Intitulé'].map((h) => (
                    <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {data.vaccines_due.map((v) => (
                  <tr key={v.id} className="border-t border-gray-100">
                    <td className="px-5 py-3 text-sm font-semibold text-dark">{fmtDate(v.next_due_on)}</td>
                    <td className="px-5 py-3 text-sm text-gray-med">{v.target || '—'}</td>
                    <td className="px-5 py-3 text-sm text-gray-med">{v.label}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Mortalité par bande */}
      {data.mortality.length > 0 && (
        <div className="admin-card">
          <div className="p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">Taux de mortalité des bandes en cours</h2>
          </div>
          <div className="p-6 space-y-3">
            {data.mortality.map((m) => (
              <div key={m.code} className="flex items-center gap-4">
                <span className="text-sm font-semibold text-dark w-28 flex-shrink-0">{m.code}</span>
                <div className="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                  <div className="h-full rounded-full transition-all"
                       style={{
                         width: `${Math.min(100, m.rate)}%`,
                         background: m.rate >= 10 ? '#e74c3c' : m.rate >= 5 ? '#d9a441' : '#6BA83A',
                       }} />
                </div>
                <span className="text-sm text-gray-med w-14 text-right">{m.rate}%</span>
              </div>
            ))}
          </div>
        </div>
      )}

      {data.low_stock.length === 0 && data.vaccines_due.length === 0 && (
        <div className="admin-card p-10 text-center text-gray-med">
          <div className="text-4xl mb-3">✅</div>
          <p className="text-sm">Aucune alerte. Stocks et rappels sont à jour.</p>
        </div>
      )}
    </div>
  )
}
