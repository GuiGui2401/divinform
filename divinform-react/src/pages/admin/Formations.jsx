import { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { useForm } from 'react-hook-form'
import {
  fetchFormations,
  createFormation,
  updateFormation,
  deleteFormation,
  selectAllFormations,
  selectFormationsLoading,
} from '@/store/slices/formationsSlice'
import { formationsAPI } from '@/api/formations'
import Spinner from '@/components/ui/Spinner'
import ImageUploader from '@/components/admin/ImageUploader'
import toast from 'react-hot-toast'

const LEVELS = [
  { value: 'debutant',      label: 'Débutant' },
  { value: 'intermediaire', label: 'Intermédiaire' },
  { value: 'avance',        label: 'Avancé' },
]

const fmtDate = (iso) =>
  iso ? new Date(iso).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' }) : '—'

export default function Formations() {
  const dispatch   = useDispatch()
  const formations = useSelector(selectAllFormations)
  const loading    = useSelector(selectFormationsLoading)

  const [showForm, setShowForm]   = useState(false)
  const [editing, setEditing]     = useState(null)
  const [search, setSearch]       = useState('')
  const [images, setImages]       = useState([])
  const [objectives, setObjectives] = useState([])
  const [program, setProgram]     = useState([])
  const [sessionsFor, setSessionsFor] = useState(null)

  const { register, handleSubmit, reset, formState: { errors } } = useForm()

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = 'Formations'
    dispatch(fetchFormations())
  }, [dispatch])

  const openCreate = () => {
    setEditing(null)
    reset({ level: 'debutant', currency: 'FCFA', featured: '0', active: '1' })
    setImages([]); setObjectives([]); setProgram([])
    setShowForm(true)
  }

  const openEdit = (f) => {
    setEditing(f)
    reset({
      title: f.title, summary: f.summary, description: f.description || '',
      level: f.level || 'debutant', duration: f.duration || '',
      prerequisites: f.prerequisites || '', certification: f.certification || '',
      price: f.price ?? '', currency: f.currency || 'FCFA',
      badge: f.badge || '', featured: f.featured ? '1' : '0', active: f.active ? '1' : '0',
    })
    setImages(f.images || [])
    setObjectives(f.objectives || [])
    setProgram(f.program || [])
    setShowForm(true)
  }

  const onSubmit = async (data) => {
    const fd = new FormData()
    Object.entries(data).forEach(([k, v]) => {
      // `price` vide = « nous consulter » : on l'envoie vide, le back le met à null.
      if (v !== undefined && (v !== '' || k === 'price')) fd.append(k, v)
    })
    fd.append('manage_images', '1')
    images.forEach((u) => fd.append('image_urls[]', u))
    fd.append('objectives', JSON.stringify(objectives.filter((o) => o.trim())))
    fd.append('program', JSON.stringify(program.filter((m) => m.title?.trim())))

    const action = editing
      ? updateFormation({ id: editing.id, formData: fd })
      : createFormation(fd)
    const res = await dispatch(action)

    if (res.error) {
      toast.error(res.payload || 'Erreur')
      return
    }
    toast.success(editing ? 'Formation modifiée' : 'Formation créée')
    setShowForm(false)
    dispatch(fetchFormations())
  }

  const handleDelete = async (id, title) => {
    if (!confirm(`Supprimer la formation "${title}" ?\nLes demandes d'inscription associées seront conservées.`)) return
    const res = await dispatch(deleteFormation(id))
    if (!res.error) toast.success('Formation supprimée')
    else toast.error(res.payload || 'Erreur')
  }

  const filtered = formations.filter((f) =>
    f.title?.toLowerCase().includes(search.toLowerCase())
  )

  return (
    <div>
      <div className="admin-card">
        <div className="flex flex-wrap items-center justify-between gap-4 p-6 border-b border-gray-100">
          <div className="flex items-center gap-3 flex-1">
            <input
              type="text"
              placeholder="Rechercher une formation…"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="form-input max-w-xs"
            />
            <span className="text-gray-med text-sm">
              {filtered.length} formation{filtered.length > 1 ? 's' : ''}
            </span>
          </div>
          <button onClick={openCreate} className="btn-blue">＋ Nouvelle formation</button>
        </div>

        <div className="overflow-x-auto">
          {loading ? (
            <div className="flex justify-center py-12"><Spinner /></div>
          ) : filtered.length === 0 ? (
            <div className="text-center py-16 text-gray-med">
              <div className="text-4xl mb-3">🎓</div>
              <p className="text-sm">Aucune formation. Créez la première.</p>
            </div>
          ) : (
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>
                  {['Formation', 'Niveau', 'Durée', 'Tarif', 'Sessions', 'Statut', 'Actions'].map((h) => (
                    <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {filtered.map((f) => (
                  <tr key={f.id} className="border-t border-gray-100 hover:bg-off-white/50">
                    <td className="px-5 py-3">
                      <div className="font-semibold text-dark text-sm">{f.title}</div>
                      <div className="text-xs text-gray-med mt-0.5">{f.summary?.slice(0, 60)}…</div>
                    </td>
                    <td className="px-5 py-3 text-sm text-gray-med">
                      {LEVELS.find((l) => l.value === f.level)?.label || '—'}
                    </td>
                    <td className="px-5 py-3 text-sm text-gray-med">{f.duration || '—'}</td>
                    <td className="px-5 py-3 text-sm text-gray-med">
                      {f.price ? `${new Intl.NumberFormat('fr-FR').format(f.price)} ${f.currency}` : 'Nous consulter'}
                    </td>
                    <td className="px-5 py-3">
                      <button onClick={() => setSessionsFor(f)}
                        className="text-xs bg-off-white text-dark hover:bg-gray-100 border border-gray-200
                                   px-3 py-1.5 rounded-lg transition-colors cursor-pointer">
                        📅 {f.sessions?.length || 0}
                      </button>
                    </td>
                    <td className="px-5 py-3">
                      <span className={`text-xs font-bold px-2.5 py-1 rounded-full
                        ${f.active ? 'bg-green/10 text-green' : 'bg-gray-100 text-gray-med'}`}>
                        {f.active ? 'Publiée' : 'Brouillon'}
                      </span>
                    </td>
                    <td className="px-5 py-3">
                      <div className="flex gap-2">
                        <button onClick={() => openEdit(f)}
                          className="text-xs bg-blue-mid/10 text-blue-mid hover:bg-blue-mid/20
                                     px-3 py-1.5 rounded-lg transition-colors border-0 cursor-pointer">
                          Modifier
                        </button>
                        <button onClick={() => handleDelete(f.id, f.title)}
                          className="text-xs bg-red-50 text-red-500 hover:bg-red-100
                                     px-3 py-1.5 rounded-lg transition-colors border-0 cursor-pointer">
                          Supprimer
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>

      {/* Formulaire */}
      {showForm && (
        <div className="admin-card">
          <div className="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">
              {editing ? 'Modifier la formation' : 'Nouvelle formation'}
            </h2>
            <button onClick={() => setShowForm(false)}
              className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
          </div>
          <form onSubmit={handleSubmit(onSubmit)} className="p-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div className="md:col-span-2">
                <label className="form-label">Titre de la formation *</label>
                <input className="form-input" placeholder="Ex : Élevage de poules pondeuses"
                  {...register('title', { required: 'Titre requis' })} />
                {errors.title && <p className="text-red-500 text-xs mt-1">{errors.title.message}</p>}
              </div>

              <div className="md:col-span-2">
                <label className="form-label">Résumé * <span className="text-gray-med font-normal">(affiché sur la carte)</span></label>
                <input className="form-input" placeholder="Une phrase qui donne envie…"
                  {...register('summary', { required: 'Résumé requis' })} />
                {errors.summary && <p className="text-red-500 text-xs mt-1">{errors.summary.message}</p>}
              </div>

              <div className="md:col-span-2">
                <label className="form-label">Présentation détaillée</label>
                <textarea className="form-input min-h-[110px] resize-y" {...register('description')} />
              </div>

              <div>
                <label className="form-label">Niveau</label>
                <select className="form-input" {...register('level')}>
                  {LEVELS.map((l) => <option key={l.value} value={l.value}>{l.label}</option>)}
                </select>
              </div>
              <div>
                <label className="form-label">Durée</label>
                <input className="form-input" placeholder="Ex : 5 jours" {...register('duration')} />
              </div>

              <div>
                <label className="form-label">
                  Tarif <span className="text-gray-med font-normal">(vide = « Nous consulter »)</span>
                </label>
                <input type="number" min="0" className="form-input" placeholder="75000" {...register('price')} />
              </div>
              <div>
                <label className="form-label">Devise</label>
                <input className="form-input" placeholder="FCFA" {...register('currency')} />
              </div>

              <div>
                <label className="form-label">Certification délivrée</label>
                <input className="form-input" placeholder="Attestation de fin de formation" {...register('certification')} />
              </div>
              <div>
                <label className="form-label">Badge (optionnel)</label>
                <input className="form-input" placeholder="Ex : NOUVEAU" {...register('badge')} />
              </div>

              <div className="md:col-span-2">
                <label className="form-label">Prérequis</label>
                <textarea className="form-input resize-y" rows={2}
                  placeholder="Aucun prérequis." {...register('prerequisites')} />
              </div>

              <div className="md:col-span-2">
                <label className="form-label">Images</label>
                <ImageUploader value={images} onChange={setImages} multiple folder="formations" />
              </div>

              {/* Objectifs */}
              <div className="md:col-span-2">
                <ListEditor
                  label="Objectifs pédagogiques"
                  items={objectives}
                  onChange={setObjectives}
                  blank=""
                  render={(item, set) => (
                    <input className="form-input" placeholder="Ce que le stagiaire saura faire…"
                           value={item} onChange={(e) => set(e.target.value)} />
                  )}
                />
              </div>

              {/* Programme */}
              <div className="md:col-span-2">
                <ListEditor
                  label="Programme (modules)"
                  items={program}
                  onChange={setProgram}
                  blank={{ title: '', detail: '' }}
                  render={(item, set) => (
                    <div className="grid grid-cols-1 sm:grid-cols-[1fr_2fr] gap-2 w-full">
                      <input className="form-input" placeholder="Jour 1 — Les bases"
                             value={item.title} onChange={(e) => set({ ...item, title: e.target.value })} />
                      <input className="form-input" placeholder="Contenu du module…"
                             value={item.detail} onChange={(e) => set({ ...item, detail: e.target.value })} />
                    </div>
                  )}
                />
              </div>

              <div>
                <label className="form-label">Mise en avant</label>
                <select className="form-input" {...register('featured')}>
                  <option value="0">Non</option>
                  <option value="1">Oui</option>
                </select>
              </div>
              <div>
                <label className="form-label">Statut</label>
                <select className="form-input" {...register('active')}>
                  <option value="1">Publiée</option>
                  <option value="0">Brouillon</option>
                </select>
              </div>
            </div>

            <div className="flex gap-3 mt-6">
              <button type="submit" className="btn-blue">
                💾 {editing ? 'Enregistrer' : 'Créer la formation'}
              </button>
              <button type="button" onClick={() => setShowForm(false)}
                className="px-5 py-2.5 border border-gray-200 text-gray-med text-sm rounded-lg
                           hover:bg-off-white transition-colors bg-transparent cursor-pointer">
                Annuler
              </button>
            </div>
          </form>
        </div>
      )}

      {sessionsFor && (
        <SessionsPanel
          formation={sessionsFor}
          onClose={() => { setSessionsFor(null); dispatch(fetchFormations()) }}
        />
      )}
    </div>
  )
}

/* ── Éditeur de liste générique (objectifs, modules) ─────────── */
function ListEditor({ label, items, onChange, blank, render }) {
  const setAt = (i, value) => onChange(items.map((it, j) => (j === i ? value : it)))
  const remove = (i) => onChange(items.filter((_, j) => j !== i))
  const add = () => onChange([...items, typeof blank === 'object' ? { ...blank } : blank])

  return (
    <div>
      <label className="form-label">{label}</label>
      <div className="space-y-2">
        {items.map((item, i) => (
          <div key={i} className="flex items-start gap-2">
            <span className="text-xs text-gray-med pt-3 w-5">{i + 1}.</span>
            {render(item, (v) => setAt(i, v))}
            <button type="button" onClick={() => remove(i)}
              className="text-red-500 hover:bg-red-50 px-2.5 py-2 rounded-lg text-sm
                         bg-transparent border-0 cursor-pointer">✕</button>
          </div>
        ))}
      </div>
      <button type="button" onClick={add}
        className="mt-2 text-xs text-blue-mid hover:underline bg-transparent border-0 cursor-pointer p-0">
        ＋ Ajouter
      </button>
    </div>
  )
}

/* ── Panneau des sessions d'une formation ────────────────────── */
function SessionsPanel({ formation, onClose }) {
  const [sessions, setSessions] = useState([])
  const [loading, setLoading]   = useState(true)
  const [form, setForm] = useState({ starts_on: '', ends_on: '', location: '', seats: 0 })

  const load = () => {
    setLoading(true)
    formationsAPI.getSessions({ formation_id: formation.id })
      .then((res) => setSessions(res.data.data))
      .catch(() => toast.error('Impossible de charger les sessions'))
      .finally(() => setLoading(false))
  }

  useEffect(load, [formation.id])

  const create = async (e) => {
    e.preventDefault()
    try {
      await formationsAPI.createSession({ ...form, formation_id: formation.id })
      toast.success('Session ajoutée')
      setForm({ starts_on: '', ends_on: '', location: '', seats: 0 })
      load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const toggleOpen = async (s) => {
    try {
      await formationsAPI.updateSession(s.id, { registration_open: !s.registration_open })
      load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const remove = async (s) => {
    if (!confirm(`Supprimer la session du ${fmtDate(s.starts_on)} ?`)) return
    try {
      await formationsAPI.deleteSession(s.id)
      toast.success('Session supprimée')
      load()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-dark/70"
         onClick={(e) => e.target === e.currentTarget && onClose()}>
      <div className="bg-white rounded-2xl w-full max-w-3xl max-h-[88vh] overflow-y-auto">
        <div className="flex items-center justify-between p-6 border-b border-gray-100 sticky top-0 bg-white">
          <div>
            <h2 className="font-display font-bold text-dark">Sessions</h2>
            <p className="text-xs text-gray-med mt-0.5">{formation.title}</p>
          </div>
          <button onClick={onClose}
            className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
        </div>

        <div className="p-6">
          {loading ? (
            <div className="flex justify-center py-8"><Spinner /></div>
          ) : sessions.length === 0 ? (
            <p className="text-sm text-gray-med text-center py-6">Aucune session programmée.</p>
          ) : (
            <div className="space-y-2 mb-8">
              {sessions.map((s) => (
                <div key={s.id} className="flex flex-wrap items-center justify-between gap-3
                                           border border-gray-100 rounded-xl px-4 py-3">
                  <div>
                    <p className="text-sm font-semibold text-dark">
                      {fmtDate(s.starts_on)}{s.ends_on ? ` → ${fmtDate(s.ends_on)}` : ''}
                    </p>
                    <p className="text-xs text-gray-med mt-0.5">
                      {s.location || 'Lieu non précisé'} ·{' '}
                      {s.seats > 0 ? `${s.seats_taken}/${s.seats} inscrits` : `${s.seats_taken} inscrits (places illimitées)`}
                    </p>
                  </div>
                  <div className="flex gap-2">
                    <button onClick={() => toggleOpen(s)}
                      className={`text-xs px-3 py-1.5 rounded-lg border-0 cursor-pointer transition-colors
                        ${s.registration_open
                          ? 'bg-green/10 text-green hover:bg-green/20'
                          : 'bg-gray-100 text-gray-med hover:bg-gray-200'}`}>
                      {s.registration_open ? 'Inscriptions ouvertes' : 'Fermée'}
                    </button>
                    <button onClick={() => remove(s)}
                      className="text-xs bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1.5
                                 rounded-lg border-0 cursor-pointer">Supprimer</button>
                  </div>
                </div>
              ))}
            </div>
          )}

          <form onSubmit={create} className="border-t border-gray-100 pt-6">
            <h3 className="font-display font-semibold text-dark text-sm mb-4">Ajouter une session</h3>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label className="form-label">Date de début *</label>
                <input type="date" required className="form-input" value={form.starts_on}
                       onChange={(e) => setForm({ ...form, starts_on: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Date de fin</label>
                <input type="date" className="form-input" value={form.ends_on}
                       onChange={(e) => setForm({ ...form, ends_on: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Lieu</label>
                <input className="form-input" placeholder="Ferme-école" value={form.location}
                       onChange={(e) => setForm({ ...form, location: e.target.value })} />
              </div>
              <div>
                <label className="form-label">Places <span className="text-gray-med font-normal">(0 = illimité)</span></label>
                <input type="number" min="0" className="form-input" value={form.seats}
                       onChange={(e) => setForm({ ...form, seats: Number(e.target.value) })} />
              </div>
            </div>
            <button type="submit" className="btn-blue mt-4">＋ Ajouter la session</button>
          </form>
        </div>
      </div>
    </div>
  )
}
