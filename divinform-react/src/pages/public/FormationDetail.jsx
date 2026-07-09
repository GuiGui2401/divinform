import { useEffect } from 'react'
import { Link, useParams } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux'
import {
  fetchFormation,
  selectCurrentFormation,
  selectFormationsLoading,
  selectFormationsError,
} from '@/store/slices/formationsSlice'
import { formationsAPI } from '@/api/formations'
import InscriptionForm from '@/components/public/InscriptionForm'
import { formatPrice, formatSessionDate } from '@/components/public/FormationCard'
import Spinner from '@/components/ui/Spinner'

const LEVEL_LABELS = {
  debutant:      'Débutant — aucun prérequis',
  intermediaire: 'Intermédiaire',
  avance:        'Avancé',
}

export default function FormationDetail() {
  const { slug }  = useParams()
  const dispatch  = useDispatch()
  const formation = useSelector(selectCurrentFormation)
  const loading   = useSelector(selectFormationsLoading)
  const error     = useSelector(selectFormationsError)

  useEffect(() => {
    dispatch(fetchFormation(slug))
  }, [dispatch, slug])

  // Compteur de vues : on n'échoue jamais la page pour un compteur.
  useEffect(() => {
    if (formation?.id) formationsAPI.trackView(formation.id).catch(() => {})
  }, [formation?.id])

  if (loading) return <div className="py-32 flex justify-center"><Spinner /></div>

  if (error || !formation) {
    return (
      <div className="max-w-3xl mx-auto px-6 py-24 text-center">
        <div className="text-5xl mb-4">🔍</div>
        <h1 className="font-display font-bold text-2xl text-dark mb-2">Formation introuvable</h1>
        <p className="text-gray-med mb-6">{error || "Cette formation n'existe pas ou n'est plus proposée."}</p>
        <Link to="/" className="text-blue-dark font-semibold no-underline hover:underline">
          ← Retour à l'accueil
        </Link>
      </div>
    )
  }

  const img = formation.images?.[0]

  return (
    <div className="bg-off-white">
      {/* Fil d'Ariane */}
      <div className="max-w-6xl mx-auto px-6 pt-6 text-xs text-gray-med">
        <Link to="/" className="hover:text-blue-dark no-underline text-gray-med">Accueil</Link>
        <span className="mx-2">›</span>
        <Link to="/#formations" className="hover:text-blue-dark no-underline text-gray-med">Nos formations</Link>
        <span className="mx-2">›</span>
        <span className="text-dark">{formation.title}</span>
      </div>

      <div className="max-w-6xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-3 gap-10">
        {/* Colonne principale */}
        <div className="lg:col-span-2">
          {img && (
            <img src={img} alt={formation.title}
                 className="w-full h-72 object-cover rounded-2xl mb-8" />
          )}

          <h1 className="font-display font-bold text-3xl text-dark mb-3">{formation.title}</h1>
          <p className="text-gray-med leading-relaxed mb-8">{formation.summary}</p>

          {/* Repères clés */}
          <div className="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-10">
            <KeyFact icon="⏱"  label="Durée"         value={formation.duration || 'À définir'} />
            <KeyFact icon="📊" label="Niveau"        value={LEVEL_LABELS[formation.level] || '—'} />
            <KeyFact icon="💰" label="Tarif"         value={formatPrice(formation)} />
            <KeyFact icon="🎓" label="Certification" value={formation.certification || 'Attestation'} />
          </div>

          {formation.description && (
            <Section title="Présentation">
              <p className="text-gray-med leading-relaxed whitespace-pre-line">{formation.description}</p>
            </Section>
          )}

          {formation.objectives?.length > 0 && (
            <Section title="Objectifs pédagogiques">
              <ul className="space-y-2.5">
                {formation.objectives.map((o, i) => (
                  <li key={i} className="flex gap-3 text-gray-med text-sm">
                    <span className="text-green-light font-bold">✓</span>
                    <span>{o}</span>
                  </li>
                ))}
              </ul>
            </Section>
          )}

          {formation.program?.length > 0 && (
            <Section title="Programme">
              <ol className="space-y-4">
                {formation.program.map((m, i) => (
                  <li key={i} className="border-l-2 border-green-light pl-4">
                    <h4 className="font-display font-semibold text-dark text-sm">{m.title}</h4>
                    {m.detail && <p className="text-gray-med text-sm mt-1">{m.detail}</p>}
                  </li>
                ))}
              </ol>
            </Section>
          )}

          {formation.prerequisites && (
            <Section title="Prérequis">
              <p className="text-gray-med text-sm leading-relaxed">{formation.prerequisites}</p>
            </Section>
          )}

          {formation.upcoming_sessions?.length > 0 && (
            <Section title="Prochaines sessions">
              <div className="space-y-3">
                {formation.upcoming_sessions.map((s) => (
                  <div key={s.id}
                       className="flex flex-wrap items-center justify-between gap-3 bg-white
                                  border border-gray-100 rounded-xl px-4 py-3">
                    <div>
                      <p className="font-semibold text-dark text-sm">
                        {formatSessionDate(s.starts_on)}
                        {s.ends_on && s.ends_on !== s.starts_on && ` → ${formatSessionDate(s.ends_on)}`}
                      </p>
                      {s.location && <p className="text-xs text-gray-med mt-0.5">📍 {s.location}</p>}
                    </div>
                    {s.is_full ? (
                      <span className="text-xs font-semibold text-rose-700 bg-rose-50 px-3 py-1 rounded-full">
                        Complet
                      </span>
                    ) : s.seats_left != null ? (
                      <span className="text-xs font-semibold text-green-800 bg-green-50 px-3 py-1 rounded-full">
                        {s.seats_left} place{s.seats_left > 1 ? 's' : ''} restante{s.seats_left > 1 ? 's' : ''}
                      </span>
                    ) : (
                      <span className="text-xs font-semibold text-blue-dark bg-blue-50 px-3 py-1 rounded-full">
                        Inscriptions ouvertes
                      </span>
                    )}
                  </div>
                ))}
              </div>
            </Section>
          )}
        </div>

        {/* Colonne d'inscription */}
        <aside className="lg:col-span-1">
          <div className="lg:sticky lg:top-24">
            <InscriptionForm formation={formation} />
          </div>
        </aside>
      </div>
    </div>
  )
}

function KeyFact({ icon, label, value }) {
  return (
    <div className="bg-white border border-gray-100 rounded-xl p-3.5">
      <div className="text-lg mb-1">{icon}</div>
      <div className="text-[0.68rem] uppercase tracking-wide text-gray-med">{label}</div>
      <div className="text-sm font-semibold text-dark mt-0.5">{value}</div>
    </div>
  )
}

function Section({ title, children }) {
  return (
    <section className="mb-10">
      <h2 className="font-display font-bold text-xl text-dark mb-4">{title}</h2>
      {children}
    </section>
  )
}
