import { useNavigate } from 'react-router-dom'
import { useDispatch } from 'react-redux'
import { setFilter } from '@/store/slices/productsSlice'

export default function CategoryCard({ category, active, onClick }) {
  return (
    <div
      onClick={onClick}
      className={`card p-8 cursor-pointer border-[1.5px] transition-all duration-200
        ${active
          ? 'border-blue-mid shadow-card-hover'
          : 'border-transparent hover:border-gray-100'}
        relative overflow-hidden group`}
    >
      {/* Bottom bar animation */}
      <div className="absolute bottom-0 left-0 right-0 h-[3px] bg-gradient-to-r
                      from-blue-dark to-green-light scale-x-0 group-hover:scale-x-100
                      transition-transform duration-300 origin-left" />

      <div className="w-14 h-14 rounded-xl flex items-center justify-center text-3xl mb-5 overflow-hidden"
           style={{ backgroundColor: category.color + '18' }}>
        {category.image
          ? <img src={category.image} alt={category.name} className="w-full h-full object-contain p-1.5" />
          : category.icon}
      </div>
      <h3 className="font-display font-semibold text-dark text-base mb-2">
        {category.name}
      </h3>
      <p className="text-gray-med text-sm leading-relaxed mb-4">
        {category.description}
      </p>
      <span className="text-sm font-semibold" style={{ color: category.color }}>
        → {category.products_count || 0} équipement{(category.products_count || 0) > 1 ? 's' : ''}
      </span>
    </div>
  )
}
