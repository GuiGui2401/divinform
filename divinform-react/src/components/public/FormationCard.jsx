import { Link } from 'react-router-dom'
import Badge from '../ui/Badge'

const LEVEL_LABELS = {
  debutant:      'Débutant',
  intermediaire: 'Intermédiaire',
  avance:        'Avancé',
}

const LEVEL_COLORS = {
  debutant:      'bg-green-50 text-green-800 border-green-200',
  intermediaire: 'bg-amber-50 text-amber-800 border-amber-200',
  avance:        'bg-rose-50 text-rose-800 border-rose-200',
}

export const formatPrice = (formation) =>
  formation.price
    ? `${new Intl.NumberFormat('fr-FR').format(formation.price)} ${formation.currency || 'FCFA'}`
    : 'Nous consulter'

export const formatSessionDate = (iso) =>
  iso
    ? new Date(iso).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })
    : null

export default function FormationCard({ formation, index = 0 }) {
  const img       = formation.images?.[0]
  const nextDate  = formatSessionDate(formation.upcoming_sessions?.[0]?.starts_on)
  const seatsLeft = formation.upcoming_sessions?.[0]?.seats_left

  return (
    <article
      className="card overflow-hidden group animate-fade-in flex flex-col"
      style={{ animationDelay: `${index * 0.06}s` }}
    >
      {/* Visuel */}
      <div className="relative h-44 bg-gradient-to-br from-green-light/20 to-blue-light/20 overflow-hidden">
        {img ? (
          <img
            src={img}
            alt={formation.title}
            loading="lazy"
            className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
          />
        ) : (
          <div className="w-full h-full flex items-center justify-center text-5xl">🎓</div>
        )}
        <Badge text={formation.badge} color={formation.badge_color} />
        {formation.duration && (
          <span className="absolute bottom-2 right-2 bg-blue-dark/85 text-white text-xs
                           px-2.5 py-1 rounded-full backdrop-blur-sm">
            ⏱ {formation.duration}
          </span>
        )}
      </div>

      {/* Corps */}
      <div className="p-5 flex flex-col flex-1">
        <div className="flex items-center gap-2 mb-2">
          <span className={`text-[0.68rem] font-semibold px-2 py-0.5 rounded-full border
                            ${LEVEL_COLORS[formation.level] || LEVEL_COLORS.debutant}`}>
            {LEVEL_LABELS[formation.level] || LEVEL_LABELS.debutant}
          </span>
        </div>

        <h3 className="font-display font-semibold text-dark text-base leading-snug mb-2">
          {formation.title}
        </h3>
        <p className="text-gray-med text-xs leading-relaxed mb-4 line-clamp-3">
          {formation.summary}
        </p>

        {/* Prochaine session */}
        <div className="mt-auto space-y-2">
          {nextDate ? (
            <p className="text-xs text-gray-med">
              📅 Prochaine session : <strong className="text-dark">{nextDate}</strong>
              {seatsLeft != null && seatsLeft <= 5 && (
                <span className="text-rose-600 font-semibold">
                  {' '}— plus que {seatsLeft} place{seatsLeft > 1 ? 's' : ''}
                </span>
              )}
            </p>
          ) : (
            <p className="text-xs text-gray-med">📅 Prochaine session à programmer</p>
          )}

          <div className="flex items-center justify-between pt-2 border-t border-gray-100">
            <span className="font-display font-bold text-blue-dark text-sm">
              {formatPrice(formation)}
            </span>
            <Link
              to={`/formation/${formation.slug}`}
              className="bg-blue-dark hover:bg-blue-mid text-white text-xs font-semibold
                         px-4 py-2.5 rounded-lg transition-colors no-underline"
            >
              Voir la formation →
            </Link>
          </div>
        </div>
      </div>
    </article>
  )
}
