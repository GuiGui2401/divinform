import { useDispatch } from 'react-redux'
import { openProductModal } from '@/store/slices/uiSlice'
import { waLink } from '@/utils/contact'
import Badge from '../ui/Badge'

export default function ProductCard({ product, index = 0 }) {
  const dispatch = useDispatch()
  const img = product.images?.[0] || 'https://images.unsplash.com/photo-1579154204601-01588f351e67?w=800&q=80'

  return (
    <article
      className="card overflow-hidden cursor-pointer group animate-fade-in"
      style={{ animationDelay: `${index * 0.06}s` }}
    >
      {/* Image */}
      <div className="relative h-48 bg-gray-100 overflow-hidden">
        <img
          src={img}
          alt={product.name}
          loading="lazy"
          className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
          onError={(e) => { e.target.src = 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&q=80' }}
        />
        <Badge text={product.badge} color={product.badge_color} />
        {product.category && (
          <span className="absolute bottom-2 right-2 bg-blue-dark/80 text-white text-xs
                           px-2.5 py-1 rounded-full backdrop-blur-sm">
            {product.category.icon} {product.category.name}
          </span>
        )}
      </div>

      {/* Body */}
      <div className="p-5">
        <h3 className="font-display font-semibold text-dark text-sm leading-snug mb-2">
          {product.name}
        </h3>
        <p className="text-gray-med text-xs leading-relaxed mb-4 line-clamp-2">
          {product.short_desc}
        </p>

        {/* Spec chips */}
        {product.specs?.length > 0 && (
          <div className="flex flex-wrap gap-1.5 mb-4">
            {product.specs.slice(0, 2).map((s) => (
              <span key={s.label}
                className="bg-off-white border border-gray-100 text-gray-med
                           text-[0.68rem] px-2 py-0.5 rounded-full">
                {s.label}: {s.value}
              </span>
            ))}
          </div>
        )}

        {/* Actions */}
        <div className="flex gap-2">
          <button
            onClick={() => dispatch(openProductModal(product))}
            className="flex-1 bg-blue-dark hover:bg-blue-mid text-white text-xs font-semibold
                       py-2.5 rounded-lg transition-colors border-0 cursor-pointer"
          >
            Voir les détails →
          </button>
          <a
            href={waLink(product.name)}
            target="_blank"
            rel="noopener noreferrer"
            className="bg-[#25D366] hover:bg-[#20B858] text-white px-3.5 py-2.5
                       rounded-lg text-sm transition-colors no-underline"
            title="Contacter sur WhatsApp"
          >
            💬
          </a>
        </div>
      </div>
    </article>
  )
}
