import { useCallback, useEffect, useState } from 'react'
import { formationsAPI } from '@/api/formations'
import { waFormationLink, callLink, mailLink, formatPhone } from '@/utils/contact'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

const STATUSES = [
  { value: '',          label: 'Toutes' },
  { value: 'nouvelle',  label: 'Nouvelles',  cls: 'bg-blue-50 text-blue-dark' },
  { value: 'contactee', label: 'Contactées', cls: 'bg-amber-50 text-amber-800' },
  { value: 'confirmee', label: 'Confirmées', cls: 'bg-green/10 text-green' },
  { value: 'annulee',   label: 'Annulées',   cls: 'bg-gray-100 text-gray-med' },
]

const statusCls = (s) => STATUSES.find((x) => x.value === s)?.cls || 'bg-gray-100 text-gray-med'
const statusLabel = (s) => STATUSES.find((x) => x.value === s)?.label?.replace(/s$/, '') || s

const fmtDateTime = (iso) =>
  iso ? new Date(iso.replace(' ', 'T')).toLocaleString('fr-FR', {
    day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit',
  }) : '—'

export default function Inscriptions() {
  const [items, setItems]     = useState([])
  const [counts, setCounts]   = useState({})
  const [loading, setLoading] = useState(true)
  const [status, setStatus]   = useState('')

  const load = useCallback(() => {
    setLoading(true)
    formationsAPI.getInscriptions(status ? { status } : {})
      .then((res) => {
        setItems(res.data.data)
        setCounts(res.data.counts || {})
      })
      .catch(() => toast.error('Impossible de charger les demandes'))
      .finally(() => setLoading(false))
  }, [status])

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = "Demandes d'inscription"
  }, [])

  useEffect(load, [load])

  const changeStatus = async (inscription, newStatus) => {
    try {
      await formationsAPI.updateInscription(inscription.id, { status: newStatus })
      toast.success(`Demande marquée « ${statusLabel(newStatus)} »`)
      load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const remove = async (inscription) => {
    if (!confirm(`Supprimer définitivement la demande de ${inscription.name} ?`)) return
    try {
      await formationsAPI.deleteInscription(inscription.id)
      toast.success('Demande supprimée')
      load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const total = Object.values(counts).reduce((a, b) => a + b, 0)

  return (
    <div>
      {/* Compteurs */}
      <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        {STATUSES.filter((s) => s.value).map((s) => (
          <button key={s.value} onClick={() => setStatus(s.value === status ? '' : s.value)}
            className={`admin-card p-4 text-left transition-all cursor-pointer border-2
                        ${status === s.value ? 'border-blue-mid' : 'border-transparent'}`}>
            <div className="text-2xl font-display font-bold text-dark">{counts[s.value] || 0}</div>
            <div className="text-xs text-gray-med mt-1">{s.label}</div>
          </button>
        ))}
      </div>

      <div className="admin-card">
        <div className="flex flex-wrap items-center justify-between gap-4 p-6 border-b border-gray-100">
          <div className="flex flex-wrap gap-2">
            {STATUSES.map((s) => (
              <button key={s.value || 'all'} onClick={() => setStatus(s.value)}
                className={`text-xs font-semibold px-3.5 py-1.5 rounded-full border transition-colors cursor-pointer
                  ${status === s.value
                    ? 'bg-blue-dark text-white border-blue-dark'
                    : 'bg-white text-gray-med border-gray-200 hover:border-blue-mid'}`}>
                {s.label}
              </button>
            ))}
          </div>
          <span className="text-gray-med text-sm">{total} demande{total > 1 ? 's' : ''} au total</span>
        </div>

        <div className="overflow-x-auto">
          {loading ? (
            <div className="flex justify-center py-12"><Spinner /></div>
          ) : items.length === 0 ? (
            <div className="text-center py-16 text-gray-med">
              <div className="text-4xl mb-3">📝</div>
              <p className="text-sm">Aucune demande {status ? `« ${statusLabel(status)} »` : 'pour le moment'}.</p>
            </div>
          ) : (
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>
                  {['Candidat', 'Formation', 'Session', 'Reçue le', 'Statut', 'Actions'].map((h) => (
                    <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {items.map((i) => (
                  <tr key={i.id} className="border-t border-gray-100 hover:bg-off-white/50 align-top">
                    <td className="px-5 py-3">
                      <div className="font-semibold text-dark text-sm">{i.name}</div>
                      <div className="text-xs text-gray-med mt-0.5 flex flex-wrap gap-2">
                        <a href={callLink(i.phone)} className="text-blue-mid no-underline hover:underline">
                          📞 {formatPhone(i.phone)}
                        </a>
                        {i.email && (
                          <a href={mailLink(i.email, `Votre inscription : ${i.formation_title}`)}
                             className="text-blue-mid no-underline hover:underline">📧 {i.email}</a>
                        )}
                      </div>
                      {i.message && (
                        <p className="text-xs text-gray-med mt-1.5 italic max-w-xs">« {i.message} »</p>
                      )}
                    </td>
                    <td className="px-5 py-3 text-sm text-dark">{i.formation_title || '—'}</td>
                    <td className="px-5 py-3 text-xs text-gray-med">
                      {i.session
                        ? <>{new Date(i.session.starts_on).toLocaleDateString('fr-FR')}<br />{i.session.location}</>
                        : 'Non précisée'}
                    </td>
                    <td className="px-5 py-3 text-xs text-gray-med">{fmtDateTime(i.created_at)}</td>
                    <td className="px-5 py-3">
                      <span className={`text-xs font-bold px-2.5 py-1 rounded-full ${statusCls(i.status)}`}>
                        {statusLabel(i.status)}
                      </span>
                    </td>
                    <td className="px-5 py-3">
                      <div className="flex flex-wrap gap-1.5">
                        <a href={waFormationLink(i.formation_title || '', '')}
                           target="_blank" rel="noopener noreferrer"
                           className="text-xs bg-[#25D366]/10 text-[#128C4A] hover:bg-[#25D366]/20
                                      px-2.5 py-1.5 rounded-lg no-underline transition-colors">💬</a>
                        {i.status !== 'contactee' && (
                          <button onClick={() => changeStatus(i, 'contactee')}
                            className="text-xs bg-amber-50 text-amber-800 hover:bg-amber-100
                                       px-2.5 py-1.5 rounded-lg border-0 cursor-pointer">Contactée</button>
                        )}
                        {i.status !== 'confirmee' && (
                          <button onClick={() => changeStatus(i, 'confirmee')}
                            className="text-xs bg-green/10 text-green hover:bg-green/20
                                       px-2.5 py-1.5 rounded-lg border-0 cursor-pointer">Confirmer</button>
                        )}
                        {i.status !== 'annulee' && (
                          <button onClick={() => changeStatus(i, 'annulee')}
                            className="text-xs bg-gray-100 text-gray-med hover:bg-gray-200
                                       px-2.5 py-1.5 rounded-lg border-0 cursor-pointer">Annuler</button>
                        )}
                        <button onClick={() => remove(i)}
                          className="text-xs bg-red-50 text-red-500 hover:bg-red-100
                                     px-2.5 py-1.5 rounded-lg border-0 cursor-pointer">✕</button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>

      <p className="text-xs text-gray-med mt-4">
        Confirmer une demande réserve automatiquement une place sur la session choisie.
        L'annuler ou la supprimer libère cette place.
      </p>
    </div>
  )
}
