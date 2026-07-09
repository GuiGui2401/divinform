import { useDispatch, useSelector } from 'react-redux'
import { setFilter, clearFilters, selectFilters } from '@/store/slices/productsSlice'
import { selectCategories } from '@/store/slices/categoriesSlice'

export default function SearchBar() {
  const dispatch   = useDispatch()
  const filters    = useSelector(selectFilters)
  const categories = useSelector(selectCategories)

  return (
    <div className="bg-white border-b border-gray-100 shadow-card sticky top-16 z-40 py-3.5">
      <div className="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row gap-3">
        {/* Search input */}
        <div className="relative flex-1">
          <span className="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-sm">🔍</span>
          <input
            type="text"
            placeholder="Rechercher un produit de la ferme…"
            value={filters.search}
            onChange={(e) => dispatch(setFilter({ search: e.target.value }))}
            className="form-input pl-10"
          />
        </div>

        {/* Category filter */}
        <select
          value={filters.category}
          onChange={(e) => dispatch(setFilter({ category: e.target.value }))}
          className="form-input sm:w-56"
        >
          <option value="">Toutes les catégories</option>
          {categories.map((c) => (
            <option key={c.id} value={c.id}>{c.icon} {c.name}</option>
          ))}
        </select>

        {/* Clear */}
        {(filters.search || filters.category) && (
          <button
            onClick={() => dispatch(clearFilters())}
            className="px-4 py-2.5 bg-off-white border border-gray-200 text-gray-med
                       text-sm rounded-lg hover:bg-gray-100 transition-colors cursor-pointer"
          >
            ✕ Effacer
          </button>
        )}
      </div>
    </div>
  )
}
