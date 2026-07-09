import { useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { fetchProducts, selectProducts, selectLoading, selectFilters, setFilter, clearFilters } from '@/store/slices/productsSlice'
import { selectCategories } from '@/store/slices/categoriesSlice'

export function useProducts(params = {}) {
  const dispatch   = useDispatch()
  const products   = useSelector(selectProducts)
  const loading    = useSelector(selectLoading)
  const filters    = useSelector(selectFilters)
  const categories = useSelector(selectCategories)

  useEffect(() => {
    dispatch(fetchProducts({ ...filters, ...params }))
  }, [filters, dispatch])

  const applyFilter = (updates) => dispatch(setFilter(updates))
  const resetFilters = () => dispatch(clearFilters())

  // filtered client-side for instant UX
  const filtered = products.filter((p) => {
    const q = filters.search?.toLowerCase()
    const matchSearch = !q || p.name.toLowerCase().includes(q) || p.short_desc.toLowerCase().includes(q)
    const matchCat    = !filters.category || String(p.category_id) === String(filters.category)
    return matchSearch && matchCat
  })

  return { products: filtered, loading, filters, categories, applyFilter, resetFilters }
}
