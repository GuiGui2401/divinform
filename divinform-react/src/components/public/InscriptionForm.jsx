import { useEffect, useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { submitInscription, resetInscription, selectInscription } from '@/store/slices/formationsSlice'
import { waFormationLink } from '@/utils/contact'
import { formatSessionDate } from './FormationCard'

const EMPTY = { name: '', phone: '', email: '', message: '', formation_session_id: '' }

export default function InscriptionForm({ formation }) {
  const dispatch = useDispatch()
  const { sending, success, error, fieldErrors } = useSelector(selectInscription)
  const [form, setForm] = useState(EMPTY)
  const [honeypot, setHoneypot] = useState('')

  const sessions = formation.upcoming_sessions || []

  // Repartir d'un formulaire vierge quand on change de formation.
  useEffect(() => {
    dispatch(resetInscription())
    setForm(EMPTY)
  }, [dispatch, formation.id])

  const set = (key) => (e) => setForm((f) => ({ ...f, [key]: e.target.value }))

  const onSubmit = (e) => {
    e.preventDefault()
    dispatch(submitInscription({
      formation_id: formation.id,
      formation_session_id: form.formation_session_id || null,
      name: form.name,
      phone: form.phone,
      email: form.email || null,
      message: form.message || null,
      ...(honeypot ? { website: honeypot } : {}),
    }))
  }

  const chosenSession = sessions.find((s) => String(s.id) === String(form.formation_session_id))
  const waHref = waFormationLink(
    formation.title,
    chosenSession ? formatSessionDate(chosenSession.starts_on) : '',
  )

  if (success) {
    return (
      <div className="bg-green-50 border border-green-200 rounded-2xl p-6 text-center">
        <div className="text-4xl mb-3">✅</div>
        <h3 className="font-display font-bold text-green-900 mb-2">Demande envoyée</h3>
        <p className="text-sm text-green-800 mb-5">{success}</p>
        <div className="flex flex-col sm:flex-row gap-3 justify-center">
          <a href={waHref} target="_blank" rel="noopener noreferrer"
             className="bg-[#25D366] hover:bg-[#20B858] text-white text-sm font-semibold
                        px-5 py-2.5 rounded-lg no-underline transition-colors">
            💬 Confirmer sur WhatsApp
          </a>
          <button onClick={() => dispatch(resetInscription())}
                  className="text-sm text-green-800 underline bg-transparent border-0 cursor-pointer">
            Envoyer une autre demande
          </button>
        </div>
      </div>
    )
  }

  return (
    <form onSubmit={onSubmit} className="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
      <h3 className="font-display font-bold text-dark text-lg mb-1">S'inscrire à cette formation</h3>
      <p className="text-xs text-gray-med mb-5">
        Laissez-nous vos coordonnées : le centre vous rappelle pour finaliser l'inscription.
      </p>

      {error && (
        <div className="bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-lg p-3 mb-4">
          {error}
        </div>
      )}

      <div className="space-y-3">
        {sessions.length > 0 && (
          <Field label="Session souhaitée" error={fieldErrors.formation_session_id}>
            <select value={form.formation_session_id} onChange={set('formation_session_id')} className={inputCls}>
              <option value="">— Indifférent / à définir —</option>
              {sessions.map((s) => (
                <option key={s.id} value={s.id} disabled={s.is_full}>
                  {formatSessionDate(s.starts_on)}
                  {s.location ? ` — ${s.location}` : ''}
                  {s.is_full ? ' (complet)' : s.seats_left != null ? ` (${s.seats_left} places)` : ''}
                </option>
              ))}
            </select>
          </Field>
        )}

        <Field label="Nom complet *" error={fieldErrors.name}>
          <input type="text" required value={form.name} onChange={set('name')}
                 placeholder="Jean Ondo" className={inputCls} />
        </Field>

        <Field label="Téléphone *" error={fieldErrors.phone}>
          <input type="tel" required value={form.phone} onChange={set('phone')}
                 placeholder="060337821" className={inputCls} />
        </Field>

        <Field label="Email (facultatif)" error={fieldErrors.email}>
          <input type="email" value={form.email} onChange={set('email')}
                 placeholder="vous@exemple.ga" className={inputCls} />
        </Field>

        <Field label="Message (facultatif)" error={fieldErrors.message}>
          <textarea rows={3} value={form.message} onChange={set('message')}
                    placeholder="Votre projet, vos disponibilités…" className={inputCls} />
        </Field>

        {/* Pot de miel : invisible pour l'humain, rempli par les robots. */}
        <input
          type="text" name="website" tabIndex={-1} autoComplete="off"
          value={honeypot} onChange={(e) => setHoneypot(e.target.value)}
          aria-hidden="true"
          style={{ position: 'absolute', left: '-9999px', width: 1, height: 1, opacity: 0 }}
        />
      </div>

      <button type="submit" disabled={sending}
              className="w-full mt-5 bg-blue-dark hover:bg-blue-mid disabled:opacity-60
                         text-white font-semibold py-3 rounded-xl transition-colors
                         border-0 cursor-pointer">
        {sending ? 'Envoi…' : "Envoyer ma demande d'inscription"}
      </button>

      <div className="flex items-center gap-3 my-4">
        <span className="flex-1 h-px bg-gray-100" />
        <span className="text-xs text-gray-med">ou</span>
        <span className="flex-1 h-px bg-gray-100" />
      </div>

      <a href={waHref} target="_blank" rel="noopener noreferrer"
         className="block text-center bg-[#25D366] hover:bg-[#20B858] text-white
                    font-semibold py-3 rounded-xl no-underline transition-colors">
        💬 S'inscrire sur WhatsApp
      </a>
    </form>
  )
}

const inputCls =
  'w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm text-dark ' +
  'focus:outline-none focus:border-blue-mid focus:ring-1 focus:ring-blue-mid transition-colors'

function Field({ label, error, children }) {
  return (
    <label className="block">
      <span className="block text-xs font-semibold text-dark mb-1.5">{label}</span>
      {children}
      {error && <span className="block text-xs text-rose-600 mt-1">{Array.isArray(error) ? error[0] : error}</span>}
    </label>
  )
}
