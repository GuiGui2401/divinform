import { useEffect, useState } from 'react'
import { useParams, Link } from 'react-router-dom'
import { useDispatch, useSelector } from 'react-redux'
import { fetchProduct, selectCurrent, selectLoading } from '@/store/slices/productsSlice'
import Spinner from '@/components/ui/Spinner'
import { waLink, callLink, mailLink } from '@/utils/contact'
import { useSettings } from '@/hooks/useSettings'

export default function ProductDetail() {
  const { slug }    = useParams()
  const dispatch    = useDispatch()
  const product     = useSelector(selectCurrent)
  const loading     = useSelector(selectLoading)
  const [imgIdx, setImgIdx] = useState(0)
  const { get } = useSettings()

  useEffect(() => {
    dispatch(fetchProduct(slug))
    window.scrollTo(0, 0)
  }, [slug, dispatch])

  if (loading) return <div className="min-h-screen flex items-center justify-center pt-16"><Spinner size="lg" /></div>
  if (!product) return null

  const images = product.images || []
  const img    = images[imgIdx] || 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&q=80'

  return (
    <div className="min-h-screen pt-20 pb-16 bg-off-white">
      <div className="max-w-5xl mx-auto px-6">
        {/* Breadcrumb */}
        <div className="flex items-center gap-2 text-sm text-gray-med mb-6">
          <Link to="/" className="hover:text-blue-mid transition-colors no-underline text-gray-med">Accueil</Link>
          <span>/</span>
          <span className="text-dark font-medium">{product.name}</span>
        </div>

        <div className="grid md:grid-cols-2 gap-10">
          {/* Images */}
          <div>
            <div className="bg-white rounded-2xl overflow-hidden shadow-card mb-3 aspect-[4/3]">
              <img src={img} alt={product.name} className="w-full h-full object-cover"
                   onError={(e) => { e.target.src = 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&q=80' }} />
            </div>
            {images.length > 1 && (
              <div className="flex gap-2">
                {images.map((im, i) => (
                  <button key={i} onClick={() => setImgIdx(i)}
                    className={`w-16 h-16 rounded-xl overflow-hidden border-2 transition-all cursor-pointer
                      ${imgIdx === i ? 'border-blue-mid' : 'border-transparent hover:border-gray-200'}`}>
                    <img src={im} alt="" className="w-full h-full object-cover" />
                  </button>
                ))}
              </div>
            )}
          </div>

          {/* Info */}
          <div>
            {product.badge && (
              <span className="inline-block text-white text-xs font-bold px-3 py-1 rounded-full mb-3"
                    style={{ backgroundColor: product.badge_color || '#2ECC71' }}>
                {product.badge}
              </span>
            )}
            <h1 className="font-display font-bold text-dark text-2xl leading-tight mb-3">
              {product.name}
            </h1>
            {product.category && (
              <span className="text-sm text-gray-med mb-4 block">
                {product.category.icon} {product.category.name}
              </span>
            )}
            <p className="text-gray-med leading-relaxed mb-6 text-sm">{product.description}</p>

            {/* Specs */}
            {product.specs?.length > 0 && (
              <div className="mb-6">
                <h2 className="text-xs font-bold uppercase tracking-widest text-dark mb-3">
                  Caractéristiques techniques
                </h2>
                <div className="space-y-2">
                  {product.specs.map((s) => (
                    <div key={s.label} className="flex justify-between items-center
                                                   bg-white rounded-lg px-4 py-2.5 text-sm shadow-card">
                      <span className="text-gray-med">{s.label}</span>
                      <span className="font-semibold text-dark">{s.value}</span>
                    </div>
                  ))}
                </div>
              </div>
            )}

            {/* Garantie */}
            <div className="bg-green/8 border border-green/20 rounded-xl p-4 mb-6
                            flex items-center gap-3">
              <span className="text-2xl">✅</span>
              <div>
                <div className="text-green font-bold text-sm">Garantie {get('guarantee_months', '12')} mois constructeur</div>
                <div className="text-gray-med text-xs mt-0.5">Installation et formation incluses</div>
              </div>
            </div>

            {/* Contact buttons */}
            <div className="flex flex-col gap-2.5">
              <a href={waLink(product.name)} target="_blank" rel="noopener"
                 className="py-3.5 bg-[#25D366] hover:bg-[#20B858] text-white font-semibold
                            rounded-xl text-center transition-colors no-underline
                            flex items-center justify-center gap-2">
                💬 Demander un devis sur WhatsApp
              </a>
              <div className="grid grid-cols-2 gap-2">
                <a href={callLink()} className="py-3 bg-blue-dark hover:bg-blue-mid text-white
                                                 font-semibold rounded-xl text-center transition-colors
                                                 no-underline flex items-center justify-center gap-2 text-sm">
                  📞 Appeler
                </a>
                <a href={mailLink(get('email', 'info@medex237.com'), `Info produit : ${product.name}`)}
                   className="py-3 bg-off-white hover:bg-gray-100 text-dark font-semibold
                              rounded-xl text-center transition-colors no-underline border border-gray-200
                              flex items-center justify-center gap-2 text-sm">
                  📧 Email
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
