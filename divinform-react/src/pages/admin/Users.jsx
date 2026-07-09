import { useEffect, useState } from 'react'
import { useForm } from 'react-hook-form'
import { settingsAPI } from '@/api/settings'
import Spinner from '@/components/ui/Spinner'
import toast from 'react-hot-toast'

const ROLE_LABELS = {
  super_admin: { label: 'Super Admin', cls: 'bg-blue-dark/10 text-blue-dark' },
  editor:      { label: 'Éditeur',     cls: 'bg-green/10 text-green' },
  viewer:      { label: 'Lecteur',     cls: 'bg-gray-100 text-gray-med' },
}

export default function Users() {
  const [users,    setUsers]    = useState([])
  const [loading,  setLoading]  = useState(true)
  const [saving,   setSaving]   = useState(false)
  const [showForm, setShowForm] = useState(false)

  const { register, handleSubmit, reset, formState: { errors } } = useForm()

  useEffect(() => {
    const el = document.getElementById('admin-page-title')
    if (el) el.textContent = 'Utilisateurs'
    loadUsers()
  }, [])

  const loadUsers = async () => {
    setLoading(true)
    try {
      const res = await settingsAPI.getUsers()
      setUsers(res.data.data)
    } catch {
      toast.error('Erreur lors du chargement des utilisateurs')
    } finally {
      setLoading(false)
    }
  }

  const onSubmit = async (data) => {
    setSaving(true)
    try {
      await settingsAPI.createUser(data)
      toast.success(`Utilisateur "${data.name}" créé avec succès`)
      setShowForm(false)
      reset({})
      loadUsers()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur lors de la création')
    } finally {
      setSaving(false)
    }
  }

  const handleToggleActive = async (user) => {
    try {
      await settingsAPI.updateUser(user.id, { active: !user.active })
      toast.success('Statut mis à jour')
      loadUsers()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Erreur')
    }
  }

  const handleDelete = async (user) => {
    if (!confirm(`Supprimer l'utilisateur "${user.name}" ?`)) return
    try {
      await settingsAPI.deleteUser(user.id)
      toast.success('Utilisateur supprimé')
      loadUsers()
    } catch (err) {
      toast.error(err.response?.data?.message || 'Impossible de supprimer cet utilisateur')
    }
  }

  if (loading) return <div className="flex justify-center py-20"><Spinner size="lg" /></div>

  return (
    <div className="max-w-4xl">
      <div className="admin-card">
        <div className="flex items-center justify-between p-6 border-b border-gray-100">
          <h2 className="font-display font-bold text-dark">
            Gestion des utilisateurs
            <span className="ml-2 text-sm text-gray-med font-normal">({users.length})</span>
          </h2>
          <button onClick={() => { setShowForm(true); reset({}) }} className="btn-blue">
            ＋ Nouvel utilisateur
          </button>
        </div>
        <table className="w-full">
          <thead className="bg-off-white">
            <tr>
              {['Utilisateur', 'Email', 'Rôle', 'Statut', 'Actions'].map((h) => (
                <th key={h} className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{h}</th>
              ))}
            </tr>
          </thead>
          <tbody>
            {users.map((u) => {
              const role = ROLE_LABELS[u.role] || ROLE_LABELS.viewer
              return (
                <tr key={u.id} className="border-t border-gray-100 hover:bg-off-white/50">
                  <td className="px-5 py-4">
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 rounded-full bg-blue-dark flex items-center
                                      justify-center text-white font-bold text-sm flex-shrink-0">
                        {u.name.slice(0, 2).toUpperCase()}
                      </div>
                      <span className="font-semibold text-dark text-sm">{u.name}</span>
                    </div>
                  </td>
                  <td className="px-5 py-4 text-sm text-gray-med">{u.email}</td>
                  <td className="px-5 py-4">
                    <span className={`text-xs font-bold px-2.5 py-1 rounded-full ${role.cls}`}>
                      {role.label}
                    </span>
                  </td>
                  <td className="px-5 py-4">
                    <button
                      onClick={() => handleToggleActive(u)}
                      className={`text-xs font-bold px-2.5 py-1 rounded-full border-0 cursor-pointer
                        ${u.active ? 'bg-green/10 text-green' : 'bg-gray-100 text-gray-med'}`}
                    >
                      {u.active ? 'Actif' : 'Inactif'}
                    </button>
                  </td>
                  <td className="px-5 py-4">
                    <div className="flex gap-2">
                      {u.id !== 1 && (
                        <button
                          onClick={() => handleDelete(u)}
                          className="text-xs bg-red-50 text-red-500 hover:bg-red-100
                                     px-3 py-1.5 rounded-lg border-0 cursor-pointer transition-colors"
                        >
                          Supprimer
                        </button>
                      )}
                    </div>
                  </td>
                </tr>
              )
            })}
          </tbody>
        </table>
      </div>

      {/* Matrice des permissions */}
      <div className="admin-card mt-5">
        <div className="p-6 border-b border-gray-100">
          <h2 className="font-display font-bold text-dark">Matrice des permissions</h2>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-off-white">
              <tr>
                <th className="text-left px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">Action</th>
                {['Super Admin', 'Éditeur', 'Lecteur'].map((r) => (
                  <th key={r} className="text-center px-5 py-3 text-xs font-bold text-gray-med uppercase tracking-wider">{r}</th>
                ))}
              </tr>
            </thead>
            <tbody>
              {[
                ['Voir les produits',         true,  true,  true],
                ['Créer / modifier produits', true,  true,  false],
                ['Supprimer produits',        true,  false, false],
                ['Gérer les catégories',      true,  false, false],
                ['Modifier les paramètres',   true,  false, false],
                ['Gérer les utilisateurs',    true,  false, false],
              ].map(([action, sa, ed, vi]) => (
                <tr key={action} className="border-t border-gray-100">
                  <td className="px-5 py-3 text-sm text-dark">{action}</td>
                  {[sa, ed, vi].map((v, i) => (
                    <td key={i} className="px-5 py-3 text-center text-base">
                      {v ? <span className="text-green font-bold">✓</span>
                         : <span className="text-gray-300">—</span>}
                    </td>
                  ))}
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Formulaire */}
      {showForm && (
        <div className="admin-card mt-5">
          <div className="flex items-center justify-between p-6 border-b border-gray-100">
            <h2 className="font-display font-bold text-dark">Nouvel utilisateur</h2>
            <button onClick={() => setShowForm(false)}
              className="text-gray-med hover:text-dark bg-transparent border-0 cursor-pointer text-xl">✕</button>
          </div>
          <form onSubmit={handleSubmit(onSubmit)} className="p-6">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label className="form-label">Nom complet *</label>
                <input className="form-input" placeholder="Ex: Jean Dupont"
                  {...register('name', { required: 'Nom requis' })} />
                {errors.name && <p className="text-red-500 text-xs mt-1">{errors.name.message}</p>}
              </div>
              <div>
                <label className="form-label">Email *</label>
                <input className="form-input" type="email" placeholder="email@divinform.com"
                  {...register('email', { required: 'Email requis' })} />
                {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email.message}</p>}
              </div>
              <div>
                <label className="form-label">Rôle</label>
                <select className="form-input" {...register('role')}>
                  <option value="editor">Éditeur</option>
                  <option value="viewer">Lecteur</option>
                  <option value="super_admin">Super Admin</option>
                </select>
              </div>
              <div>
                <label className="form-label">Mot de passe temporaire *</label>
                <input className="form-input" type="password" placeholder="8 car. min, maj + chiffre"
                  {...register('password', {
                    required: 'Mot de passe requis',
                    minLength: { value: 8, message: '8 caractères minimum' },
                  })} />
                {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password.message}</p>}
              </div>
            </div>
            <div className="flex gap-3 mt-5">
              <button type="submit" disabled={saving} className="btn-blue disabled:opacity-60">
                {saving ? '⏳ Création…' : '💾 Créer l\'utilisateur'}
              </button>
              <button type="button" onClick={() => setShowForm(false)}
                className="px-5 py-2.5 border border-gray-200 text-gray-med text-sm
                           rounded-lg hover:bg-off-white transition-colors bg-transparent cursor-pointer">
                Annuler
              </button>
            </div>
          </form>
        </div>
      )}
    </div>
  )
}
