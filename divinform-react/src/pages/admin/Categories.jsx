import { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { useForm } from 'react-hook-form'
import { fetchCategories, createCategory, updateCategory, deleteCategory, selectCategories } from '@/store/slices/categoriesSlice'
import { selectProducts } from '@/store/slices/productsSlice'
import ImageUploader from '@/components/admin/ImageUploader'
import toast from 'react-hot-toast'

export default function Categories() {
  const dispatch   = useDispatch()
  const categories = useSelector(selectCategories)
  const products   = useSelector(selectProducts)
  const [showForm, setShowForm] = useState(false)
  const [editing, setEditing]   = useState(null)
  const [iconImage, setIconImage] = useState('')
  const { register, handleSubmit, reset } = useForm()

  useEffect(() => {
    document.getElementById('admin-page-title').textContent = 'Catégories'
    dispatch(fetchCategories())
  }, [dispatch])

  const openCreate = () => { setEditing(null); reset({}); setIconImage(''); setShowForm(true) }
  const openEdit   = (c)  => { setEditing(c); reset({ name: c.name, icon: c.icon, description: c.description }); setIconImage(c.image || ''); setShowForm(true) }

  const onSubmit = async (data) => {
    const payload = { ...data, image: iconImage }
    if (editing) {
      const res = await dispatch(updateCategory({ id: editing.id, data: payload }))
      if (!res.error) { toast.success('Catégorie modifiée'); setShowForm(false) }
      else toast.error('Erreur')
    } else {
      const res = await dispatch(createCategory(payload))
      if (!res.error) { toast.success('Catégorie créée'); setShowForm(false); reset({}); setIconImage('') }
      else toast.error('Erreur')
    }
  }

  const handleDelete = async (id, name) => {
    const nb = products.filter((p) => p.category_id === id).length
    if (nb > 0 && !confirm(`Cette catégorie contient ${nb} produit(s). Supprimer quand même ?`)) return
    if (!confirm(`Supprimer "${name}" ?`)) return
    const res = await dispatch(deleteCategory(id))
    if (!res.error) toast.success('Catégorie supprimée')
  }

  return (
    <div>
      <div className="admin-card">
        <div className="flex items-center justify-between p-6 border-b border-gray-100">
          <h2 className="font-display font-bold text-dark">Gestion des catégories</h2>
          <button onClick={openCreate} className="btn-blue">＋ Nouvelle catégorie</button>
        </div>
        <table className="w-full">
          <thead className="bg-off-white">
            <tr>
              {['Icône', 'Nom', 'Description', 'Produits', 'Actions'].map((h) => (
                <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
              ))}
            </tr>
          </thead>
          <tbody>
            {categories.map((c) => {
              const count = products.filter((p) => p.category_id === c.id).length
              return (
                <tr key={c.id} className="border-t border-gray-100 hover:bg-off-white/50">
                  <td className="px-5 py-4 text-3xl">
                    {c.image
                      ? <img src={c.image} alt={c.name} className="w-10 h-10 object-contain rounded" />
                      : c.icon}
                  </td>
                  <td className="px-5 py-4 font-semibold text-dark text-sm">{c.name}</td>
                  <td className="px-5 py-4 text-gray-med text-sm max-w-xs">{c.description}</td>
                  <td className="px-5 py-4 text-sm font-semibold text-blue-mid">{count}</td>
                  <td className="px-5 py-4">
                    <div className="flex gap-2">
                      <button onClick={() => openEdit(c)}
                        className="text-xs bg-blue-mid/10 text-blue-mid hover:bg-blue-mid/20
                                   px-3 py-1.5 rounded-lg border-0 cursor-pointer transition-colors">
                        Modifier
                      </button>
                      <button onClick={() => handleDelete(c.id, c.name)}
                        className="text-xs bg-red-50 text-red-500 hover:bg-red-100
                                   px-3 py-1.5 rounded-lg border-0 cursor-pointer transition-colors">
                        Supprimer
                      </button>
                    </div>
                  </td>
                </tr>
              )
            })}
          </tbody>
        </table>
      </div>

      {showForm && (
        <div className="admin-card">
          <div className="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">
              {editing ? 'Modifier la catégorie' : 'Nouvelle catégorie'}
            </h2>
            <button onClick={() => setShowForm(false)}
              className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
          </div>
          <form onSubmit={handleSubmit(onSubmit)} className="p-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label className="form-label">Nom de la catégorie *</label>
                <input className="form-input" placeholder="Ex: Produits Laitiers"
                  {...register('name', { required: true })} />
              </div>
              <div>
                <label className="form-label">Icône (emoji)</label>
                <input className="form-input" placeholder="🥛"
                  {...register('icon')} />
              </div>
              <div className="md:col-span-2">
                <label className="form-label">Icône en image (optionnel)</label>
                <ImageUploader value={iconImage} onChange={setIconImage} folder="categories" />
                <p className="text-xs text-gray-med mt-1">Si une image est fournie, elle remplace l'emoji sur la boutique.</p>
              </div>
              <div className="md:col-span-2">
                <label className="form-label">Description</label>
                <textarea className="form-input resize-y" rows={3}
                  placeholder="Description de la catégorie…"
                  {...register('description')} />
              </div>
            </div>
            <div className="flex gap-3 mt-5">
              <button type="submit" className="btn-blue">
                💾 {editing ? 'Modifier' : 'Créer'}
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
