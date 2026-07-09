import { useEffect, useState } from 'react'
import { settingsAPI } from '@/api/settings'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

export default function Settings() {
  const [loading, setLoading] = useState(true)
  const [saving,  setSaving]  = useState(false)
  const [schema,  setSchema]  = useState([])
  const [values,  setValues]  = useState({})
  const [activeTab, setActiveTab] = useState(0)

  useEffect(() => {
    const el = document.getElementById('admin-page-title')
    if (el) el.textContent = 'Paramètres du site'

    settingsAPI.getAll()
      .then((res) => {
        setSchema(res.data.data.schema || [])
        setValues(res.data.data.values || {})
      })
      .catch(() => toast.error('Erreur lors du chargement des paramètres'))
      .finally(() => setLoading(false))
  }, [])

  const setField = (key, value) => setValues((v) => ({ ...v, [key]: value }))

  // ── Helpers pour les champs de type "liste" ───────────────
  const setListItem = (key, idx, subKey, value) =>
    setValues((v) => {
      const arr = Array.isArray(v[key]) ? [...v[key]] : []
      arr[idx] = { ...arr[idx], [subKey]: value }
      return { ...v, [key]: arr }
    })

  const addListItem = (key, fields) =>
    setValues((v) => {
      const arr = Array.isArray(v[key]) ? [...v[key]] : []
      const blank = {}
      fields.forEach((f) => { blank[f.key] = '' })
      return { ...v, [key]: [...arr, blank] }
    })

  const removeListItem = (key, idx) =>
    setValues((v) => {
      const arr = Array.isArray(v[key]) ? [...v[key]] : []
      arr.splice(idx, 1)
      return { ...v, [key]: arr }
    })

  const moveListItem = (key, idx, dir) =>
    setValues((v) => {
      const arr = Array.isArray(v[key]) ? [...v[key]] : []
      const j = idx + dir
      if (j < 0 || j >= arr.length) return v
      ;[arr[idx], arr[j]] = [arr[j], arr[idx]]
      return { ...v, [key]: arr }
    })

  const onSubmit = async (e) => {
    e.preventDefault()
    setSaving(true)
    try {
      const res = await settingsAPI.update(values)
      if (res.data?.data) setValues(res.data.data)
      toast.success('Paramètres sauvegardés avec succès')
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur lors de la sauvegarde')
    } finally {
      setSaving(false)
    }
  }

  if (loading) return <div className="flex justify-center py-20"><Spinner size="lg" /></div>

  const group = schema[activeTab]

  return (
    <form onSubmit={onSubmit} className="max-w-4xl">
      {/* Tabs des groupes */}
      <div className="flex flex-wrap gap-2 mb-6">
        {schema.map((g, i) => (
          <button
            key={g.key}
            type="button"
            onClick={() => setActiveTab(i)}
            className={`text-sm px-4 py-2 rounded-lg border transition-colors cursor-pointer
              ${i === activeTab
                ? 'bg-blue-dark text-white border-blue-dark'
                : 'bg-white text-gray-med border-gray-200 hover:bg-off-white'}`}
          >
            {g.label}
          </button>
        ))}
      </div>

      {/* Panneau du groupe actif */}
      {group && (
        <div className="admin-card">
          <div className="p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">{group.label}</h2>
            <p className="text-gray-med text-sm mt-1">
              Ces informations s'affichent sur la boutique publique. Laissez vide pour utiliser la valeur par défaut.
            </p>
          </div>

          <div className="p-6 space-y-5">
            {group.fields.map((f) => (
              <Field
                key={f.key}
                field={f}
                value={values[f.key]}
                onChange={(val) => setField(f.key, val)}
                listHelpers={{ setListItem, addListItem, removeListItem, moveListItem }}
              />
            ))}
          </div>
        </div>
      )}

      {/* Barre de sauvegarde */}
      <div className="sticky bottom-0 mt-6 bg-white/90 backdrop-blur border-t border-gray-100 py-4 flex items-center gap-4">
        <button type="submit" disabled={saving} className="btn-blue disabled:opacity-60">
          {saving ? '⏳ Sauvegarde…' : '💾 Sauvegarder les modifications'}
        </button>
        <span className="text-xs text-gray-med">Tous les onglets sont enregistrés en une fois.</span>
      </div>
    </form>
  )
}

