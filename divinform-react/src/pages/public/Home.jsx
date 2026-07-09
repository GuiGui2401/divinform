import { useDispatch, useSelector } from 'react-redux'
import { setFilter } from '@/store/slices/productsSlice'
import { selectCategories } from '@/store/slices/categoriesSlice'
import { selectProducts, selectLoading } from '@/store/slices/productsSlice'
import CategoryCard from '@/components/public/CategoryCard'
import ProductCard  from '@/components/public/ProductCard'
import SearchBar    from '@/components/public/SearchBar'
import Spinner      from '@/components/ui/Spinner'
import { waLink, callLink, mailLink } from '@/utils/contact'
import { useSettings } from '@/hooks/useSettings'
import { useState } from 'react'

const DEFAULT_STATS = [
  { num: '120+', label: 'Produits fermiers' },
  { num: '85+',  label: 'Clients fidèles' },
  { num: '10 ans', label: 'D\'expérience' },
  { num: '7/7', label: 'Ferme ouverte' },
]

const DEFAULT_WHY = [
  { icon: '🌿', title: 'Produits 100% naturels',       desc: 'Des produits fermiers sans additifs, cultivés et élevés dans le respect de la nature.' },
  { icon: '🐄', title: 'Bien-être animal',             desc: 'Nos animaux sont élevés en plein air, nourris sainement et traités avec soin.' },
  { icon: '🤝', title: 'Vente directe',                desc: 'Du producteur au consommateur, sans intermédiaire, pour un prix juste et des produits frais.' },
  { icon: '🥛', title: 'Fraîcheur garantie',           desc: 'Des produits récoltés et préparés chaque jour pour une fraîcheur incomparable.' },
  { icon: '🚚', title: 'Livraison locale',             desc: 'Livraison de vos paniers et colis fermiers dans toute la région.' },
  { icon: '💚', title: 'Savoir-faire authentique',    desc: 'Un savoir-faire fermier transmis avec passion, adapté à vos envies gourmandes.' },
]

