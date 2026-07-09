import { NavLink } from 'react-router-dom'
import { useSelector } from 'react-redux'
import { selectRole } from '@/store/slices/authSlice'

// `roles` liste les rôles autorisés à voir l'entrée. Une entrée sans `roles`
// est visible de tous. Le back-office reste protégé par l'API : ce filtrage
// évite surtout d'offrir des liens qui répondraient 403.
const NAV = [
  { section: 'Principal', roles: ['super_admin', 'editor', 'viewer'] },
  { label: "Vue d'ensemble", to: '/admin/dashboard', icon: '📊', roles: ['super_admin', 'editor', 'viewer'] },

  { section: 'Centre de formation', roles: ['super_admin', 'editor'] },
  { label: 'Formations',   to: '/admin/formations',   icon: '🎓', roles: ['super_admin', 'editor'] },
  { label: 'Inscriptions', to: '/admin/inscriptions', icon: '📝', roles: ['super_admin', 'editor'] },

  { section: "Gestion de l'exploitation", roles: ['super_admin', 'farm_manager'] },
  { label: 'Vue de la ferme',  to: '/admin/ferme',           icon: '🌾', roles: ['super_admin', 'farm_manager'] },
  { label: 'Ateliers',         to: '/admin/ferme/ateliers',  icon: '🏠', roles: ['super_admin', 'farm_manager'] },
  { label: 'Bandes',           to: '/admin/ferme/bandes',    icon: '🐔', roles: ['super_admin', 'farm_manager'] },
  { label: 'Animaux',          to: '/admin/ferme/animaux',   icon: '🐄', roles: ['super_admin', 'farm_manager'] },
  { label: 'Aliments & stocks',to: '/admin/ferme/aliments',  icon: '🌽', roles: ['super_admin', 'farm_manager'] },
  { label: 'Suivi vétérinaire',to: '/admin/ferme/sante',     icon: '💉', roles: ['super_admin', 'farm_manager'] },

  { section: 'Vitrine', roles: ['super_admin', 'editor'] },
  { label: 'Catégories', to: '/admin/categories', icon: '🗂️', roles: ['super_admin', 'editor'] },
  { label: 'Produits',   to: '/admin/produits',   icon: '🧺', roles: ['super_admin', 'editor'] },

  { section: 'Paramètres', roles: ['super_admin'] },
  { label: 'Informations site', to: '/admin/parametres',   icon: '⚙️', roles: ['super_admin'] },
  { label: 'Utilisateurs',      to: '/admin/utilisateurs', icon: '👥', roles: ['super_admin'] },
]

export default function AdminSidebar({ open, onClose, onLogout }) {
  const role = useSelector(selectRole)
  const visible = NAV.filter((item) => !item.roles || !role || item.roles.includes(role))

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
          {visible.map((item, i) => {
            if (item.section) {
              return (
                <div key={`s-${i}`} className="px-5 py-2 text-[0.65rem] font-bold tracking-widest
                                        uppercase text-white/30 mt-2">
                  {item.section}
                </div>
              )
            }
            return (
              <NavLink
                key={item.to}
                to={item.to}
                end={item.to === '/admin/ferme'}
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
