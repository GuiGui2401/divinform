import { Link } from 'react-router-dom'
import { useSettings } from '@/hooks/useSettings'
import { waLink, callLink, mailLink } from '@/utils/contact'

const scrollTo = (hash) => {
  const el = document.getElementById(hash)
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}

const NAV = [
  { label: 'Accueil',           hash: 'hero' },
  { label: 'Imagerie médicale', hash: 'produits' },
  { label: 'Laboratoire',       hash: 'produits' },
  { label: 'Nos engagements',   hash: 'pourquoi' },
  { label: 'Contact',           hash: 'contact' },
]

const DEFAULT_SERVICES = [
  { label: 'Maintenance technique' },
  { label: 'Formation du personnel' },
  { label: 'Installation sur site' },
  { label: 'Consommables & accessoires' },
]

export default function Footer() {
  const { get, list } = useSettings()
  const logoImg  = get('logo_image_url')
  const siteName = get('site_name', 'Medex65')
  const email    = get('email', 'info@medex237.com')
  const services = list('footer_services', DEFAULT_SERVICES)

  const socials = [
    { url: waLink(),                       label: '💬', hover: 'hover:bg-[#25D366]' },
    { url: callLink(),                     label: '📞', hover: 'hover:bg-blue-mid' },
    { url: mailLink(email),                label: '📧', hover: 'hover:bg-blue-mid' },
    { url: get('facebook_url'),            label: '📘', hover: 'hover:bg-[#1877F2]' },
    { url: get('instagram_url'),           label: '📸', hover: 'hover:bg-[#E4405F]' },
    { url: get('linkedin_url'),            label: '💼', hover: 'hover:bg-[#0A66C2]' },
    { url: get('youtube_url'),             label: '▶️', hover: 'hover:bg-[#FF0000]' },
  ].filter((s) => s.url)

  const copyright = get('copyright', '© {year} Medex65 SARL. Tous droits réservés.')
    .replace('{year}', new Date().getFullYear())

  return (
    <footer className="bg-dark text-white/60 pt-12 pb-6">
      <div className="max-w-6xl mx-auto px-6">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-12 mb-10">
          {/* Brand */}
          <div>
            <div className="flex items-center gap-2.5 mb-4">
              <div className="w-9 h-9 rounded-full bg-gradient-to-br from-green-light to-blue-light
                              flex items-center justify-center text-base overflow-hidden">
                {logoImg
                  ? <img src={logoImg} alt={siteName} className="w-full h-full object-cover" />
                  : get('logo_emoji', '🫀')}
              </div>
              <span className="font-display font-bold text-white text-lg">{siteName}</span>
            </div>
            <p className="text-sm leading-relaxed max-w-xs">
              {get('footer_about', 'Votre partenaire en technologies médicales de pointe. Équipements certifiés, maintenance rapide, formation incluse.')}
            </p>
            <div className="flex gap-3 mt-5 flex-wrap">
              {socials.map((s, i) => (
                <a key={i} href={s.url} target="_blank" rel="noopener"
                   className={`w-9 h-9 bg-white/8 ${s.hover} rounded-lg flex items-center
                              justify-center text-sm transition-colors`}>{s.label}</a>
              ))}
            </div>
          </div>

          {/* Navigation */}
          <div>
            <h4 className="text-white font-display font-semibold text-sm mb-4">Navigation</h4>
            <ul className="space-y-2.5 text-sm">
              {NAV.map((l) => (
                <li key={l.label}>
                  <button
                    onClick={() => scrollTo(l.hash)}
                    className="text-white/55 hover:text-green-light transition-colors
                               bg-transparent border-0 cursor-pointer text-sm p-0"
                  >
                    {l.label}
                  </button>
                </li>
              ))}
            </ul>
          </div>

          {/* Services */}
          <div>
            <h4 className="text-white font-display font-semibold text-sm mb-4">Services</h4>
            <ul className="space-y-2.5 text-sm">
              {services.map((s, i) => (
                <li key={i}>
                  <span className="text-white/55">{s.label}</span>
                </li>
              ))}
              <li>
                <Link to="/admin/login" className="text-white/55 hover:text-green-light transition-colors no-underline">
                  ⚙️ Administration
                </Link>
              </li>
            </ul>
          </div>
        </div>

        <div className="border-t border-white/8 pt-6 flex flex-col md:flex-row justify-between
                        items-center gap-3 text-xs">
          <span>{copyright}</span>
          <span>
            {get('address', 'Cameroun — Bafoussam')} —{' '}
            <a href={mailLink(email)} className="text-green-light hover:underline">
              {email}
            </a>
          </span>
        </div>
      </div>
    </footer>
  )
}