export default function Home() {
  const dispatch    = useDispatch()
  const categories  = useSelector(selectCategories)
  const products    = useSelector(selectProducts)
  const loading     = useSelector(selectLoading)
  const [activeCat, setActiveCat] = useState(null)
  const { get, list } = useSettings()

  const stats    = list('stats', DEFAULT_STATS)
  const why      = list('why_items', DEFAULT_WHY)
  const months   = get('guarantee_months', '12')
  const heroImg  = get('hero_image_url', 'https://divinform.com/img/vie3.jpg')
  const email    = get('email', 'contact@divinform.com')

  const contactCards = [
    { icon: '📞', main: get('phone1', '+237 696 809 909'), sub: get('phone2', '+237 696 534 179'), bg: 'rgba(46,90,31,0.06)' },
    { icon: '💬', main: 'WhatsApp disponible', sub: 'Réponse sous 1h en journée', bg: 'rgba(39,174,96,0.06)' },
    { icon: '📧', main: email, sub: get('website', 'www.divinform.com'), bg: 'rgba(74,124,47,0.06)' },
    { icon: '📍', main: get('address', 'Cameroun — Bafoussam'), sub: get('address_detail', 'Quartier Haoussa'), bg: 'rgba(231,76,60,0.06)' },
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
        {/* Radial glow */}
        <div className="absolute inset-0 pointer-events-none"
             style={{ background: 'radial-gradient(ellipse 80% 60% at 60% 40%, rgba(74,124,47,0.25) 0%, transparent 60%)' }} />

        <div className="max-w-6xl mx-auto px-6 py-20 relative z-10 grid md:grid-cols-[1fr_auto] gap-12 items-center">
          <div className="max-w-2xl animate-fade-in">
            {/* Eyebrow */}
            <div className="inline-flex items-center gap-2 bg-green/15 border border-green/30
                            text-green-light px-4 py-1.5 rounded-full text-xs font-bold
                            tracking-widest uppercase mb-6">
              <span className="w-1.5 h-1.5 bg-green-light rounded-full animate-pulse-dot" />
              {get('hero_eyebrow', 'Produits fermiers en vente directe')}
            </div>

            <h1 className="font-display text-4xl md:text-6xl font-extrabold text-white leading-[1.1] mb-5">
              {get('hero_title', 'Produits')}{' '}
              <em className="not-italic text-green-light">{get('hero_highlight', 'Fermiers')}</em><br />
              {get('hero_title_suffix', 'du Producteur à votre Table')}
            </h1>
            <p className="text-white/70 text-base md:text-lg leading-relaxed mb-9 max-w-xl">
              {get('hero_subtitle', "La Ferme Divinform vous propose des produits fermiers frais et savoureux, issus d'un élevage et d'une culture respectueux de la nature, en vente directe pour régaler toute la famille.")}
            </p>

            <div className="flex flex-wrap gap-4 mb-14">
              <button onClick={() => scrollTo('produits')} className="btn-primary text-base px-8 py-3.5">
                {get('hero_cta_primary', '🧺 Voir nos produits')}
              </button>
              <button onClick={() => scrollTo('contact')} className="btn-outline text-base px-8 py-3.5">
                {get('hero_cta_secondary', '📞 Nous contacter')}
              </button>
            </div>

            {/* Stats */}
            <div className="flex flex-wrap gap-10 pt-8 border-t border-white/12">
              {stats.map((s, i) => (
                <div key={i}>
                  <div className="font-display text-3xl font-extrabold text-white">{s.num}</div>
                  <div className="text-white/50 text-xs tracking-wide mt-0.5">{s.label}</div>
                </div>
              ))}
            </div>
          </div>

          {/* Guarantee card */}
          <div className="hidden lg:block bg-white/5 border border-white/10 backdrop-blur-sm
                          rounded-2xl p-7 text-white min-w-[200px]">
            <div className="w-18 h-18 rounded-full border-[3px] border-green-light
                            flex flex-col items-center justify-center mb-5 mx-auto
                            w-20 h-20">
              <span className="font-display font-black text-2xl text-green-light leading-none">{months}</span>
              <span className="text-green-light text-[0.55rem] font-bold tracking-wider">MOIS</span>
            </div>
            <div className="font-display font-bold text-center text-sm mb-5">FRAÎCHEUR FERMIÈRE</div>
            <div className="space-y-2.5 text-sm text-white/75">
              {['✅ Produits fermiers', '🌿 100% naturel', '🐄 Bien-être animal', '🚚 Livraison locale'].map(s => (
                <div key={s}>{s}</div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* ── SEARCH BAR ──────────────────────────────── */}
      <SearchBar />

      {/* ── CATEGORIES ──────────────────────────────── */}
      <section id="categories" className="section bg-off-white py-20">
        <div className="max-w-6xl mx-auto px-6">
          <div className="text-center mb-14">
            <span className="section-eyebrow">{get('categories_eyebrow', 'Nos domaines')}</span>
            <h2 className="section-title">{get('categories_title', "Nos gammes de produits")}</h2>
            <p className="text-gray-med max-w-xl mx-auto">
              {get('categories_subtitle', "Des produits laitiers aux viandes fermières en passant par les œufs plein air, découvrez tout ce que la ferme a à offrir.")}
            </p>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {categories.map((cat) => (
              <CategoryCard
                key={cat.id}
                category={cat}
                active={activeCat === cat.id}
                onClick={() => handleCategoryClick(cat)}
              />
            ))}
          </div>
        </div>
      </section>

      {/* ── PRODUCTS ──────────────────────────────────── */}
      <section id="produits" className="py-20">
        <div className="max-w-6xl mx-auto px-6">
          <div className="flex items-center justify-between mb-8 flex-wrap gap-4">
            <div>
              <h2 className="font-display font-bold text-dark text-2xl">
                {activeCat
                  ? categories.find((c) => c.id === activeCat)?.name
                  : 'Tous nos produits'}
              </h2>
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

      {/* ── WHY US ──────────────────────────────────── */}
      <section id="pourquoi" className="py-20"
               style={{ background: 'linear-gradient(135deg, #2E5A1F 0%, #3E3520 100%)' }}>
        <div className="max-w-6xl mx-auto px-6">
          <div className="text-center mb-14">
            <span className="text-green-light text-xs font-bold tracking-widest uppercase block mb-3">
              {get('why_eyebrow', 'Nos engagements')}
            </span>
            <h2 className="font-display text-3xl md:text-4xl font-bold text-white leading-tight mb-4">
              {get('why_title', 'Pourquoi choisir la Ferme Divinform ?')}
            </h2>
            <p className="text-white/60 max-w-xl mx-auto">
              {get('why_subtitle', 'Des produits fermiers de qualité supérieure avec un savoir-faire authentique à chaque étape.')}
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

      {/* ── CONTACT ─────────────────────────────────── */}
      <section id="contact" className="py-20 bg-off-white">
        <div className="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
          {/* Info */}
          <div>
            <span className="section-eyebrow">{get('contact_eyebrow', 'Contactez-nous')}</span>
            <h2 className="section-title">{get('contact_title', 'Parlons de vos envies gourmandes')}</h2>
            <p className="text-gray-med mb-8 leading-relaxed">
              {get('contact_subtitle', "Notre équipe est disponible pour répondre à toutes vos questions et préparer vos paniers de produits fermiers.")}
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

          {/* CTA box */}
          <div className="rounded-3xl p-10 text-white text-center"
               style={{ background: 'linear-gradient(135deg, #2E5A1F, #4A7C2F)' }}>
            <div className="w-20 h-20 rounded-full border-[3px] border-white/40 flex flex-col
                            items-center justify-center mx-auto mb-5">
              <span className="font-display font-black text-2xl text-white/80 leading-none">{months}</span>
              <span className="text-white/80 text-[0.55rem] font-bold tracking-wider">MOIS</span>
            </div>
            <h3 className="font-display font-bold text-xl mb-3">
              {get('cta_box_title', 'Envie de goûter à la ferme ?')}
            </h3>
            <p className="text-white/70 text-sm mb-7">
              {get('cta_box_subtitle', 'Contactez-nous dès maintenant pour commander vos produits fermiers.')}
            </p>
            <div className="flex flex-col gap-3">
              <a href={waLink()} target="_blank" rel="noopener"
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
