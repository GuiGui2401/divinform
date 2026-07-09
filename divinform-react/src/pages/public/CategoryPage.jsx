import { useEffect } from 'react'
import { useParams, Link } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux'
import { fetchProducts, selectProducts, selectLoading } from '@/store/slices/productsSlice'
import { selectCategories } from '@/store/slices/categoriesSlice'
import ProductCard from '@/components/public/ProductCard'
import Spinner from '@/components/ui/Spinner'

export default function CategoryPage() {
  const { slug }   = useParams()
  const dispatch   = useDispatch()
  const products   = useSelector(selectProducts)
  const categories = useSelector(selectCategories)
  const loading    = useSelector(selectLoading)
  const category   = categories.find((c) => c.slug === slug)

  useEffect(() => {
    dispatch(fetchProducts({ category: slug }))
    window.scrollTo(0, 0)
  }, [slug, dispatch])

  return (
    <div className="min-h-screen pt-20 pb-16 bg-off-white">
      <div className="max-w-6xl mx-auto px-6">
        {/* Breadcrumb */}
        <div className="flex items-center gap-2 text-sm text-gray-med mb-8">
          <Link to="/" className="hover:text-blue-mid no-underline text-gray-med">Accueil</Link>
          <span>/</span>
          <span className="text-dark font-medium">{category?.name || slug}</span>
        </div>

        {category && (
          <div className="mb-10">
            <div className="text-4xl mb-3">{category.icon}</div>
            <h1 className="font-display font-bold text-dark text-3xl mb-2">{category.name}</h1>
            <p className="text-gray-med max-w-lg">{category.description}</p>
          </div>
        )}

        {loading ? (
          <div className="flex justify-center py-20"><Spinner size="lg" /></div>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {products.map((p, i) => <ProductCard key={p.id} product={p} index={i} />)}
          </div>
        )}
      </div>
    </div>
  )
}
