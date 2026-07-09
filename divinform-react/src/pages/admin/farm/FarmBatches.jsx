import { useCallback, useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { farmAPI, BATCH_STATUSES, fmtDate, today } from '@/api/farm'
import { fetchProducts, selectAllProducts } from '@/store/slices/productsSlice'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

const EMPTY = {
  farm_unit_id: '', product_id: '', code: '', species: '', breed: '',
  started_on: today(), expected_end_on: '', initial_qty: '', avg_weight_g: '',
  status: 'en_cours', notes: '',
}

export default function FarmBatches() {
  const dispatch  = useDispatch()
  const products  = useSelector(selectAllProducts)
  const [batches, setBatches] = useState([])
  const [units, setUnits]     = useState([])
  const [loading, setLoading] = useState(true)
  const [status, setStatus]   = useState('')
  const [form, setForm]       = useState(EMPTY)
  const [editing, setEditing] = useState(null)
  const [showForm, setShow]   = useState(false)

  const load = useCallback(() => {
    setLoading(true)
    Promise.all([
      farmAPI.getBatches(status ? { status } : {}),
      farmAPI.getUnits(),
    ])
      .then(([b, u]) => { setBatches(b.data.data); setUnits(u.data.data) })
      .catch(() => toast.error('Chargement impossible'))
      .finally(() => setLoading(false))
  }, [status])

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = 'Bandes'
    dispatch(fetchProducts())
  }, [dispatch])
  useEffect(load, [load])

  const submit = async (e) => {
    e.preventDefault()
    const payload = {
      ...form,
      product_id:      form.product_id || null,
      expected_end_on: form.expected_end_on || null,
      breed:           form.breed || null,
      initial_qty:     Number(form.initial_qty),
      avg_weight_g:    form.avg_weight_g === '' ? null : Number(form.avg_weight_g),
    }
    try {
      if (editing) await farmAPI.updateBatch(editing.id, payload)
      else         await farmAPI.createBatch(payload)
      toast.success(editing ? 'Bande mise à jour' : 'Bande créée')
      setShow(false); setEditing(null); setForm(EMPTY); load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const remove = async (b) => {
    if (!confirm(`Supprimer la bande ${b.code} ?\nSes mouvements d'aliment et son historique sanitaire seront perdus.`)) return
    try {
      await farmAPI.deleteBatch(b.id); toast.success('Bande supprimée'); load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const openEdit = (b) => {
    setEditing(b)
    setForm({
      farm_unit_id: b.farm_unit_id, product_id: b.product_id ?? '', code: b.code,
      species: b.species, breed: b.breed || '', started_on: b.started_on,
      expected_end_on: b.expected_end_on || '', initial_qty: b.initial_qty,
      avg_weight_g: b.avg_weight_g ?? '', status: b.status, notes: b.notes || '',
    })
    setShow(true)
  }

  return (
    <div>
      <div className="admin-card">
        <div className="flex flex-wrap items-center justify-between gap-4 p-6 border-b border-gray-100">
          <div className="flex flex-wrap gap-2">
            <button onClick={() => setStatus('')}
              className={`text-xs font-semibold px-3.5 py-1.5 rounded-full border cursor-pointer
                ${status === '' ? 'bg-blue-dark text-white border-blue-dark' : 'bg-white text-gray-med border-gray-200'}`}>
              Toutes
            </button>
            {BATCH_STATUSES.map((s) => (
              <button key={s.value} onClick={() => setStatus(s.value)}
                className={`text-xs font-semibold px-3.5 py-1.5 rounded-full border cursor-pointer
                  ${status === s.value ? 'bg-blue-dark text-white border-blue-dark' : 'bg-white text-gray-med border-gray-200'}`}>
                {s.label}
              </button>
            ))}
          </div>
          <button onClick={() => { setEditing(null); setForm(EMPTY); setShow(true) }} className="btn-blue">
            ＋ Nouvelle bande
          </button>
        </div>

        <div className="overflow-x-auto">
          {loading ? <div className="flex justify-center py-12"><Spinner /></div>
          : batches.length === 0 ? (
            <div className="text-center py-16 text-gray-med">
              <div className="text-4xl mb-3">🐔</div>
              <p className="text-sm">Aucune bande. Créez-en une pour suivre un lot d'animaux.</p>
            </div>
          ) : (
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>{['Bande', 'Atelier', 'Effectif', 'Mortalité', 'IC', 'Produit', 'Statut', 'Actions'].map((h) => (
                  <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                ))}</tr>
              </thead>
              <tbody>
                {batches.map((b) => {
                  const st = BATCH_STATUSES.find((s) => s.value === b.status)
                  return (
                    <tr key={b.id} className="border-t border-gray-100 hover:bg-off-white/50">
                      <td className="px-5 py-3">
                        <div className="font-semibold text-dark text-sm">{b.code}</div>
                        <div className="text-xs text-gray-med">{b.species} · démarrée le {fmtDate(b.started_on)}</div>
                      </td>
                      <td className="px-5 py-3 text-sm text-gray-med">{b.unit?.name || '—'}</td>
                      <td className="px-5 py-3 text-sm">
                        <span className="font-semibold text-dark">{b.current_qty}</span>
                        <span className="text-gray-med"> / {b.initial_qty}</span>
                      </td>
                      <td className="px-5 py-3 text-sm">
                        <span className={b.mortality_rate >= 10 ? 'text-red-500 font-semibold' : 'text-gray-med'}>
                          {b.mortality_count} ({b.mortality_rate}%)
                        </span>
                      </td>
                      <td className="px-5 py-3 text-sm text-gray-med" title="Indice de consommation (kg d'aliment par kg vif)">
                        {b.feed_conversion ?? '—'}
                      </td>
                      <td className="px-5 py-3 text-xs text-gray-med">{b.product?.name || '—'}</td>
                      <td className="px-5 py-3">
                        <span className={`text-xs font-bold px-2.5 py-1 rounded-full ${st?.cls}`}>{st?.label}</span>
                      </td>
                      <td className="px-5 py-3">
                        <div className="flex gap-2">
                          <button onClick={() => openEdit(b)}
                            className="text-xs bg-blue-mid/10 text-blue-mid hover:bg-blue-mid/20 px-3 py-1.5 rounded-lg border-0 cursor-pointer">Modifier</button>
                          <button onClick={() => remove(b)}
                            className="text-xs bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1.5 rounded-lg border-0 cursor-pointer">Supprimer</button>
                        </div>
                      </td>
                    </tr>
                  )
                })}
              </tbody>
            </table>
          )}
        </div>
      </div>

      {showForm && (
        <div className="admin-card">
          <div className="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">{editing ? `Modifier ${editing.code}` : 'Nouvelle bande'}</h2>
            <button onClick={() => setShow(false)} className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
          </div>
          <form onSubmit={submit} className="p-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label className="form-label">Code de la bande *</label>
                <input required className="form-input" placeholder="B-2026-01" value={form.code}
                       onChange={(e) => setForm({ ...form, code: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Atelier *</label>
                <select required className="form-input" value={form.farm_unit_id}
                        onChange={(e) => setForm({ ...form, farm_unit_id: e.target.value })}>
                  <option value="">Sélectionner…</option>
                  {units.map((u) => <option key={u.id} value={u.id}>{u.name}</option>)}
                </select>
              </div>
              <div>
                <label className="form-label">Espèce *</label>
                <input required className="form-input" placeholder="Poulet de chair" value={form.species}
                       onChange={(e) => setForm({ ...form, species: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Race / souche</label>
                <input className="form-input" value={form.breed}
                       onChange={(e) => setForm({ ...form, breed: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Date de démarrage *</label>
                <input type="date" required className="form-input" value={form.started_on}
                       onChange={(e) => setForm({ ...form, started_on: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Fin prévue</label>
                <input type="date" className="form-input" value={form.expected_end_on}
                       onChange={(e) => setForm({ ...form, expected_end_on: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Effectif initial *</label>
                <input type="number" min="1" required className="form-input" value={form.initial_qty}
                       onChange={(e) => setForm({ ...form, initial_qty: e.target.value })} />
                <p className="text-xs text-gray-med mt-1">
                  L'effectif vivant se calcule seul : effectif initial moins les mortalités enregistrées.
                </p>
              </div>
              <div>
                <label className="form-label">Poids moyen (g)</label>
                <input type="number" min="0" className="form-input" value={form.avg_weight_g}
                       onChange={(e) => setForm({ ...form, avg_weight_g: e.target.value })} />
                <p className="text-xs text-gray-med mt-1">Nécessaire au calcul de l'indice de consommation.</p>
              </div>
              <div>
                <label className="form-label">Produit du catalogue</label>
                <select className="form-input" value={form.product_id}
                        onChange={(e) => setForm({ ...form, product_id: e.target.value })}>
                  <option value="">Aucun</option>
                  {products.map((p) => <option key={p.id} value={p.id}>{p.name}</option>)}
                </select>
                <p className="text-xs text-gray-med mt-1">
                  Une bande « disponible » alimente le stock vendable de ce produit.
                </p>
              </div>
              <div>
                <label className="form-label">Statut</label>
                <select className="form-input" value={form.status}
                        onChange={(e) => setForm({ ...form, status: e.target.value })}>
                  {BATCH_STATUSES.map((s) => <option key={s.value} value={s.value}>{s.label}</option>)}
                </select>
              </div>
              <div className="md:col-span-2">
                <label className="form-label">Notes</label>
                <textarea rows={2} className="form-input resize-y" value={form.notes}
                          onChange={(e) => setForm({ ...form, notes: e.target.value })} />
              </div>
            </div>
            <div className="flex gap-3 mt-6">
              <button type="submit" className="btn-blue">💾 {editing ? 'Enregistrer' : 'Créer la bande'}</button>
              <button type="button" onClick={() => setShow(false)}
                className="px-5 py-2.5 border border-gray-200 text-gray-med text-sm rounded-lg hover:bg-off-white bg-transparent cursor-pointer">
                Annuler
              </button>
            </div>
          </form>
        </div>
      )}
    </div>
  )
}
