import { Navigate } from 'react-router-dom'
import { useSelector } from 'react-redux'
import { selectIsAdmin } from '@/store/slices/authSlice'

export default function ProtectedRoute({ children }) {
  const isAdmin = useSelector(selectIsAdmin)
  if (!isAdmin) return <Navigate to="/admin/login" replace />
  return children
}
