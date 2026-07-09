import { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { useForm } from 'react-hook-form'
import { fetchProducts, createProduct, updateProduct, deleteProduct, selectProducts, selectLoading } from '@/store/slices/productsSlice'
import { fetchCategories, selectCategories } from '@/store/slices/categoriesSlice'
import Spinner from '@/components/ui/Spinner'
import ImageUploader from '@/components/admin/ImageUploader'
import toast from 'react-hot-toast'

export default function Products() {
  const dispatch   = useDispatch()
  const products   = useSelector(selectProducts)
  const categories = useSelector(selectCategories)
  const loading    = useSelector(selectLoading)
  const [showForm, setShowForm] = useState(false)
  const [editing, setEditing]   = useState(null)
  const [search, setSearch]     = useState('')
  const [images, setImages]     = useState([])

  const { register, handleSubmit, reset, formState: { errors } } = useForm()

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = 'Produits'
    dispatch(fetchProducts())
    dispatch(fetchCategories())
  }, [dispatch])

  const openCreate = () => { setEditing(null); reset({}); setImages([]); setShowForm(true) }
  const openEdit   = (p)  => {
    setEditing(p)
    reset({
      name: p.name, short_desc: p.short_desc, description: p.description,
      category_id: p.category_id, badge: p.badge || '', featured: p.featured ? '1' : '0',
    })
    setImages(p.images || [])
    setShowForm(true)
  }

  const onSubmit = async (data) => {
    const fd = new FormData()
    Object.entries(data).forEach(([k, v]) => { if (v !== undefined && v !== '') fd.append(k, v) })
    fd.append('manage_images', '1')
    images.forEach((u) => fd.append('image_urls[]', u))

    if (editing) {
      const res = await dispatch(updateProduct({ id: editing.id, formData: fd }))
      if (!res.error) { toast.success('Produit modifié'); setShowForm(false) }
      else toast.error('Erreur lors de la modification')
    } else {
      const res = await dispatch(createProduct(fd))
      if (!res.error) { toast.success('Produit créé'); setShowForm(false); reset({}) }
      else toast.error('Erreur lors de la création')
    }
  }

  const handleDelete = async (id, name) => {
    if (!confirm(`Supprimer "${name}" ?`)) return
    const res = await dispatch(deleteProduct(id))
    if (!res.error) toast.success('Produit supprimé')
    else toast.error('Erreur lors de la suppression')
  }

  const filtered = products.filter((p) =>
    p.name?.toLowerCase().includes(search.toLowerCase())
  )

  return (
    <div>
      {/* Header */}
      <div className="admin-card">
        <div className="flex flex-wrap items-center justify-between gap-4 p-6 border-b border-gray-100">
          <div className="flex items-center gap-3 flex-1">
            <input
              type="text"
              placeholder="Rechercher un produit…"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="form-input max-w-xs"
            />
            <span className="text-gray-med text-sm">{filtered.length} produit{filtered.length > 1 ? 's' : ''}</span>
          </div>
          <button onClick={openCreate} className="btn-blue">
            ＋ Nouveau produit
          </button>
        </div>

        {/* Table */}
        <div className="overflow-x-auto">
          {loading ? (
            <div className="flex justify-center py-12"><Spinner /></div>
          ) : (
            <table className="w-full">
              <thead className="bg-off-white">
                <tr>
                  {['Image', 'Nom', 'Catégorie', 'Statut', 'Actions'].map((h) => (
                    <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody>
                {filtered.map((p) => {
                  const cat = categories.find((c) => c.id === p.category_id)
                  return (
                    <tr key={p.id} className="border-t border-gray-100 hover:bg-off-white/50">
                      <td className="px-5 py-3">
                        <img
                          src={p.images?.[0]}
                          alt={p.name}
                          className="w-12 h-10 object-cover rounded-lg"
                          onError={(e) => { e.target.style.display='none' }}
                        />
                      </td>
                      <td className="px-5 py-3">
                        <div className="font-semibold text-dark text-sm">{p.name}</div>
                        <div className="text-xs text-gray-med mt-0.5">{p.short_desc?.slice(0, 50)}…</div>
                      </td>
                      <td className="px-5 py-3 text-sm text-gray-med">
                        {cat ? `${cat.icon} ${cat.name}` : '—'}
                      </td>
                      <td className="px-5 py-3">
                        <span className={`text-xs font-bold px-2.5 py-1 rounded-full
                          ${p.active !== false ? 'bg-green/10 text-green' : 'bg-gray-100 text-gray-med'}`}>
                          {p.active !== false ? 'Actif' : 'Brouillon'}
                        </span>
                      </td>
                      <td className="px-5 py-3">
                        <div className="flex gap-2">
                          <button onClick={() => openEdit(p)}
                            className="text-xs bg-blue-mid/10 text-blue-mid hover:bg-blue-mid/20
                                       px-3 py-1.5 rounded-lg transition-colors border-0 cursor-pointer">
                            Modifier
                          </button>
                          <button onClick={() => handleDelete(p.id, p.name)}
                            className="text-xs bg-red-50 text-red-500 hover:bg-red-100
                                       px-3 py-1.5 rounded-lg transition-colors border-0 cursor-pointer">
                            Supprimer
                          </button>
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

      {/* Form */}
      {showForm && (
        <div className="admin-card">
          <div className="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">
              {editing ? 'Modifier le produit' : 'Nouveau produit'}
            </h2>
            <button onClick={() => setShowForm(false)}
              className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
          </div>
          <form onSubmit={handleSubmit(onSubmit)} className="p-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label className="form-label">Nom du produit *</label>
                <input className="form-input" placeholder="Ex: Lait Cru Fermier"
                  {...register('name', { required: 'Nom requis' })} />
                {errors.name && <p className="text-red-500 text-xs mt-1">{errors.name.message}</p>}
              </div>
              <div>
                <label className="form-label">Catégorie *</label>
                <select className="form-input" {...register('category_id', { required: true })}>
                  <option value="">Sélectionner…</option>
                  {categories.map((c) => (
                    <option key={c.id} value={c.id}>{c.icon} {c.name}</option>
                  ))}
                </select>
              </div>
              <div className="md:col-span-2">
                <label className="form-label">Description courte *</label>
                <input className="form-input" placeholder="Résumé en une ligne…"
                  {...register('short_desc', { required: 'Description courte requise' })} />
              </div>
              <div className="md:col-span-2">
                <label className="form-label">Description complète</label>
                <textarea className="form-input min-h-[100px] resize-y" placeholder="Description détaillée…"
                  {...register('description')} />
              </div>
              <div className="md:col-span-2">
                <label className="form-label">Images du produit</label>
                <ImageUploader value={images} onChange={setImages} multiple folder="products" />
              </div>
              <div>
                <label className="form-label">Badge (optionnel)</label>
                <input className="form-input" placeholder="Ex: NOUVEAU, TOP VENTE"
                  {...register('badge')} />
              </div>
              <div>
                <label className="form-label">Produit mis en avant</label>
                <select className="form-input" {...register('featured')}>
                  <option value="0">Non</option>
                  <option value="1">Oui</option>
                </select>
              </div>
            </div>
            <div className="flex gap-3 mt-6">
              <button type="submit" className="btn-blue">
                💾 {editing ? 'Modifier' : 'Créer le produit'}
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
    </div>
  )
}