/* ── Rendu d'un champ selon son type ─────────────────────── */
function Field({ field, value, onChange, listHelpers }) {
  const { key, label, type, help, fields, item_label } = field

  if (type === 'list') {
    const rows = Array.isArray(value) ? value : []
    const { setListItem, addListItem, removeListItem, moveListItem } = listHelpers
    return (
      <div>
        <label className="form-label">{label}</label>
        {help && <p className="text-xs text-gray-med mb-2 -mt-1">{help}</p>}
        <div className="space-y-3">
          {rows.map((row, idx) => (
            <div key={idx} className="border border-gray-200 rounded-xl p-4 bg-off-white/50">
              <div className="flex items-center justify-between mb-3">
                <span className="text-xs font-semibold text-gray-med uppercase tracking-wide">
                  {item_label} {idx + 1}
                </span>
                <div className="flex items-center gap-1">
                  <button type="button" onClick={() => moveListItem(key, idx, -1)}
                          className="text-gray-med hover:text-dark px-1.5 cursor-pointer" title="Monter">↑</button>
                  <button type="button" onClick={() => moveListItem(key, idx, 1)}
                          className="text-gray-med hover:text-dark px-1.5 cursor-pointer" title="Descendre">↓</button>
                  <button type="button" onClick={() => removeListItem(key, idx)}
                          className="text-red-500 hover:text-red-600 px-1.5 cursor-pointer" title="Supprimer">🗑️</button>
                </div>
              </div>
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                {fields.map((sf) => (
                  <div key={sf.key} className={sf.type === 'textarea' ? 'sm:col-span-2' : ''}>
                    <label className="text-xs text-gray-med block mb-1">{sf.label}</label>
                    {sf.type === 'textarea' ? (
                      <textarea
                        className="form-input min-h-[70px]"
                        value={row?.[sf.key] ?? ''}
                        onChange={(e) => setListItem(key, idx, sf.key, e.target.value)}
                      />
                    ) : (
                      <input
                        className="form-input"
                        value={row?.[sf.key] ?? ''}
                        onChange={(e) => setListItem(key, idx, sf.key, e.target.value)}
                      />
                    )}
                  </div>
                ))}
              </div>
            </div>
          ))}
        </div>
        <button type="button" onClick={() => addListItem(key, fields)}
                className="mt-3 text-sm text-blue-mid hover:text-blue-dark font-medium cursor-pointer">
          + Ajouter
        </button>
      </div>
    )
  }

  return (
    <div>
      <label className="form-label">{label}</label>
      {help && <p className="text-xs text-gray-med mb-2 -mt-1">{help}</p>}

      {type === 'textarea' ? (
        <textarea className="form-input min-h-[90px]" value={value ?? ''}
                  onChange={(e) => onChange(e.target.value)} />
      ) : type === 'color' ? (
        <div className="flex items-center gap-3">
          <input type="color" value={value || '#000000'} onChange={(e) => onChange(e.target.value)}
                 className="w-12 h-10 rounded border border-gray-200 cursor-pointer" />
          <input className="form-input flex-1" value={value ?? ''} onChange={(e) => onChange(e.target.value)} />
        </div>
      ) : type === 'image' ? (
        <ImageField value={value} onChange={onChange} />
      ) : (
        <input
          type={type === 'number' ? 'number' : type === 'email' ? 'email' : 'text'}
          className="form-input"
          value={value ?? ''}
          onChange={(e) => onChange(e.target.value)}
        />
      )}
    </div>
  )
}

/* ── Champ image : URL manuelle OU téléversement ─────────── */
function ImageField({ value, onChange }) {
  const [uploading, setUploading] = useState(false)

  const handleFile = async (e) => {
    const file = e.target.files?.[0]
    if (!file) return
    setUploading(true)
    try {
      const res = await settingsAPI.uploadImage(file)
      onChange(res.data.url)
      toast.success('Image téléversée')
    } catch (err) {
      toast.error(err.response?.data?.message || 'Échec du téléversement')
    } finally {
      setUploading(false)
      e.target.value = ''
    }
  }

  return (
    <div>
      <div className="flex items-center gap-3 flex-wrap">
        <input className="form-input flex-1 min-w-[200px]" placeholder="https://… ou téléversez une image"
               value={value ?? ''} onChange={(e) => onChange(e.target.value)} />
        <label className="btn-blue cursor-pointer whitespace-nowrap text-sm disabled:opacity-60">
          {uploading ? '⏳ Envoi…' : '📤 Téléverser'}
          <input type="file" accept="image/png,image/jpeg,image/webp,image/svg+xml,image/gif"
                 className="hidden" onChange={handleFile} disabled={uploading} />
        </label>
        {value && (
          <button type="button" onClick={() => onChange('')}
                  className="text-xs text-red-500 hover:text-red-600 cursor-pointer">Retirer</button>
        )}
      </div>
      {value && (
        <img src={value} alt="" className="mt-2 h-16 rounded-lg border border-gray-200 object-contain bg-off-white"
             onError={(e) => { e.target.style.display = 'none' }} />
      )}
    </div>
  )
}
