import { Outlet, useNavigate } from 'react-router-dom'
import { useDispatch } from 'react-redux'
import { useState } from 'react'
import { logout } from '@/store/slices/authSlice'
import AdminSidebar from '../admin/AdminSidebar'
import toast from 'react-hot-toast'

export default function AdminLayout() {
  const dispatch = useDispatch()
  const navigate = useNavigate()
  const [sidebarOpen, setSidebarOpen] = useState(false)

  const handleLogout = async () => {
    await dispatch(logout())
    toast.success('Déconnecté avec succès')
    navigate('/admin/login')
  }

  return (
    <div className="flex min-h-screen bg-off-white">
      <AdminSidebar
        open={sidebarOpen}
        onClose={() => setSidebarOpen(false)}
        onLogout={handleLogout}
      />

      <div className="flex-1 flex flex-col md:ml-64">
        {/* Top bar */}
        <header className="bg-white border-b border-gray-100 shadow-card px-6 py-4
                           flex items-center justify-between sticky top-0 z-40">
          <div className="flex items-center gap-4">
            <button
              className="md:hidden text-dark text-xl bg-transparent border-0 cursor-pointer"
              onClick={() => setSidebarOpen(true)}
            >
              ☰
            </button>
            <div id="admin-page-title" className="font-display font-bold text-dark text-lg">
              Dashboard
            </div>
          </div>
          <div className="flex items-center gap-3">
            <div className="w-9 h-9 rounded-full bg-blue-dark flex items-center justify-center
                            text-white font-bold text-sm">AD</div>
            <div className="hidden md:block">
              <div className="text-sm font-semibold text-dark">Administrateur</div>
              <div className="text-xs text-gray-med">admin@medex65.com</div>
            </div>
          </div>
        </header>

        {/* Page content */}
        <main className="flex-1 p-6 md:p-8">
          <Outlet />
        </main>
      </div>
    </div>
  )
}
