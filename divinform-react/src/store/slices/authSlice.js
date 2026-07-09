import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import { authAPI } from '@/api/auth'

// ── Thunks — appels API réels ─────────────────────────────
export const login = createAsyncThunk(
  'auth/login',
  async (credentials, { rejectWithValue }) => {
    try {
      const res = await authAPI.login(credentials)
      localStorage.setItem('divinform_token', res.data.access_token)
      return res.data
    } catch (err) {
      return rejectWithValue(
        err.response?.data?.message || 'Email ou mot de passe incorrect'
      )
    }
  }
)

export const logout = createAsyncThunk('auth/logout', async () => {
  try {
    await authAPI.logout()
  } catch (_) {
    // on ignore les erreurs réseau lors du logout
  } finally {
    localStorage.removeItem('divinform_token')
  }
})

export const fetchMe = createAsyncThunk(
  'auth/me',
  async (_, { rejectWithValue }) => {
    try {
      const res = await authAPI.me()
      return res.data.data
    } catch (err) {
      localStorage.removeItem('divinform_token')
      return rejectWithValue(err.response?.data?.message || 'Session expirée')
    }
  }
)

// ── Slice ─────────────────────────────────────────────────
const authSlice = createSlice({
  name: 'auth',
  initialState: {
    user:    null,
    token:   localStorage.getItem('divinform_token') || null,
    loading: false,
    error:   null,
  },
  reducers: {
    clearError: (s) => { s.error = null },
  },
  extraReducers: (builder) => {
    builder
      // login
      .addCase(login.pending,    (s) => { s.loading = true; s.error = null })
      .addCase(login.fulfilled,  (s, { payload }) => {
        s.loading = false
        s.token   = payload.access_token
        s.user    = payload.user
      })
      .addCase(login.rejected,   (s, { payload }) => {
        s.loading = false
        s.error   = payload
      })
      // logout
      .addCase(logout.fulfilled, (s) => { s.user = null; s.token = null })
      // me
      .addCase(fetchMe.pending,  (s) => { s.loading = true })
      .addCase(fetchMe.fulfilled,(s, { payload }) => { s.loading = false; s.user = payload })
      .addCase(fetchMe.rejected, (s) => { s.loading = false; s.token = null; s.user = null })
  },
})

export const { clearError } = authSlice.actions
export default authSlice.reducer

// ── Selectors ─────────────────────────────────────────────
export const selectAuth    = (s) => s.auth
export const selectIsAdmin = (s) => !!s.auth.token
export const selectUser    = (s) => s.auth.user
export const selectRole    = (s) => s.auth.user?.role || null
export const selectAuthLoading = (s) => s.auth.loading
export const selectAuthError   = (s) => s.auth.error
