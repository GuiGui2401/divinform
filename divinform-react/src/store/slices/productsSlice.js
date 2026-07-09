import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import { productsAPI } from '@/api/products'

// ── Thunks — appels API réels ─────────────────────────────
export const fetchProducts = createAsyncThunk(
  'products/fetchAll',
  async (params = {}, { rejectWithValue }) => {
    try {
      const res = await productsAPI.getAll(params)
      return res.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors du chargement des produits')
    }
  }
)

export const fetchProduct = createAsyncThunk(
  'products/fetchOne',
  async (slug, { rejectWithValue }) => {
    try {
      const res = await productsAPI.getOne(slug)
      return res.data.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Produit introuvable')
    }
  }
)

export const createProduct = createAsyncThunk(
  'products/create',
  async (formData, { rejectWithValue }) => {
    try {
      const res = await productsAPI.create(formData)
      return res.data.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors de la création')
    }
  }
)

export const updateProduct = createAsyncThunk(
  'products/update',
  async ({ id, formData }, { rejectWithValue }) => {
    try {
      const res = await productsAPI.update(id, formData)
      return res.data.data
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors de la modification')
    }
  }
)

export const deleteProduct = createAsyncThunk(
  'products/delete',
  async (id, { rejectWithValue }) => {
    try {
      await productsAPI.delete(id)
      return id
    } catch (err) {
      return rejectWithValue(err.response?.data?.message || 'Erreur lors de la suppression')
    }
  }
)

// ── Slice ─────────────────────────────────────────────────
const productsSlice = createSlice({
  name: 'products',
  initialState: {
    items:      [],
    current:    null,
    pagination: { total: 0, per_page: 12, current_page: 1, last_page: 1 },
    filters:    { search: '', category: '', featured: '' },
    loading:    false,
    error:      null,
  },
  reducers: {
    setFilter:    (s, { payload }) => { s.filters = { ...s.filters, ...payload } },
    clearFilters: (s) => { s.filters = { search: '', category: '', featured: '' } },
    clearCurrent: (s) => { s.current = null },
  },
  extraReducers: (builder) => {
    builder
      .addCase(fetchProducts.pending,   (s) => { s.loading = true; s.error = null })
      .addCase(fetchProducts.fulfilled, (s, { payload }) => {
        s.loading    = false
        s.items      = payload.data
        s.pagination = {
          total:        payload.total,
          per_page:     payload.per_page,
          current_page: payload.current_page,
          last_page:    payload.last_page,
        }
      })
      .addCase(fetchProducts.rejected,  (s, { payload }) => { s.loading = false; s.error = payload })

      .addCase(fetchProduct.pending,    (s) => { s.loading = true; s.current = null; s.error = null })
      .addCase(fetchProduct.fulfilled,  (s, { payload }) => { s.loading = false; s.current = payload })
      .addCase(fetchProduct.rejected,   (s, { payload }) => { s.loading = false; s.error = payload })

      .addCase(createProduct.fulfilled, (s, { payload }) => { s.items.unshift(payload) })
      .addCase(createProduct.rejected,  (s, { payload }) => { s.error = payload })

      .addCase(updateProduct.fulfilled, (s, { payload }) => {
        const i = s.items.findIndex((p) => p.id === payload.id)
        if (i >= 0) s.items[i] = payload
      })
      .addCase(updateProduct.rejected,  (s, { payload }) => { s.error = payload })

      .addCase(deleteProduct.fulfilled, (s, { payload }) => {
        s.items = s.items.filter((p) => p.id !== payload)
      })
      .addCase(deleteProduct.rejected,  (s, { payload }) => { s.error = payload })
  },
})

export const { setFilter, clearFilters, clearCurrent } = productsSlice.actions
export default productsSlice.reducer

// ── Selectors ─────────────────────────────────────────────
// Filtrage côté client pour la réactivité instantanée (la recherche
// est aussi envoyée au backend via fetchProducts, mais on filtre
// aussi localement pour un UX sans latence)
export const selectProducts = (s) => {
  const { search, category } = s.products.filters
  return s.products.items.filter((p) => {
    const matchSearch = !search ||
      p.name?.toLowerCase().includes(search.toLowerCase()) ||
      p.short_desc?.toLowerCase().includes(search.toLowerCase())
    const matchCat = !category || String(p.category_id) === String(category)
    return matchSearch && matchCat
  })
}
export const selectAllProducts = (s) => s.products.items
export const selectCurrent     = (s) => s.products.current
export const selectFilters     = (s) => s.products.filters
export const selectPagination  = (s) => s.products.pagination
export const selectLoading     = (s) => s.products.loading
export const selectError       = (s) => s.products.error
