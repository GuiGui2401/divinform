import { useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { useForm } from 'react-hook-form'
import { useAuth } from '@/hooks/useAuth'

export default function Login() {
  const { login, isAdmin, loading, error, clearError } = useAuth()
  const navigate = useNavigate()
  const { register, handleSubmit, formState: { errors } } = useForm()

  useEffect(() => {
    if (isAdmin) navigate('/admin/dashboard', { replace: true })
  }, [isAdmin])

  const onSubmit = async (data) => {
    const res = await login(data)
    if (!res.error) navigate('/admin/dashboard', { replace: true })
  }

  return (
    <div className="min-h-screen flex items-center justify-center p-6"
         style={{ background: 'linear-gradient(135deg, #0A3D8F 0%, #0D1B2A 100%)' }}>
      <div className="bg-white rounded-3xl p-10 w-full max-w-md shadow-lg-blue">
        {/* Logo */}
        <div className="text-center mb-8">
          <div className="w-16 h-16 mx-auto rounded-full bg-gradient-to-br from-blue-dark to-blue-light
                          flex items-center justify-center text-3xl mb-4">⚙️</div>
          <h1 className="font-display font-extrabold text-dark text-2xl">Administration</h1>
          <p className="text-gray-med text-sm mt-1">Accès réservé aux administrateurs Medex65</p>
        </div>

        {/* Credentials hint */}
        <div className="bg-blue-dark/6 border border-blue-mid/20 rounded-xl p-3 mb-6 text-xs text-gray-med">
          <strong className="text-dark">Démo :</strong> admin@medex65.com / Admin@2025
        </div>

        {/* Error */}
        {error && (
          <div className="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-5">
            {error}
          </div>
        )}

        <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
          <div>
            <label className="form-label">Adresse email</label>
            <input
              type="email"
              className="form-input"
              placeholder="admin@medex65.com"
              {...register('email', { required: 'Email requis' })}
              onChange={() => error && clearError()}
            />
            {errors.email && <p className="text-red-500 text-xs mt-1">{errors.email.message}</p>}
          </div>

          <div>
            <label className="form-label">Mot de passe</label>
            <input
              type="password"
              className="form-input"
              placeholder="••••••••"
              {...register('password', { required: 'Mot de passe requis' })}
              onChange={() => error && clearError()}
            />
            {errors.password && <p className="text-red-500 text-xs mt-1">{errors.password.message}</p>}
          </div>

          <button
            type="submit"
            disabled={loading}
            className="w-full py-3.5 bg-blue-dark hover:bg-blue-mid text-white font-bold
                       rounded-xl transition-colors disabled:opacity-60 disabled:cursor-not-allowed
                       font-display text-base border-0 cursor-pointer mt-2"
          >
            {loading ? '⏳ Connexion…' : 'Se connecter'}
          </button>
        </form>

        <a href="/" className="block text-center text-gray-med text-sm mt-5 hover:text-blue-mid
                                transition-colors no-underline">
          ← Retour au site public
        </a>
      </div>
    </div>
  )
}
