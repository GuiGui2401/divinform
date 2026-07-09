import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import { formationsAPI } from '@/api/formations'

// ── Thunks ────────────────────────────────────────────────
export const fetchFormations = createAsyncThunk(
  'formations/fetchAll',
  async (params = {}, { rejectWithValue }) => {
    try {
      const res = await formationsAPI.getAll(params)
      return res.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors du chargement des formations')
    }
  }
)

export const fetchFormation = createAsyncThunk(
  'formations/fetchOne',
  async (slug, { rejectWithValue }) => {
    try {
      const res = await formationsAPI.getOne(slug)
      return res.data.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Formation introuvable')
    }
  }
)

export const submitInscription = createAsyncThunk(
  'formations/inscrire',
  async (payload, { rejectWithValue }) => {
    try {
      const res = await formationsAPI.inscrire(payload)
      return res.data.message
    } catch (err) {
      return rejectWithValue({
        message: err.response?.data?.message || "Impossible d'envoyer votre demande.",
        errors:  err.response?.data?.errors || {},
      })
    }
  }
)

export const createFormation = createAsyncThunk(
  'formations/create',
  async (formData, { rejectWithValue }) => {
    try {
      const res = await formationsAPI.create(formData)
      return res.data.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors de la création')
    }
  }
)

export const updateFormation = createAsyncThunk(
  'formations/update',
  async ({ id, formData }, { rejectWithValue }) => {
    try {
      const res = await formationsAPI.update(id, formData)
      return res.data.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors de la modification')
    }
  }
)

export const deleteFormation = createAsyncThunk(
  'formations/delete',
  async (id, { rejectWithValue }) => {
    try {
      await formationsAPI.delete(id)
      return id
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors de la suppression')
    }
  }
)

// ── Slice ─────────────────────────────────────────────────
const formationsSlice = createSlice({
  name: 'formations',
  initialState: {
    items:      [],
    current:    null,
    pagination: { total: 0, per_page: 12, current_page: 1, last_page: 1 },
    filters:    { search: '', level: '' },
    loading:    false,
    error:      null,
    // État du formulaire d'inscription
    inscription: { sending: false, success: null, error: null, fieldErrors: {} },
  },
  reducers: {
    setFormationFilter: (s, { payload }) => { s.filters = { ...s.filters, ...payload } },
    clearFormationFilters: (s) => { s.filters = { search: '', level: '' } },
    clearCurrentFormation: (s) => { s.current = null },
    resetInscription: (s) => { s.inscription = { sending: false, success: null, error: null, fieldErrors: {} } },
  },
  extraReducers: (builder) => {
    builder
      .addCase(fetchFormations.pending,   (s) => { s.loading = true; s.error = null })
      .addCase(fetchFormations.fulfilled, (s, { payload }) => {
        s.loading    = false
        s.items      = payload.data
        s.pagination = {
          total:        payload.total,
          per_page:     payload.per_page,
          current_page: payload.current_page,
          last_page:    payload.last_page,
        }
      })
      .addCase(fetchFormations.rejected,  (s, { payload }) => { s.loading = false; s.error = payload })

      .addCase(fetchFormation.pending,    (s) => { s.loading = true; s.current = null; s.error = null })
      .addCase(fetchFormation.fulfilled,  (s, { payload }) => { s.loading = false; s.current = payload })
      .addCase(fetchFormation.rejected,   (s, { payload }) => { s.loading = false; s.error = payload })

      .addCase(submitInscription.pending,   (s) => {
        s.inscription = { sending: true, success: null, error: null, fieldErrors: {} }
      })
      .addCase(submitInscription.fulfilled, (s, { payload }) => {
        s.inscription = { sending: false, success: payload, error: null, fieldErrors: {} }
      })
      .addCase(submitInscription.rejected,  (s, { payload }) => {
        s.inscription = {
          sending: false,
          success: null,
          error: payload?.message || 'Erreur',
          fieldErrors: payload?.errors || {},
        }
      })

      .addCase(createFormation.fulfilled, (s, { payload }) => { s.items.unshift(payload) })
      .addCase(createFormation.rejected,  (s, { payload }) => { s.error = payload })

      .addCase(updateFormation.fulfilled, (s, { payload }) => {
        const i = s.items.findIndex((f) => f.id === payload.id)
        if (i >= 0) s.items[i] = payload
      })
      .addCase(updateFormation.rejected,  (s, { payload }) => { s.error = payload })

      .addCase(deleteFormation.fulfilled, (s, { payload }) => {
        s.items = s.items.filter((f) => f.id !== payload)
      })
      .addCase(deleteFormation.rejected,  (s, { payload }) => { s.error = payload })
  },
})

export const {
  setFormationFilter,
  clearFormationFilters,
  clearCurrentFormation,
  resetInscription,
} = formationsSlice.actions

export default formationsSlice.reducer

// ── Selectors ─────────────────────────────────────────────
export const selectFormations = (s) => {
  const { search, level } = s.formations.filters
  return s.formations.items.filter((f) => {
    const term = search.toLowerCase()
    const matchSearch = !search ||
      f.title?.toLowerCase().includes(term) ||
      f.summary?.toLowerCase().includes(term)
    const matchLevel = !level || f.level === level
    return matchSearch && matchLevel
  })
}
export const selectAllFormations     = (s) => s.formations.items
export const selectCurrentFormation  = (s) => s.formations.current
export const selectFormationFilters  = (s) => s.formations.filters
export const selectFormationsLoading = (s) => s.formations.loading
export const selectFormationsError   = (s) => s.formations.error
export const selectInscription       = (s) => s.formations.inscription
