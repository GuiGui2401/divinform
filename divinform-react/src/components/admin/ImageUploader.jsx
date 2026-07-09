import { useState } from 'react'
import { mediaAPI } from '@/api/media'
import toast from 'react-hot-toast'

/**
 * Gestion d'images : coller une URL OU téléverser des fichiers.
 *   multiple=false  → value = string (URL unique)
 *   multiple=true   → value = string[] (galerie)
 */
export default function ImageUploader({ value, onChange, multiple = false, folder = 'misc' }) {
  const items = multiple
    ? (Array.isArray(value) ? value : [])
    : (value ? [value] : [])
  const [uploading, setUploading] = useState(false)
  const [urlInput, setUrlInput]   = useState('')
  const [dragIndex, setDragIndex] = useState(null)

  const commit = (arr) => onChange(multiple ? arr : (arr[0] || ''))

  const addUrl = () => {
    const u = urlInput.trim()
    if (!u) return
    commit(multiple ? [...items, u] : [u])
    setUrlInput('')
  }

  const removeAt = (i) => {
    const a = [...items]
    a.splice(i, 1)
    commit(a)
  }

  const move = (from, to) => {
    if (to < 0 || to >= items.length || from === to) return
    const a = [...items]
    const [x] = a.splice(from, 1)
    a.splice(to, 0, x)
    commit(a)
  }
  const setMain = (i) => move(i, 0)   // l'image principale = la première

  const handleFiles = async (e) => {
    const files = Array.from(e.target.files || [])
    if (!files.length) return
    setUploading(true)
    try {
      const urls = []
      for (const f of files) {
        const res = await mediaAPI.upload(f, folder)
        urls.push(res.data.url)
        if (!multiple) break
      }
      commit(multiple ? [...items, ...urls] : [urls[0]])
      toast.success(urls.length > 1 ? 'Images téléversées' : 'Image téléversée')
    } catch (err) {
      toast.error(err.response?.data?.message || 'Échec du téléversement')
    } finally {
      setUploading(false)
      e.target.value = ''
    }
  }

  return (
    <div>
      {items.length > 0 && (
        <div className="flex flex-wrap gap-3 mb-3">
          {items.map((u, i) => (
            <div
              key={i}
              draggable={multiple}
              onDragStart={() => setDragIndex(i)}
              onDragOver={(e) => { if (multiple) e.preventDefault() }}
              onDrop={() => { if (multiple && dragIndex !== null) move(dragIndex, i); setDragIndex(null) }}
              onDragEnd={() => setDragIndex(null)}
              className={`relative group ${multiple ? 'cursor-grab active:cursor-grabbing' : ''}
                ${dragIndex === i ? 'opacity-50' : ''}`}
            >
              <img src={u} alt=""
                   className={`w-24 h-24 object-cover rounded-lg border bg-off-white
                     ${multiple && i === 0 ? 'border-green border-2' : 'border-gray-200'}`}
                   onError={(e) => { e.target.style.opacity = 0.3 }} />

              {/* Badge image principale */}
              {multiple && i === 0 && (
                <span className="absolute top-1 left-1 bg-green text-white text-[0.6rem] font-bold
                                 px-1.5 py-0.5 rounded shadow">★ Principale</span>
              )}

              {/* Retirer */}
              <button type="button" onClick={() => removeAt(i)} title="Retirer"
                      className="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white
                                 rounded-full text-xs flex items-center justify-center cursor-pointer shadow border-0">
                ✕
              </button>

              {/* Contrôles de réordonnancement (galerie) */}
              {multiple && items.length > 1 && (
                <div className="absolute bottom-1 left-1 right-1 flex items-center justify-center gap-1
                                opacity-0 group-hover:opacity-100 transition-opacity">
                  <button type="button" onClick={() => move(i, i - 1)} disabled={i === 0} title="Déplacer à gauche"
                          className="w-5 h-5 bg-dark/70 hover:bg-dark text-white rounded text-[0.65rem]
                                     flex items-center justify-center cursor-pointer border-0 disabled:opacity-30">←</button>
                  {i !== 0 && (
                    <button type="button" onClick={() => setMain(i)} title="Définir comme image principale"
                            className="w-5 h-5 bg-dark/70 hover:bg-green text-white rounded text-[0.65rem]
                                       flex items-center justify-center cursor-pointer border-0">★</button>
                  )}
                  <button type="button" onClick={() => move(i, i + 1)} disabled={i === items.length - 1} title="Déplacer à droite"
                          className="w-5 h-5 bg-dark/70 hover:bg-dark text-white rounded text-[0.65rem]
                                     flex items-center justify-center cursor-pointer border-0 disabled:opacity-30">→</button>
                </div>
              )}
            </div>
          ))}
        </div>
      )}
      <div className="flex items-center gap-2 flex-wrap">
        <input
          className="form-input flex-1 min-w-[180px]"
          placeholder="https://… (coller une URL)"
          value={urlInput}
          onChange={(e) => setUrlInput(e.target.value)}
          onKeyDown={(e) => { if (e.key === 'Enter') { e.preventDefault(); addUrl() } }}
        />
        <button type="button" onClick={addUrl}
                className="px-3 py-2 text-sm border border-gray-200 rounded-lg text-gray-med
                           hover:bg-off-white cursor-pointer whitespace-nowrap">
          + URL
        </button>
        <label className="btn-blue cursor-pointer whitespace-nowrap text-sm">
          {uploading ? '⏳ Envoi…' : '📤 Téléverser'}
          <input type="file" accept="image/png,image/jpeg,image/webp,image/svg+xml,image/gif"
                 multiple={multiple} className="hidden" onChange={handleFiles} disabled={uploading} />
        </label>
      </div>
      <p className="text-xs text-gray-med mt-1.5">
        Formats : JPG, PNG, WebP, SVG, GIF — 4 Mo max.
        {multiple && ' Glissez-déposez pour réordonner ; la 1ʳᵉ image (★ Principale) sert de vignette. Survolez une image pour la définir comme principale.'}
      </p>
    </div>
  )
}
