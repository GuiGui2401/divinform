import { useCallback, useEffect, useState } from 'react'
import { farmAPI, HEALTH_TYPES, fmtDate, today } from '@/api/farm'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

const EMPTY = {
  target: 'batch', farm_batch_id: '', farm_animal_id: '',
  type: 'traitement', label: '', medicine: '', dose: '', quantity: '',
  occurred_on: today(), next_due_on: '', withdrawal_until: '', cost: '', note: '',
}

export default function FarmHealth() {
  const [events, setEvents]   = useState([])
  const [batches, setBatches] = useState([])
  const [animals, setAnimals] = useState([])
  const [loading, setLoading] = useState(true)
  const [type, setType]       = useState('')
  const [form, setForm]       = useState(EMPTY)
  const [showForm, setShow]   = useState(false)

  const load = useCallback(() => {
    setLoading(true)
    Promise.all([
      farmAPI.getHealthEvents(type ? { type } : {}),
      farmAPI.getBatches({ open: 1 }),
      farmAPI.getAnimals({ status: 'actif' }),
    ])
      .then(([e, b, a]) => { setEvents(e.data.data); setBatches(b.data.data); setAnimals(a.data.data) })
      .catch(() => toast.error('Chargement impossible'))
      .finally(() => setLoading(false))
  }, [type])

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = 'Suivi vétérinaire'
  }, [])
  useEffect(load, [load])

  const submit = async (e) => {
    e.preventDefault()
    const payload = {
      type: form.type,
      label: form.label,
      farm_batch_id:  form.target === 'batch'  ? form.farm_batch_id  : null,
      farm_animal_id: form.target === 'animal' ? form.farm_animal_id : null,
      medicine: form.medicine || null,
      dose: form.dose || null,
      quantity: form.quantity === '' ? null : Number(form.quantity),
      occurred_on: form.occurred_on,
      next_due_on: form.next_due_on || null,
      withdrawal_until: form.withdrawal_until || null,
      cost: form.cost === '' ? null : Number(form.cost),
      note: form.note || null,
    }
    try {
      await farmAPI.createHealthEvent(payload)
      toast.success('Événement enregistré')
      setShow(false); setForm(EMPTY); load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const remove = async (ev) => {
    const extra = ev.type === 'mortalite' ? '\nL\'effectif de la bande sera restauré.' : ''
    if (!confirm(`Supprimer « ${ev.label} » ?${extra}`)) return
    try { await farmAPI.deleteHealthEvent(ev.id); toast.success('Événement supprimé'); load() }
    catch (err) { toast.error(err.response?.data?.message || 'Erreur') }
  }

  const isMortalityOnBatch = form.type === 'mortalite' && form.target === 'batch'

  return (
    <div>
      <div className="admin-card">
        <div className="flex flex-wrap items-center justify-between gap-4 p-6 border-b border-gray-100">
          <div className="flex flex-wrap gap-2">
            <button onClick={() => setType('')}
              className={`text-xs font-semibold px-3.5 py-1.5 rounded-full border cursor-pointer
                ${type === '' ? 'bg-blue-dark text-white border-blue-dark' : 'bg-white text-gray-med border-gray-200'}`}>
              Tous
            </button>
            {HEALTH_TYPES.map((t) => (
              <button key={t.value} onClick={() => setType(t.value)}
                className={`text-xs font-semibold px-3.5 py-1.5 rounded-full border cursor-pointer
                  ${type === t.value ? 'bg-blue-dark text-white border-blue-dark' : 'bg-white text-gray-med border-gray-200'}`}>
                {t.label}
              </button>
            ))}
          </div>
          <button onClick={() => { setForm(EMPTY); setShow(true) }} className="btn-blue">＋ Nouvel événement</button>
        </div>

        <div className="overflow-x-auto">
          {loading ? <div className="flex justify-center py-12"><Spinner /></div>
          : events.length === 0 ? (
            <div className="text-center py-16 text-gray-med">
              <div className="text-4xl mb-3">💉</div>
              <p className="text-sm">Aucun événement sanitaire enregistré.</p>
            </div>
          ) : (
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>{['Date', 'Type', 'Intitulé', 'Concerne', 'Produit / dose', 'Rappel', 'Délai d\'attente', ''].map((h, i) => (
                  <th key={i} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                ))}</tr>
              </thead>
              <tbody>
                {events.map((ev) => {
                  const t = HEALTH_TYPES.find((x) => x.value === ev.type)
                  const dueSoon = ev.next_due_on && new Date(ev.next_due_on) <= new Date(Date.now() + 14 * 864e5)
                  return (
                    <tr key={ev.id} className="border-t border-gray-100 hover:bg-off-white/50">
                      <td className="px-5 py-3 text-sm text-gray-med">{fmtDate(ev.occurred_on)}</td>
                      <td className="px-5 py-3">
                        <span className={`text-xs font-bold px-2.5 py-1 rounded-full ${t?.cls}`}>{t?.label}</span>
                      </td>
                      <td className="px-5 py-3 text-sm font-semibold text-dark">
                        {ev.label}
                        {ev.type === 'mortalite' && ev.quantity && (
                          <span className="text-xs text-red-500 font-normal"> — {ev.quantity} animal(aux)</span>
                        )}
                      </td>
                      <td className="px-5 py-3 text-xs text-gray-med">{ev.batch?.code || ev.animal?.tag || '—'}</td>
                      <td className="px-5 py-3 text-xs text-gray-med">
                        {ev.medicine || '—'}{ev.dose ? ` · ${ev.dose}` : ''}
                      </td>
                      <td className="px-5 py-3 text-xs">
                        {ev.next_due_on
                          ? <span className={dueSoon ? 'text-red-600 font-semibold' : 'text-gray-med'}>{fmtDate(ev.next_due_on)}</span>
                          : <span className="text-gray-med">—</span>}
                      </td>
                      <td className="px-5 py-3 text-xs text-gray-med">
                        {ev.withdrawal_until ? `jusqu'au ${fmtDate(ev.withdrawal_until)}` : '—'}
                      </td>
                      <td className="px-5 py-3">
                        <button onClick={() => remove(ev)}
                          className="text-xs bg-red-50 text-red-500 hover:bg-red-100 px-2.5 py-1.5 rounded-lg border-0 cursor-pointer">✕</button>
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
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-dark/70"
             onClick={(e) => e.target === e.currentTarget && setShow(false)}>
          <div className="bg-white rounded-2xl w-full max-w-2xl max-h-[88vh] overflow-y-auto">
            <div className="flex items-center justify-between p-6 border-b border-gray-100 sticky top-0 bg-white">
              <h2 className="font-display font-bold text-dark">Nouvel événement sanitaire</h2>
              <button onClick={() => setShow(false)} className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
            </div>

            <form onSubmit={submit} className="p-6">
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label className="form-label">Type *</label>
                  <select className="form-input" value={form.type}
                          onChange={(e) => setForm({ ...form, type: e.target.value })}>
                    {HEALTH_TYPES.map((t) => <option key={t.value} value={t.value}>{t.label}</option>)}
                  </select>
                </div>
                <div>
                  <label className="form-label">Concerne *</label>
                  <select className="form-input" value={form.target}
                          onChange={(e) => setForm({ ...form, target: e.target.value })}>
                    <option value="batch">Une bande</option>
                    <option value="animal">Un animal identifié</option>
                  </select>
                </div>

                <div className="sm:col-span-2">
                  {form.target === 'batch' ? (
                    <>
                      <label className="form-label">Bande *</label>
                      <select required className="form-input" value={form.farm_batch_id}
                              onChange={(e) => setForm({ ...form, farm_batch_id: e.target.value })}>
                        <option value="">Sélectionner…</option>
                        {batches.map((b) => (
                          <option key={b.id} value={b.id}>{b.code} — {b.current_qty} vivants</option>
                        ))}
                      </select>
                    </>
                  ) : (
                    <>
                      <label className="form-label">Animal *</label>
                      <select required className="form-input" value={form.farm_animal_id}
                              onChange={(e) => setForm({ ...form, farm_animal_id: e.target.value })}>
                        <option value="">Sélectionner…</option>
                        {animals.map((a) => <option key={a.id} value={a.id}>{a.tag}{a.name ? ` (${a.name})` : ''}</option>)}
                      </select>
                    </>
                  )}
                </div>

                <div className="sm:col-span-2">
                  <label className="form-label">Intitulé *</label>
                  <input required className="form-input" placeholder="Vaccination Newcastle" value={form.label}
                         onChange={(e) => setForm({ ...form, label: e.target.value })} />
                </div>

                {isMortalityOnBatch && (
                  <div className="sm:col-span-2">
                    <label className="form-label">Nombre d'animaux morts *</label>
                    <input type="number" min="1" required className="form-input" value={form.quantity}
                           onChange={(e) => setForm({ ...form, quantity: e.target.value })} />
                    <p className="text-xs text-gray-med mt-1">
                      L'effectif vivant de la bande sera recalculé automatiquement.
                    </p>
                  </div>
                )}

                {form.type !== 'mortalite' && (
                  <>
                    <div>
                      <label className="form-label">Produit / médicament</label>
                      <input className="form-input" value={form.medicine}
                             onChange={(e) => setForm({ ...form, medicine: e.target.value })} />
                    </div>
                    <div>
                      <label className="form-label">Dose</label>
                      <input className="form-input" placeholder="1 mL / animal" value={form.dose}
                             onChange={(e) => setForm({ ...form, dose: e.target.value })} />
                    </div>
                  </>
                )}

                <div>
                  <label className="form-label">Date *</label>
                  <input type="date" required className="form-input" value={form.occurred_on}
                         onChange={(e) => setForm({ ...form, occurred_on: e.target.value })} />
                </div>
                <div>
                  <label className="form-label">Coût (FCFA)</label>
                  <input type="number" min="0" className="form-input" value={form.cost}
                         onChange={(e) => setForm({ ...form, cost: e.target.value })} />
                </div>

                {form.type === 'vaccination' && (
                  <div>
                    <label className="form-label">Rappel prévu le</label>
                    <input type="date" className="form-input" value={form.next_due_on}
                           onChange={(e) => setForm({ ...form, next_due_on: e.target.value })} />
                  </div>
                )}
                {form.type === 'traitement' && (
                  <div>
                    <label className="form-label">Délai d'attente jusqu'au</label>
                    <input type="date" className="form-input" value={form.withdrawal_until}
                           onChange={(e) => setForm({ ...form, withdrawal_until: e.target.value })} />
                    <p className="text-xs text-gray-med mt-1">Avant cette date, pas de consommation.</p>
                  </div>
                )}

                <div className="sm:col-span-2">
                  <label className="form-label">Note</label>
                  <textarea rows={2} className="form-input resize-y" value={form.note}
                            onChange={(e) => setForm({ ...form, note: e.target.value })} />
                </div>
              </div>

              <div className="flex gap-3 mt-6">
                <button type="submit" className="btn-blue">💾 Enregistrer</button>
                <button type="button" onClick={() => setShow(false)}
                  className="px-5 py-2.5 border border-gray-200 text-gray-med text-sm rounded-lg hover:bg-off-white bg-transparent cursor-pointer">
                  Annuler
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  )
}
