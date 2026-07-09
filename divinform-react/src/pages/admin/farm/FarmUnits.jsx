import { useCallback, useEffect, useState } from 'react'
import { farmAPI, UNIT_TYPES } from '@/api/farm'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

const EMPTY = { name: '', type: 'aviculture', location: '', capacity: '', notes: '', active: true }

export default function FarmUnits() {
  const [units, setUnits]     = useState([])
  const [loading, setLoading] = useState(true)
  const [form, setForm]       = useState(EMPTY)
  const [editing, setEditing] = useState(null)
  const [showForm, setShow]   = useState(false)

  const load = useCallback(() => {
    setLoading(true)
    farmAPI.getUnits()
      .then((res) => setUnits(res.data.data))
      .catch(() => toast.error('Chargement impossible'))
      .finally(() => setLoading(false))
  }, [])

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = 'Ateliers'
  }, [])
  useEffect(load, [load])

  const submit = async (e) => {
    e.preventDefault()
    const payload = { ...form, capacity: form.capacity === '' ? null : Number(form.capacity) }
    try {
      if (editing) await farmAPI.updateUnit(editing.id, payload)
      else         await farmAPI.createUnit(payload)
      toast.success(editing ? 'Atelier mis à jour' : 'Atelier créé')
      setShow(false); setEditing(null); setForm(EMPTY); load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const remove = async (u) => {
    if (!confirm(`Supprimer l'atelier « ${u.name} » ?`)) return
    try {
      await farmAPI.deleteUnit(u.id)
      toast.success('Atelier supprimé'); load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const openEdit = (u) => {
    setEditing(u)
    setForm({
      name: u.name, type: u.type, location: u.location || '',
      capacity: u.capacity ?? '', notes: u.notes || '', active: u.active,
    })
    setShow(true)
  }

  return (
    <div>
      <div className="admin-card">
        <div className="flex items-center justify-between gap-4 p-6 border-b border-gray-100">
          <span className="text-gray-med text-sm">{units.length} atelier{units.length > 1 ? 's' : ''}</span>
          <button onClick={() => { setEditing(null); setForm(EMPTY); setShow(true) }} className="btn-blue">
            ＋ Nouvel atelier
          </button>
        </div>

        <div className="overflow-x-auto">
          {loading ? <div className="flex justify-center py-12"><Spinner /></div>
          : units.length === 0 ? (
            <div className="text-center py-16 text-gray-med">
              <div className="text-4xl mb-3">🏠</div>
              <p className="text-sm">Aucun atelier. Créez le premier (poulailler, porcherie, bassin…).</p>
            </div>
          ) : (
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>{['Atelier', 'Type', 'Lieu', 'Effectif', 'Capacité', 'Statut', 'Actions'].map((h) => (
                  <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                ))}</tr>
              </thead>
              <tbody>
                {units.map((u) => (
                  <tr key={u.id} className="border-t border-gray-100 hover:bg-off-white/50">
                    <td className="px-5 py-3">
                      <div className="font-semibold text-dark text-sm">{u.name}</div>
                      <div className="text-xs text-gray-med">{u.batches_count} bande(s) · {u.animals_count} animal(aux)</div>
                    </td>
                    <td className="px-5 py-3 text-sm text-gray-med">
                      {UNIT_TYPES.find((t) => t.value === u.type)?.label || u.type}
                    </td>
                    <td className="px-5 py-3 text-sm text-gray-med">{u.location || '—'}</td>
                    <td className="px-5 py-3 text-sm font-semibold text-dark">{u.headcount}</td>
                    <td className="px-5 py-3 text-sm text-gray-med">
                      {u.capacity
                        ? <span className={u.headcount > u.capacity ? 'text-red-500 font-semibold' : ''}>{u.capacity}</span>
                        : '—'}
                    </td>
                    <td className="px-5 py-3">
                      <span className={`text-xs font-bold px-2.5 py-1 rounded-full
                        ${u.active ? 'bg-green/10 text-green' : 'bg-gray-100 text-gray-med'}`}>
                        {u.active ? 'Actif' : 'Inactif'}
                      </span>
                    </td>
                    <td className="px-5 py-3">
                      <div className="flex gap-2">
                        <button onClick={() => openEdit(u)}
                          className="text-xs bg-blue-mid/10 text-blue-mid hover:bg-blue-mid/20 px-3 py-1.5 rounded-lg border-0 cursor-pointer">Modifier</button>
                        <button onClick={() => remove(u)}
                          className="text-xs bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1.5 rounded-lg border-0 cursor-pointer">Supprimer</button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>

      {showForm && (
        <div className="admin-card">
          <div className="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">{editing ? 'Modifier l\'atelier' : 'Nouvel atelier'}</h2>
            <button onClick={() => setShow(false)} className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
          </div>
          <form onSubmit={submit} className="p-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label className="form-label">Nom *</label>
                <input required className="form-input" placeholder="Poulailler 1"
                       value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Type</label>
                <select className="form-input" value={form.type} onChange={(e) => setForm({ ...form, type: e.target.value })}>
                  {UNIT_TYPES.map((t) => <option key={t.value} value={t.value}>{t.label}</option>)}
                </select>
              </div>
              <div>
                <label className="form-label">Lieu</label>
                <input className="form-input" value={form.location} onChange={(e) => setForm({ ...form, location: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Capacité <span className="text-gray-med font-normal">(nombre d'animaux)</span></label>
                <input type="number" min="0" className="form-input" value={form.capacity}
                       onChange={(e) => setForm({ ...form, capacity: e.target.value })} />
              </div>
              <div className="md:col-span-2">
                <label className="form-label">Notes</label>
                <textarea rows={2} className="form-input resize-y" value={form.notes}
                          onChange={(e) => setForm({ ...form, notes: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Statut</label>
                <select className="form-input" value={form.active ? '1' : '0'}
                        onChange={(e) => setForm({ ...form, active: e.target.value === '1' })}>
                  <option value="1">Actif</option>
                  <option value="0">Inactif</option>
                </select>
              </div>
            </div>
            <div className="flex gap-3 mt-6">
              <button type="submit" className="btn-blue">💾 {editing ? 'Enregistrer' : 'Créer'}</button>
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
