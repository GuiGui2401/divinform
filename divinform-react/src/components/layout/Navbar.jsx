import { useState, useEffect } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { useSettings } from '@/hooks/useSettings'

const NAV_LINKS = [
  { label: 'Accueil',        to: '/', hash: 'hero' },
  { label: 'Nos formations', to: '/', hash: 'formations' },
  { label: 'Pourquoi nous',  to: '/', hash: 'pourquoi' },
  { label: 'La ferme',       to: '/', hash: 'produits' },
  { label: 'Contact',        to: '/', hash: 'contact' },
]

export default function Navbar() {
  const [scrolled, setScrolled] = useState(false)
  const [menuOpen, setMenuOpen] = useState(false)
  const navigate = useNavigate()
  const { get } = useSettings()
  const logoImg = get('logo_image_url')

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 40)
    window.addEventListener('scroll', onScroll)
    return () => window.removeEventListener('scroll', onScroll)
  }, [])

  const scrollTo = (hash) => {
    setMenuOpen(false)
    const el = document.getElementById(hash)
    if (el) {
      el.scrollIntoView({ behavior: 'smooth' })
      return
    }
    // Hors de la page d'accueil : on y revient, puis on rejoint l'ancre.
    navigate('/')
    requestAnimationFrame(() => {
      document.getElementById(hash)?.scrollIntoView({ behavior: 'smooth' })
    })
  }

  return (
    <>
      <nav className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300
        ${scrolled ? 'bg-blue-dark/99 shadow-lg-blue' : 'bg-blue-dark/97'}
        backdrop-blur-md border-b border-white/8`}>
        <div className="max-w-6xl mx-auto px-6">
          <div className="flex items-center justify-between h-16">
            {/* Logo */}
            <Link to="/" className="flex items-center gap-2.5 no-underline">
              <div className="w-10 h-10 rounded-full bg-gradient-to-br from-green-light to-blue-light
                              flex items-center justify-center text-lg flex-shrink-0 overflow-hidden">
                {logoImg
                  ? <img src={logoImg} alt={get('site_name', 'C.F Divin Élevage')} className="w-full h-full object-cover" />
                  : get('logo_emoji', '🎓')}
              </div>
              <div>
                <span className="font-display font-bold text-white text-lg leading-tight block">{get('site_name', 'C.F Divin Élevage')}</span>
                <span className="text-white/50 text-[0.6rem] tracking-widest uppercase">{get('tagline', 'Centre de formation en élevage')}</span>
              </div>
            </Link>

            {/* Desktop links */}
            <ul className="hidden md:flex gap-8 list-none">
              {NAV_LINKS.map((l) => (
                <li key={l.label}>
                  <button
                    onClick={() => scrollTo(l.hash)}
                    className="text-white/75 hover:text-white text-sm font-medium transition-colors
                               border-b-2 border-transparent hover:border-green-light pb-1 bg-transparent border-0 cursor-pointer"
                  >
                    {l.label}
                  </button>
                </li>
              ))}
            </ul>

            {/* CTA */}
            <div className="hidden md:flex items-center gap-3">
              <button
                onClick={() => scrollTo('contact')}
                className="bg-green hover:bg-green-light text-white text-sm font-semibold
                           px-5 py-2 rounded-xl transition-all hover:-translate-y-0.5
                           hover:shadow-lg border-0 cursor-pointer"
              >
                📞 Nous contacter
              </button>
            </div>

            {/* Mobile toggle */}
            <button
              className="md:hidden text-white text-2xl bg-transparent border-0 cursor-pointer"
              onClick={() => setMenuOpen(true)}
            >
              ☰
            </button>
          </div>
        </div>
      </nav>

      {/* Mobile menu overlay */}
      {menuOpen && (
        <div className="fixed inset-0 z-[1500] bg-blue-dark flex flex-col p-6 pt-20">
          <button
            className="absolute top-5 right-5 text-white text-2xl bg-transparent border-0 cursor-pointer"
            onClick={() => setMenuOpen(false)}
          >
            ✕
          </button>
          {NAV_LINKS.map((l) => (
            <button
              key={l.label}
              onClick={() => scrollTo(l.hash)}
              className="text-white font-display font-semibold text-xl py-4 border-b border-white/10
                         text-left bg-transparent border-x-0 border-t-0 cursor-pointer"
            >
              {l.label}
            </button>
          ))}
          <Link
            to="/admin/login"
            className="mt-4 text-white/50 text-sm"
            onClick={() => setMenuOpen(false)}
          >
            ⚙️ Administration
          </Link>
        </div>
      )}
    </>
  )
}
