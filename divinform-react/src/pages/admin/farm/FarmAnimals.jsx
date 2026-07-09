import { useCallback, useEffect, useState } from 'react'
import { farmAPI, ANIMAL_STATUSES, fmtDate } from '@/api/farm'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

const EMPTY = {
  farm_unit_id: '', farm_batch_id: '', tag: '', name: '', species: '',
  breed: '', sex: '', born_on: '', entered_on: '', status: 'actif', notes: '',
}

export default function FarmAnimals() {
  const [animals, setAnimals] = useState([])
  const [units, setUnits]     = useState([])
  const [batches, setBatches] = useState([])
  const [loading, setLoading] = useState(true)
  const [search, setSearch]   = useState('')
  const [form, setForm]       = useState(EMPTY)
  const [editing, setEditing] = useState(null)
  const [showForm, setShow]   = useState(false)

  const load = useCallback(() => {
    setLoading(true)
    Promise.all([farmAPI.getAnimals(), farmAPI.getUnits(), farmAPI.getBatches({ open: 1 })])
      .then(([a, u, b]) => { setAnimals(a.data.data); setUnits(u.data.data); setBatches(b.data.data) })
      .catch(() => toast.error('Chargement impossible'))
      .finally(() => setLoading(false))
  }, [])

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = 'Animaux'
  }, [])
  useEffect(load, [load])

  const submit = async (e) => {
    e.preventDefault()
    const payload = {
      ...form,
      farm_batch_id: form.farm_batch_id || null,
      name: form.name || null, breed: form.breed || null, sex: form.sex || null,
      born_on: form.born_on || null, entered_on: form.entered_on || null,
    }
    try {
      if (editing) await farmAPI.updateAnimal(editing.id, payload)
      else         await farmAPI.createAnimal(payload)
      toast.success(editing ? 'Animal mis à jour' : 'Animal enregistré')
      setShow(false); setEditing(null); setForm(EMPTY); load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const remove = async (a) => {
    if (!confirm(`Supprimer l'animal ${a.tag} ?`)) return
    try { await farmAPI.deleteAnimal(a.id); toast.success('Animal supprimé'); load() }
    catch (err) { toast.error(err.response?.data?.message || 'Erreur') }
  }

  const openEdit = (a) => {
    setEditing(a)
    setForm({
      farm_unit_id: a.farm_unit_id, farm_batch_id: a.farm_batch_id ?? '', tag: a.tag,
      name: a.name || '', species: a.species, breed: a.breed || '', sex: a.sex || '',
      born_on: a.born_on || '', entered_on: a.entered_on || '', status: a.status, notes: a.notes || '',
    })
    setShow(true)
  }

  const filtered = animals.filter((a) =>
    `${a.tag} ${a.name || ''}`.toLowerCase().includes(search.toLowerCase())
  )

  return (
    <div>
      <div className="admin-card">
        <div className="flex flex-wrap items-center justify-between gap-4 p-6 border-b border-gray-100">
          <div className="flex items-center gap-3 flex-1">
            <input className="form-input max-w-xs" placeholder="Rechercher par identifiant ou nom…"
                   value={search} onChange={(e) => setSearch(e.target.value)} />
            <span className="text-gray-med text-sm">{filtered.length} animal(aux)</span>
          </div>
          <button onClick={() => { setEditing(null); setForm(EMPTY); setShow(true) }} className="btn-blue">
            ＋ Nouvel animal
          </button>
        </div>

        <div className="overflow-x-auto">
          {loading ? <div className="flex justify-center py-12"><Spinner /></div>
          : filtered.length === 0 ? (
            <div className="text-center py-16 text-gray-med">
              <div className="text-4xl mb-3">🐄</div>
              <p className="text-sm">Aucun animal identifié individuellement (truies, reproducteurs…).</p>
            </div>
          ) : (
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>{['Identifiant', 'Espèce', 'Sexe', 'Naissance', 'Atelier', 'Statut', 'Actions'].map((h) => (
                  <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                ))}</tr>
              </thead>
              <tbody>
                {filtered.map((a) => {
                  const st = ANIMAL_STATUSES.find((s) => s.value === a.status)
                  return (
                    <tr key={a.id} className="border-t border-gray-100 hover:bg-off-white/50">
                      <td className="px-5 py-3">
                        <div className="font-semibold text-dark text-sm">{a.tag}</div>
                        {a.name && <div className="text-xs text-gray-med">{a.name}</div>}
                      </td>
                      <td className="px-5 py-3 text-sm text-gray-med">
                        {a.species}{a.breed ? ` · ${a.breed}` : ''}
                      </td>
                      <td className="px-5 py-3 text-sm text-gray-med">
                        {a.sex === 'M' ? '♂ Mâle' : a.sex === 'F' ? '♀ Femelle' : '—'}
                      </td>
                      <td className="px-5 py-3 text-sm text-gray-med">{fmtDate(a.born_on)}</td>
                      <td className="px-5 py-3 text-sm text-gray-med">{a.unit?.name || '—'}</td>
                      <td className="px-5 py-3">
                        <span className={`text-xs font-bold px-2.5 py-1 rounded-full ${st?.cls}`}>{st?.label}</span>
                      </td>
                      <td className="px-5 py-3">
                        <div className="flex gap-2">
                          <button onClick={() => openEdit(a)}
                            className="text-xs bg-blue-mid/10 text-blue-mid hover:bg-blue-mid/20 px-3 py-1.5 rounded-lg border-0 cursor-pointer">Modifier</button>
                          <button onClick={() => remove(a)}
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
            <h2 className="font-display font-bold text-dark">{editing ? `Modifier ${editing.tag}` : 'Nouvel animal'}</h2>
            <button onClick={() => setShow(false)} className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
          </div>
          <form onSubmit={submit} className="p-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label className="form-label">Identifiant (boucle) *</label>
                <input required className="form-input" placeholder="TRUIE-01" value={form.tag}
                       onChange={(e) => setForm({ ...form, tag: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Nom d'usage</label>
                <input className="form-input" value={form.name}
                       onChange={(e) => setForm({ ...form, name: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Espèce *</label>
                <input required className="form-input" placeholder="Porc" value={form.species}
                       onChange={(e) => setForm({ ...form, species: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Race</label>
                <input className="form-input" value={form.breed}
                       onChange={(e) => setForm({ ...form, breed: e.target.value })} />
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
                <label className="form-label">Issu de la bande</label>
                <select className="form-input" value={form.farm_batch_id}
                        onChange={(e) => setForm({ ...form, farm_batch_id: e.target.value })}>
                  <option value="">Aucune</option>
                  {batches.map((b) => <option key={b.id} value={b.id}>{b.code}</option>)}
                </select>
              </div>
              <div>
                <label className="form-label">Sexe</label>
                <select className="form-input" value={form.sex}
                        onChange={(e) => setForm({ ...form, sex: e.target.value })}>
                  <option value="">—</option>
                  <option value="M">Mâle</option>
                  <option value="F">Femelle</option>
                </select>
              </div>
              <div>
                <label className="form-label">Statut</label>
                <select className="form-input" value={form.status}
                        onChange={(e) => setForm({ ...form, status: e.target.value })}>
                  {ANIMAL_STATUSES.map((s) => <option key={s.value} value={s.value}>{s.label}</option>)}
                </select>
              </div>
              <div>
                <label className="form-label">Date de naissance</label>
                <input type="date" className="form-input" value={form.born_on}
                       onChange={(e) => setForm({ ...form, born_on: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Date d'entrée</label>
                <input type="date" className="form-input" value={form.entered_on}
                       onChange={(e) => setForm({ ...form, entered_on: e.target.value })} />
              </div>
              <div className="md:col-span-2">
                <label className="form-label">Notes</label>
                <textarea rows={2} className="form-input resize-y" value={form.notes}
                          onChange={(e) => setForm({ ...form, notes: e.target.value })} />
              </div>
            </div>
            <div className="flex gap-3 mt-6">
              <button type="submit" className="btn-blue">💾 {editing ? 'Enregistrer' : 'Enregistrer l\'animal'}</button>
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
