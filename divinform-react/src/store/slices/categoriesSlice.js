import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import { categoriesAPI } from '@/api/categories'

// ── Thunks — appels API réels ─────────────────────────────
export const fetchCategories = createAsyncThunk(
  'categories/fetchAll',
  async (_, { rejectWithValue }) => {
    try {
      const res = await categoriesAPI.getAll()
      return res.data.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors du chargement des catégories')
    }
  }
)

export const createCategory = createAsyncThunk(
  'categories/create',
  async (data, { rejectWithValue }) => {
    try {
      const res = await categoriesAPI.create(data)
      return res.data.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors de la création')
    }
  }
)

export const updateCategory = createAsyncThunk(
  'categories/update',
  async ({ id, data }, { rejectWithValue }) => {
    try {
      const res = await categoriesAPI.update(id, data)
      return res.data.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors de la modification')
    }
  }
)

export const deleteCategory = createAsyncThunk(
  'categories/delete',
  async (id, { rejectWithValue }) => {
    try {
      await categoriesAPI.delete(id)
      return id
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors de la suppression')
    }
  }
)

// ── Slice ─────────────────────────────────────────────────
const categoriesSlice = createSlice({
  name: 'categories',
  initialState: {
    items:   [],
    loading: false,
    error:   null,
  },
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(fetchCategories.pending,   (s) => { s.loading = true; s.error = null })
      .addCase(fetchCategories.fulfilled, (s, { payload }) => { s.loading = false; s.items = payload })
      .addCase(fetchCategories.rejected,  (s, { payload }) => { s.loading = false; s.error = payload })

      .addCase(createCategory.fulfilled,  (s, { payload }) => { s.items.push(payload) })
      .addCase(createCategory.rejected,   (s, { payload }) => { s.error = payload })

      .addCase(updateCategory.fulfilled,  (s, { payload }) => {
        const i = s.items.findIndex((c) => c.id === payload.id)
        if (i >= 0) s.items[i] = payload
      })
      .addCase(updateCategory.rejected,   (s, { payload }) => { s.error = payload })

      .addCase(deleteCategory.fulfilled,  (s, { payload }) => {
        s.items = s.items.filter((c) => c.id !== payload)
      })
      .addCase(deleteCategory.rejected,   (s, { payload }) => { s.error = payload })
  },
})

export default categoriesSlice.reducer
export const selectCategories  = (s) => s.categories.items
export const selectCatsLoading = (s) => s.categories.loading
export const selectCatsError   = (s) => s.categories.error
