import { useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { setFilter, selectProducts, selectLoading } from '@/store/slices/productsSlice'
import { selectCategories } from '@/store/slices/categoriesSlice'
import {
  setFormationFilter,
  selectFormations,
  selectFormationFilters,
  selectFormationsLoading,
} from '@/store/slices/formationsSlice'
import CategoryCard   from '@/components/public/CategoryCard'
import ProductCard    from '@/components/public/ProductCard'
import FormationCard  from '@/components/public/FormationCard'
import SearchBar      from '@/components/public/SearchBar'
import Spinner        from '@/components/ui/Spinner'
import { waLink, callLink, mailLink } from '@/utils/contact'
import { useSettings } from '@/hooks/useSettings'

const DEFAULT_STATS = [
  { num: '6',      label: 'Formations au catalogue' },
  { num: '100%',   label: 'Pratique sur la ferme' },
  { num: '15 ans', label: "D'expérience en élevage" },
  { num: '7j/7',   label: 'Accompagnement' },
]

const DEFAULT_WHY = [
  { icon: '🎓', title: 'Une ferme-école',        desc: "Vous n'apprenez pas dans une salle : vous apprenez sur une ferme en activité, au contact des animaux." },
  { icon: '👨‍🌾', title: 'Des formateurs éleveurs', desc: 'Nos formateurs vivent de leur élevage. Ils enseignent ce qu\'ils pratiquent chaque jour.' },
  { icon: '🔧', title: 'De la pratique avant tout', desc: 'La majorité du temps est consacrée aux travaux pratiques, pas à la théorie.' },
  { icon: '📋', title: 'Un projet, pas un cours',  desc: 'Chaque stagiaire repart avec un plan d\'installation chiffré et adapté à ses moyens.' },
  { icon: '🤝', title: 'Un suivi après la formation', desc: 'Nous restons joignables pour vous accompagner dans vos premiers mois d\'activité.' },
  { icon: '🏅', title: 'Une attestation reconnue',  desc: 'Une attestation de fin de formation vous est remise à l\'issue de chaque session.' },
]

const DEFAULT_HERO_CARD = [
  { label: '🎓 Formations certifiantes' },
  { label: '🐄 Travaux pratiques' },
  { label: '📋 Accompagnement projet' },
  { label: '🤝 Suivi post-formation' },
]

const LEVELS = [
  { value: '',              label: 'Tous les niveaux' },
  { value: 'debutant',      label: 'Débutant' },
  { value: 'intermediaire', label: 'Intermédiaire' },
  { value: 'avance',        label: 'Avancé' },
]

export default function Home() {
  const dispatch   = useDispatch()
  const categories = useSelector(selectCategories)
  const products   = useSelector(selectProducts)
  const loading    = useSelector(selectLoading)
  const formations = useSelector(selectFormations)
  const formationFilters = useSelector(selectFormationFilters)
  const formationsLoading = useSelector(selectFormationsLoading)
  const [activeCat, setActiveCat] = useState(null)
  const { get, list } = useSettings()

  const stats     = list('stats', DEFAULT_STATS)
  const why       = list('why_items', DEFAULT_WHY)
  const heroCard  = list('hero_card_items', DEFAULT_HERO_CARD)
  const heroImg   = get('hero_image_url', 'https://divinform.com/img/vie3.jpg')
  const email     = get('email', 'divinformelevage@gmail.com')

  const contactCards = [
    { icon: '📞', main: get('phone1', '060337821'), sub: get('phone2', '076328536'), bg: 'rgba(46,90,31,0.06)' },
    { icon: '💬', main: 'WhatsApp disponible', sub: 'Réponse sous 1h en journée', bg: 'rgba(39,174,96,0.06)' },
    { icon: '📧', main: email, sub: get('website', 'www.divinform.com'), bg: 'rgba(74,124,47,0.06)' },
    { icon: '📍', main: get('address', 'C.F Divin Élevage'), sub: get('address_detail', 'Gabon'), bg: 'rgba(231,76,60,0.06)' },
  ]

  const handleCategoryClick = (cat) => {
    const next = activeCat === cat.id ? null : cat.id
    setActiveCat(next)
    dispatch(setFilter({ category: next ? String(next) : '' }))
    document.getElementById('produits')?.scrollIntoView({ behavior: 'smooth' })
  }

  const scrollTo = (id) => document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' })

  return (
    <>
      {/* ── HERO ─────────────────────────────────────── */}
      <section
        id="hero"
        className="min-h-screen flex items-center pt-16 relative overflow-hidden"
        style={{
          background: `linear-gradient(135deg, rgba(46,90,31,0.95) 0%, rgba(43,36,22,0.92) 60%, rgba(46,90,31,0.85) 100%), url(${heroImg}) center/cover no-repeat`,
        }}
      >
        <div className="absolute inset-0 pointer-events-none"
             style={{ background: 'radial-gradient(ellipse 80% 60% at 60% 40%, rgba(74,124,47,0.25) 0%, transparent 60%)' }} />

        <div className="max-w-6xl mx-auto px-6 py-20 relative z-10 grid md:grid-cols-[1fr_auto] gap-12 items-center">
          <div className="max-w-2xl animate-fade-in">
            <div className="inline-flex items-center gap-2 bg-green/15 border border-green/30
                            text-green-light px-4 py-1.5 rounded-full text-xs font-bold
                            tracking-widest uppercase mb-6">
              <span className="w-1.5 h-1.5 bg-green-light rounded-full animate-pulse-dot" />
              {get('hero_eyebrow', 'Centre de formation en élevage')}
            </div>

            <h1 className="font-display text-4xl md:text-6xl font-extrabold text-white leading-[1.1] mb-5">
              {get('hero_title', 'Apprenez le métier')}{' '}
              <em className="not-italic text-green-light">{get('hero_highlight', "d'éleveur")}</em><br />
              {get('hero_title_suffix', 'sur une vraie ferme-école')}
            </h1>
            <p className="text-white/70 text-base md:text-lg leading-relaxed mb-9 max-w-xl">
              {get('hero_subtitle', "Nos formations pratiques en élevage et en agriculture vous donnent les compétences et la confiance nécessaires pour lancer votre propre exploitation, quel que soit votre niveau de départ.")}
            </p>

            <div className="flex flex-wrap gap-4 mb-14">
              <button onClick={() => scrollTo('formations')} className="btn-primary text-base px-8 py-3.5">
                {get('hero_cta_primary', '🎓 Découvrir nos formations')}
              </button>
              <button onClick={() => scrollTo('contact')} className="btn-outline text-base px-8 py-3.5">
                {get('hero_cta_secondary', '📞 Nous contacter')}
              </button>
            </div>

            <div className="flex flex-wrap gap-10 pt-8 border-t border-white/12">
              {stats.map((s, i) => (
                <div key={i}>
                  <div className="font-display text-3xl font-extrabold text-white">{s.num}</div>
                  <div className="text-white/50 text-xs tracking-wide mt-0.5">{s.label}</div>
                </div>
              ))}
            </div>
          </div>

          {/* Encart ferme-école */}
          <div className="hidden lg:block bg-white/5 border border-white/10 backdrop-blur-sm
                          rounded-2xl p-7 text-white min-w-[220px]">
            <div className="w-20 h-20 rounded-full border-[3px] border-green-light
                            flex items-center justify-center mb-5 mx-auto text-3xl">
              🎓
            </div>
            <div className="font-display font-bold text-center text-sm mb-5">
              {get('hero_card_title', 'LA FERME-ÉCOLE')}
            </div>
            <div className="space-y-2.5 text-sm text-white/75">
              {heroCard.map((item, i) => (
                <div key={i}>{item.label}</div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* ── FORMATIONS — cœur du site ────────────────── */}
      <section id="formations" className="py-20 bg-off-white">
        <div className="max-w-6xl mx-auto px-6">
          <div className="text-center mb-10">
            <span className="section-eyebrow">{get('formations_eyebrow', 'Notre catalogue')}</span>
            <h2 className="section-title">{get('formations_title', 'Nos formations')}</h2>
            <p className="text-gray-med max-w-xl mx-auto">
              {get('formations_subtitle', "Des formations courtes, concrètes et menées sur le terrain, pour apprendre un métier et vivre de son élevage.")}
            </p>
          </div>

          {/* Filtre par niveau */}
          <div className="flex flex-wrap justify-center gap-2 mb-10">
            {LEVELS.map((l) => (
              <button
                key={l.value}
                onClick={() => dispatch(setFormationFilter({ level: l.value }))}
                className={`text-xs font-semibold px-4 py-2 rounded-full border transition-colors
                            cursor-pointer ${
                  formationFilters.level === l.value
                    ? 'bg-blue-dark text-white border-blue-dark'
                    : 'bg-white text-gray-med border-gray-200 hover:border-blue-mid'
                }`}
              >
                {l.label}
              </button>
            ))}
          </div>

          {formationsLoading ? (
            <div className="flex justify-center py-20"><Spinner size="lg" /></div>
          ) : formations.length === 0 ? (
            <div className="text-center py-16 text-gray-med">
              <div className="text-5xl mb-4">🎓</div>
              <h3 className="font-display font-semibold text-lg mb-2">Aucune formation à afficher</h3>
              <p className="text-sm">Le catalogue est en cours de mise à jour. Contactez-nous pour en savoir plus.</p>
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              {formations.map((f, i) => (
                <FormationCard key={f.id} formation={f} index={i} />
              ))}
            </div>
          )}
        </div>
      </section>

      {/* ── POURQUOI NOUS ───────────────────────────── */}
      <section id="pourquoi" className="py-20"
               style={{ background: 'linear-gradient(135deg, #2E5A1F 0%, #3E3520 100%)' }}>
        <div className="max-w-6xl mx-auto px-6">
          <div className="text-center mb-14">
            <span className="text-green-light text-xs font-bold tracking-widest uppercase block mb-3">
              {get('why_eyebrow', 'Notre pédagogie')}
            </span>
            <h2 className="font-display text-3xl md:text-4xl font-bold text-white leading-tight mb-4">
              {get('why_title', 'Pourquoi se former chez nous ?')}
            </h2>
            <p className="text-white/60 max-w-xl mx-auto">
              {get('why_subtitle', "Une formation qui se vit sur le terrain, transmise par des éleveurs en activité.")}
            </p>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            {why.map((w, i) => (
              <div key={i} className="text-center px-4 py-6">
                <div className="w-16 h-16 mx-auto mb-5 bg-white/8 border border-white/10
                                rounded-2xl flex items-center justify-center text-3xl">
                  {w.icon}
                </div>
                <h3 className="font-display font-semibold text-white text-base mb-2">{w.title}</h3>
                <p className="text-white/60 text-sm leading-relaxed">{w.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── LA FERME — volet secondaire ──────────────── */}
      <section id="produits" className="py-20">
        <div className="max-w-6xl mx-auto px-6">
          <div className="text-center mb-10">
            <span className="section-eyebrow">{get('categories_eyebrow', 'Notre ferme')}</span>
            <h2 className="section-title">{get('categories_title', 'Les produits de la ferme')}</h2>
            <p className="text-gray-med max-w-2xl mx-auto">
              {get('categories_subtitle', "Notre ferme-école est une exploitation en activité. Les produits issus de nos ateliers pédagogiques sont proposés en vente directe.")}
            </p>
          </div>

          <SearchBar />

          {/* Catégories */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 my-10">
            {categories.map((cat) => (
              <CategoryCard
                key={cat.id}
                category={cat}
                active={activeCat === cat.id}
                onClick={() => handleCategoryClick(cat)}
              />
            ))}
          </div>

          <div className="flex items-center justify-between mb-8 flex-wrap gap-4">
            <div>
              <h3 className="font-display font-bold text-dark text-xl">
                {activeCat
                  ? categories.find((c) => c.id === activeCat)?.name
                  : 'Tous nos produits'}
              </h3>
              <p className="text-gray-med text-sm mt-1">
                {products.length} produit{products.length > 1 ? 's' : ''}
              </p>
            </div>
            {activeCat && (
              <button
                onClick={() => { setActiveCat(null); dispatch(setFilter({ category: '' })) }}
                className="text-sm text-gray-med hover:text-blue-mid transition-colors
                           bg-transparent border-0 cursor-pointer"
              >
                ← Voir tout
              </button>
            )}
          </div>

          {loading ? (
            <div className="flex justify-center py-20"><Spinner size="lg" /></div>
          ) : products.length === 0 ? (
            <div className="text-center py-20 text-gray-med">
              <div className="text-5xl mb-4">🔍</div>
              <h3 className="font-display font-semibold text-lg mb-2">Aucun résultat</h3>
              <p className="text-sm">Essayez un autre mot-clé ou effacez les filtres.</p>
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
              {products.map((p, i) => (
                <ProductCard key={p.id} product={p} index={i} />
              ))}
            </div>
          )}
        </div>
      </section>

      {/* ── CONTACT ─────────────────────────────────── */}
      <section id="contact" className="py-20 bg-off-white">
        <div className="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
          <div>
            <span className="section-eyebrow">{get('contact_eyebrow', 'Contactez-nous')}</span>
            <h2 className="section-title">{get('contact_title', 'Une question sur nos formations ?')}</h2>
            <p className="text-gray-med mb-8 leading-relaxed">
              {get('contact_subtitle', "Notre équipe vous renseigne sur les programmes, les dates de session et les modalités d'inscription.")}
            </p>
            <div className="space-y-3">
              {contactCards.map((c, i) => (
                <div key={i} className="flex items-center gap-4 bg-white rounded-xl p-4 shadow-card">
                  <div className="w-11 h-11 rounded-lg flex items-center justify-center text-xl flex-shrink-0"
                       style={{ background: c.bg }}>
                    {c.icon}
                  </div>
                  <div>
                    <div className="text-sm font-semibold text-dark">{c.main}</div>
                    <div className="text-xs text-gray-med mt-0.5">{c.sub}</div>
                  </div>
                </div>
              ))}
            </div>
          </div>

          <div className="rounded-3xl p-10 text-white text-center"
               style={{ background: 'linear-gradient(135deg, #2E5A1F, #4A7C2F)' }}>
            <div className="w-20 h-20 rounded-full border-[3px] border-white/40 flex items-center
                            justify-center mx-auto mb-5 text-3xl">
              🎓
            </div>
            <h3 className="font-display font-bold text-xl mb-3">
              {get('cta_box_title', 'Prêt à vous former ?')}
            </h3>
            <p className="text-white/70 text-sm mb-7">
              {get('cta_box_subtitle', "Contactez-nous pour connaître les prochaines sessions et réserver votre place.")}
            </p>
            <div className="flex flex-col gap-3">
              <a href={waLink()} target="_blank" rel="noopener noreferrer"
                 className="py-3.5 rounded-xl bg-[#25D366] hover:bg-[#20B858] text-white
                            font-semibold transition-all hover:-translate-y-0.5 no-underline
                            flex items-center justify-center gap-2">
                💬 Contacter sur WhatsApp
              </a>
              <a href={callLink()} className="py-3.5 rounded-xl bg-white/12 hover:bg-white/18
                                              text-white font-semibold transition-colors
                                              border border-white/20 no-underline
                                              flex items-center justify-center gap-2">
                📞 Appeler maintenant
              </a>
              <a href={mailLink(email)}
                 className="py-3.5 rounded-xl bg-white/12 hover:bg-white/18 text-white
                            font-semibold transition-colors border border-white/20 no-underline
                            flex items-center justify-center gap-2">
                📧 Envoyer un email
              </a>
            </div>
          </div>
        </div>
      </section>
    </>
  )
}
