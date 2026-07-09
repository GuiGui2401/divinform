import { useCallback, useEffect, useState } from 'react'
import { farmAPI, MOVEMENT_TYPES, fmtDate, today } from '@/api/farm'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

const EMPTY_ITEM = { name: '', unit: 'kg', alert_threshold: '', unit_cost: '', active: true }
const EMPTY_MOVE = { feed_item_id: '', farm_batch_id: '', type: 'entree', quantity: '', occurred_on: today(), note: '' }

export default function FarmFeed() {
  const [items, setItems]         = useState([])
  const [movements, setMovements] = useState([])
  const [batches, setBatches]     = useState([])
  const [loading, setLoading]     = useState(true)

  const [itemForm, setItemForm]   = useState(EMPTY_ITEM)
  const [editingItem, setEditing] = useState(null)
  const [showItem, setShowItem]   = useState(false)

  const [moveForm, setMoveForm]   = useState(EMPTY_MOVE)
  const [showMove, setShowMove]   = useState(false)

  const load = useCallback(() => {
    setLoading(true)
    Promise.all([farmAPI.getFeedItems(), farmAPI.getMovements(), farmAPI.getBatches({ open: 1 })])
      .then(([i, m, b]) => { setItems(i.data.data); setMovements(m.data.data); setBatches(b.data.data) })
      .catch(() => toast.error('Chargement impossible'))
      .finally(() => setLoading(false))
  }, [])

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = 'Aliments & stocks'
  }, [])
  useEffect(load, [load])

  const submitItem = async (e) => {
    e.preventDefault()
    const payload = {
      ...itemForm,
      alert_threshold: itemForm.alert_threshold === '' ? 0 : Number(itemForm.alert_threshold),
      unit_cost:       itemForm.unit_cost === '' ? null : Number(itemForm.unit_cost),
    }
    try {
      if (editingItem) await farmAPI.updateFeedItem(editingItem.id, payload)
      else             await farmAPI.createFeedItem(payload)
      toast.success(editingItem ? 'Aliment mis à jour' : 'Aliment créé')
      setShowItem(false); setEditing(null); setItemForm(EMPTY_ITEM); load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const submitMove = async (e) => {
    e.preventDefault()
    const payload = {
      ...moveForm,
      farm_batch_id: moveForm.type === 'sortie' ? (moveForm.farm_batch_id || null) : null,
      quantity: Number(moveForm.quantity),
      note: moveForm.note || null,
    }
    try {
      await farmAPI.createMovement(payload)
      toast.success('Mouvement enregistré')
      setShowMove(false); setMoveForm(EMPTY_MOVE); load()
    } catch (err) {
      // Le backend refuse les stocks négatifs avec un message explicite.
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const removeMove = async (m) => {
    if (!confirm('Supprimer ce mouvement ? Le stock sera recalculé depuis l\'historique.')) return
    try { await farmAPI.deleteMovement(m.id); toast.success('Mouvement supprimé'); load() }
    catch (err) { toast.error(err.response?.data?.message || 'Erreur') }
  }

  const removeItem = async (i) => {
    if (!confirm(`Supprimer l'aliment « ${i.name} » ?`)) return
    try { await farmAPI.deleteFeedItem(i.id); toast.success('Aliment supprimé'); load() }
    catch (err) { toast.error(err.response?.data?.message || 'Erreur') }
  }

  const openMove = (item) => {
    setMoveForm({ ...EMPTY_MOVE, feed_item_id: item?.id ?? '' })
    setShowMove(true)
  }

  if (loading) return <div className="flex justify-center py-20"><Spinner size="lg" /></div>

  return (
    <div>
      {/* Aliments */}
      <div className="admin-card mb-6">
        <div className="flex flex-wrap items-center justify-between gap-4 p-6 border-b border-gray-100">
          <div>
            <h2 className="font-display font-bold text-dark">Aliments</h2>
            <p className="text-xs text-gray-med mt-0.5">
              Le stock découle des mouvements : il ne se saisit pas directement.
            </p>
          </div>
          <div className="flex gap-2">
            <button onClick={() => openMove(null)} className="btn-blue">＋ Mouvement</button>
            <button onClick={() => { setEditing(null); setItemForm(EMPTY_ITEM); setShowItem(true) }}
              className="px-4 py-2.5 border border-gray-200 text-gray-med text-sm rounded-lg hover:bg-off-white bg-transparent cursor-pointer">
              ＋ Aliment
            </button>
          </div>
        </div>

        {items.length === 0 ? (
          <div className="text-center py-16 text-gray-med">
            <div className="text-4xl mb-3">🌽</div>
            <p className="text-sm">Aucun aliment. Créez-en un (maïs, tourteau, provende…).</p>
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>{['Aliment', 'Stock', 'Seuil d\'alerte', 'Coût unitaire', 'Statut', 'Actions'].map((h) => (
                  <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                ))}</tr>
              </thead>
              <tbody>
                {items.map((i) => (
                  <tr key={i.id} className={`border-t border-gray-100 ${i.is_low ? 'bg-red-50/40' : 'hover:bg-off-white/50'}`}>
                    <td className="px-5 py-3 font-semibold text-dark text-sm">{i.name}</td>
                    <td className="px-5 py-3 text-sm">
                      <span className={i.is_low ? 'text-red-600 font-bold' : 'text-dark font-semibold'}>
                        {i.current_qty} {i.unit}
                      </span>
                      {i.is_low && <span className="ml-2 text-xs text-red-600">⚠️ à réapprovisionner</span>}
                    </td>
                    <td className="px-5 py-3 text-sm text-gray-med">
                      {i.alert_threshold > 0 ? `${i.alert_threshold} ${i.unit}` : '—'}
                    </td>
                    <td className="px-5 py-3 text-sm text-gray-med">
                      {i.unit_cost ? `${new Intl.NumberFormat('fr-FR').format(i.unit_cost)} FCFA` : '—'}
                    </td>
                    <td className="px-5 py-3">
                      <span className={`text-xs font-bold px-2.5 py-1 rounded-full
                        ${i.active ? 'bg-green/10 text-green' : 'bg-gray-100 text-gray-med'}`}>
                        {i.active ? 'Actif' : 'Inactif'}
                      </span>
                    </td>
                    <td className="px-5 py-3">
                      <div className="flex flex-wrap gap-1.5">
                        <button onClick={() => openMove(i)}
                          className="text-xs bg-green/10 text-green hover:bg-green/20 px-2.5 py-1.5 rounded-lg border-0 cursor-pointer">Mouvement</button>
                        <button onClick={() => { setEditing(i); setItemForm({ name: i.name, unit: i.unit, alert_threshold: i.alert_threshold, unit_cost: i.unit_cost ?? '', active: i.active }); setShowItem(true) }}
                          className="text-xs bg-blue-mid/10 text-blue-mid hover:bg-blue-mid/20 px-2.5 py-1.5 rounded-lg border-0 cursor-pointer">Modifier</button>
                        <button onClick={() => removeItem(i)}
                          className="text-xs bg-red-50 text-red-500 hover:bg-red-100 px-2.5 py-1.5 rounded-lg border-0 cursor-pointer">✕</button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>

      {/* Historique des mouvements */}
      <div className="admin-card">
        <div className="p-6 border-b border-gray-100">
          <h2 className="font-display font-bold text-dark">Historique des mouvements</h2>
          <p className="text-xs text-gray-med mt-0.5">
            Une sortie affectée à une bande est une ration distribuée.
          </p>
        </div>
        {movements.length === 0 ? (
          <p className="text-sm text-gray-med text-center py-12">Aucun mouvement enregistré.</p>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>{['Date', 'Aliment', 'Type', 'Quantité', 'Stock après', 'Bande', 'Saisi par', ''].map((h, i) => (
                  <th key={i} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                ))}</tr>
              </thead>
              <tbody>
                {movements.map((m) => {
                  const t = MOVEMENT_TYPES.find((x) => x.value === m.type)
                  return (
                    <tr key={m.id} className="border-t border-gray-100 hover:bg-off-white/50">
                      <td className="px-5 py-3 text-sm text-gray-med">{fmtDate(m.occurred_on)}</td>
                      <td className="px-5 py-3 text-sm font-semibold text-dark">{m.item?.name}</td>
                      <td className="px-5 py-3">
                        <span className={`text-xs font-bold px-2.5 py-1 rounded-full ${t?.cls}`}>{t?.label}</span>
                      </td>
                      <td className="px-5 py-3 text-sm text-dark">
                        {m.type === 'entree' ? '+' : m.type === 'ajustement' ? '=' : '−'}
                        {m.quantity} {m.item?.unit}
                      </td>
                      <td className="px-5 py-3 text-sm text-gray-med">{m.qty_after} {m.item?.unit}</td>
                      <td className="px-5 py-3 text-xs text-gray-med">{m.batch?.code || '—'}</td>
                      <td className="px-5 py-3 text-xs text-gray-med">{m.user || '—'}</td>
                      <td className="px-5 py-3">
                        <button onClick={() => removeMove(m)}
                          className="text-xs bg-red-50 text-red-500 hover:bg-red-100 px-2.5 py-1.5 rounded-lg border-0 cursor-pointer">✕</button>
                      </td>
                    </tr>
                  )
                })}
              </tbody>
            </table>
          </div>
        )}
      </div>

      {/* Formulaire aliment */}
      {showItem && (
        <Modal title={editingItem ? 'Modifier l\'aliment' : 'Nouvel aliment'} onClose={() => setShowItem(false)}>
          <form onSubmit={submitItem}>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div className="sm:col-span-2">
                <label className="form-label">Nom *</label>
                <input required className="form-input" placeholder="Maïs concassé" value={itemForm.name}
                       onChange={(e) => setItemForm({ ...itemForm, name: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Unité</label>
                <select className="form-input" value={itemForm.unit}
                        onChange={(e) => setItemForm({ ...itemForm, unit: e.target.value })}>
                  <option value="kg">kg</option>
                  <option value="sac">sac</option>
                  <option value="L">litre</option>
                </select>
              </div>
              <div>
                <label className="form-label">Seuil d'alerte <span className="text-gray-med font-normal">(0 = aucune)</span></label>
                <input type="number" min="0" step="0.001" className="form-input" value={itemForm.alert_threshold}
                       onChange={(e) => setItemForm({ ...itemForm, alert_threshold: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Coût unitaire (FCFA)</label>
                <input type="number" min="0" className="form-input" value={itemForm.unit_cost}
                       onChange={(e) => setItemForm({ ...itemForm, unit_cost: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Statut</label>
                <select className="form-input" value={itemForm.active ? '1' : '0'}
                        onChange={(e) => setItemForm({ ...itemForm, active: e.target.value === '1' })}>
                  <option value="1">Actif</option>
                  <option value="0">Inactif</option>
                </select>
              </div>
            </div>
            <button type="submit" className="btn-blue mt-5 w-full">💾 Enregistrer</button>
          </form>
        </Modal>
      )}

      {/* Formulaire mouvement */}
      {showMove && (
        <Modal title="Nouveau mouvement de stock" onClose={() => setShowMove(false)}>
          <form onSubmit={submitMove}>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div className="sm:col-span-2">
                <label className="form-label">Aliment *</label>
                <select required className="form-input" value={moveForm.feed_item_id}
                        onChange={(e) => setMoveForm({ ...moveForm, feed_item_id: e.target.value })}>
                  <option value="">Sélectionner…</option>
                  {items.map((i) => (
                    <option key={i.id} value={i.id}>{i.name} — {i.current_qty} {i.unit} en stock</option>
                  ))}
                </select>
              </div>
              <div>
                <label className="form-label">Type *</label>
                <select className="form-input" value={moveForm.type}
                        onChange={(e) => setMoveForm({ ...moveForm, type: e.target.value })}>
                  {MOVEMENT_TYPES.map((t) => <option key={t.value} value={t.value}>{t.label}</option>)}
                </select>
              </div>
              <div>
                <label className="form-label">Quantité *</label>
                <input type="number" min="0" step="0.001" required className="form-input" value={moveForm.quantity}
                       onChange={(e) => setMoveForm({ ...moveForm, quantity: e.target.value })} />
              </div>

              {moveForm.type === 'sortie' && (
                <div className="sm:col-span-2">
                  <label className="form-label">Bande nourrie <span className="text-gray-med font-normal">(facultatif)</span></label>
                  <select className="form-input" value={moveForm.farm_batch_id}
                          onChange={(e) => setMoveForm({ ...moveForm, farm_batch_id: e.target.value })}>
                    <option value="">Non affectée</option>
                    {batches.map((b) => <option key={b.id} value={b.id}>{b.code} — {b.species}</option>)}
                  </select>
                  <p className="text-xs text-gray-med mt-1">
                    Affecter la sortie à une bande permet de calculer son indice de consommation.
                  </p>
                </div>
              )}

              {moveForm.type === 'ajustement' && (
                <p className="sm:col-span-2 text-xs text-amber-800 bg-amber-50 border border-amber-200 rounded-lg p-3">
                  Un ajustement fixe le stock à la quantité saisie (inventaire physique), il ne l'ajoute pas.
                </p>
              )}

              <div>
                <label className="form-label">Date *</label>
                <input type="date" required className="form-input" value={moveForm.occurred_on}
                       onChange={(e) => setMoveForm({ ...moveForm, occurred_on: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Note</label>
                <input className="form-input" value={moveForm.note}
                       onChange={(e) => setMoveForm({ ...moveForm, note: e.target.value })} />
              </div>
            </div>
            <button type="submit" className="btn-blue mt-5 w-full">💾 Enregistrer le mouvement</button>
          </form>
        </Modal>
      )}
    </div>
  )
}

function Modal({ title, onClose, children }) {
  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-dark/70"
         onClick={(e) => e.target === e.currentTarget && onClose()}>
      <div className="bg-white rounded-2xl w-full max-w-xl max-h-[88vh] overflow-y-auto">
        <div className="flex items-center justify-between p-6 border-b border-gray-100 sticky top-0 bg-white">
          <h2 className="font-display font-bold text-dark">{title}</h2>
          <button onClick={onClose} className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
        </div>
        <div className="p-6">{children}</div>
      </div>
    </div>
  )
}
