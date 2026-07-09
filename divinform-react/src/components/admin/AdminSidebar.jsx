import { NavLink } from 'react-router-dom'

const NAV = [
  { section: 'Principal' },
  { label: 'Vue d\'ensemble',  to: '/admin/dashboard',    icon: '📊' },
  { section: 'Centre de formation' },
  { label: 'Formations',       to: '/admin/formations',   icon: '🎓' },
  { label: 'Inscriptions',     to: '/admin/inscriptions', icon: '📝' },
  { section: 'La ferme' },
  { label: 'Catégories',       to: '/admin/categories',   icon: '🗂️' },
  { label: 'Produits',         to: '/admin/produits',     icon: '🧺' },
  { section: 'Paramètres' },
  { label: 'Informations site', to: '/admin/parametres',  icon: '⚙️' },
  { label: 'Utilisateurs',     to: '/admin/utilisateurs', icon: '👥' },
]

export default function AdminSidebar({ open, onClose, onLogout }) {
  return (
    <>
      {/* Overlay mobile */}
      {open && (
        <div className="fixed inset-0 bg-black/50 z-40 md:hidden" onClick={onClose} />
      )}

      <aside className={`fixed top-0 left-0 h-full w-64 bg-dark z-50 flex flex-col
                         transition-transform duration-300
                         ${open ? 'translate-x-0' : '-translate-x-full md:translate-x-0'}`}>
        {/* Logo */}
        <div className="px-6 py-5 border-b border-white/8 flex items-center justify-between">
          <div className="flex items-center gap-2.5">
            <span className="text-2xl">🎓</span>
            <div>
              <div className="text-white font-display font-bold text-base">C.F Divin Élevage</div>
              <div className="text-white/35 text-xs">Dashboard Admin</div>
            </div>
          </div>
          <button className="md:hidden text-white/50 text-xl bg-transparent border-0 cursor-pointer"
                  onClick={onClose}>✕</button>
        </div>

        {/* Nav */}
        <nav className="flex-1 py-4 overflow-y-auto">
          {NAV.map((item, i) => {
            if (item.section) {
              return (
                <div key={i} className="px-5 py-2 text-[0.65rem] font-bold tracking-widest
                                        uppercase text-white/30 mt-2">
                  {item.section}
                </div>
              )
            }
            return (
              <NavLink
                key={item.to}
                to={item.to}
                onClick={onClose}
                className={({ isActive }) =>
                  `flex items-center gap-3 px-5 py-2.5 text-sm border-l-[3px] transition-all
                   ${isActive
                     ? 'text-white bg-blue-mid/20 border-l-blue-light'
                     : 'text-white/60 border-transparent hover:text-white hover:bg-white/5'}`
                }
              >
                <span className="w-5 text-center">{item.icon}</span>
                {item.label}
              </NavLink>
            )
          })}
        </nav>

        {/* Logout */}
        <div className="border-t border-white/8 p-4">
          <button
            onClick={onLogout}
            className="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-white/50
                       hover:text-white hover:bg-white/5 rounded-lg transition-all
                       bg-transparent border-0 cursor-pointer"
          >
            <span>🚪</span> Déconnexion
          </button>
        </div>
      </aside>
    </>
  )
}
