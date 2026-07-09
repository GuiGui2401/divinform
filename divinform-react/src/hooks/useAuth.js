import { useDispatch, useSelector } from 'react-redux'
import { login, logout, fetchMe, clearError, selectAuth, selectIsAdmin } from '@/store/slices/authSlice'
import { useEffect } from 'react'

export function useAuth() {
  const dispatch  = useDispatch()
  const auth      = useSelector(selectAuth)
  const isAdmin   = useSelector(selectIsAdmin)

  // Rehydrate user from token on mount
  useEffect(() => {
    if (auth.token && !auth.user) dispatch(fetchMe())
  }, [])

  return {
    user:       auth.user,
    token:      auth.token,
    isAdmin,
    loading:    auth.loading,
    error:      auth.error,
    login:      (creds) => dispatch(login(creds)),
    logout:     ()      => dispatch(logout()),
    clearError: ()      => dispatch(clearError()),
  }
}
