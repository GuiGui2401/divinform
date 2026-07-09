import { useState, useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { closeProductModal, selectModalProduct } from '@/store/slices/uiSlice'
import Modal from '../ui/Modal'
import { waLink, callLink, mailLink } from '@/utils/contact'

export default function ProductModal() {
  const dispatch = useDispatch()
  const product  = useSelector(selectModalProduct)
  const [imgIdx, setImgIdx] = useState(0)

  // Réinitialise la galerie à chaque produit ouvert
  useEffect(() => { setImgIdx(0) }, [product?.id])

  if (!product) return null

  const images = product.images || []
  const img    = images[imgIdx] || images[0] || ''

  return (
    <Modal open={!!product} onClose={() => dispatch(closeProductModal())} maxWidth="max-w-2xl">
      {/* Hero image */}
      {img && (
        <img
          src={img}
          alt={product.name}
          className="w-full h-64 object-cover rounded-t-3xl"
          onError={(e) => { e.target.style.display = 'none' }}
        />
      )}

      <div className="p-7">
        {/* Galerie : miniatures */}
        {images.length > 1 && (
          <div className="flex gap-2 mb-5 flex-wrap">
            {images.map((im, i) => (
              <button key={i} onClick={() => setImgIdx(i)}
                className={`w-16 h-16 rounded-xl overflow-hidden border-2 transition-all cursor-pointer p-0 bg-transparent
                  ${imgIdx === i ? 'border-blue-mid' : 'border-transparent hover:border-gray-200'}`}>
                <img src={im} alt="" className="w-full h-full object-cover"
                     onError={(e) => { e.target.style.display = 'none' }} />
              </button>
            ))}
          </div>
        )}

        {/* Header */}
        <div className="flex justify-between items-start mb-4">
          <div className="flex-1 pr-4">
            {product.badge && (
              <span className="inline-block text-white text-xs font-bold px-2.5 py-1 rounded-full mb-2"
                    style={{ backgroundColor: product.badge_color || '#2ECC71' }}>
                {product.badge}
              </span>
            )}
            <h2 className="font-display font-bold text-dark text-xl leading-tight">
              {product.name}
            </h2>
          </div>
          <button
            onClick={() => dispatch(closeProductModal())}
            className="w-9 h-9 bg-off-white hover:bg-gray-100 rounded-full flex items-center
                       justify-center text-dark transition-colors border-0 cursor-pointer flex-shrink-0"
          >
            ✕
          </button>
        </div>

        {/* Description */}
        <p className="text-gray-med text-sm leading-relaxed mb-6">{product.description}</p>

        {/* Specs */}
        {product.specs?.length > 0 && (
          <>
            <h3 className="text-xs font-bold uppercase tracking-widest text-dark mb-3">
              Caractéristiques techniques
            </h3>
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-6">
              {product.specs.map((s) => (
                <div key={s.label}
                  className="flex justify-between items-center bg-off-white rounded-lg px-3.5 py-2.5 text-sm">
                  <span className="text-gray-med">{s.label}</span>
                  <span className="font-semibold text-dark">{s.value}</span>
                </div>
              ))}
            </div>
          </>
        )}

        {/* Contact buttons */}
        <div className="flex flex-col sm:flex-row gap-2.5">
          <a href={callLink()} className="flex-1 bg-blue-dark hover:bg-blue-mid text-white
                                          font-semibold text-sm py-3 rounded-xl text-center
                                          transition-colors no-underline flex items-center justify-center gap-2">
            📞 Appeler
          </a>
          <a href={waLink(product.name)} target="_blank" rel="noopener"
             className="flex-1 bg-[#25D366] hover:bg-[#20B858] text-white
                        font-semibold text-sm py-3 rounded-xl text-center
                        transition-colors no-underline flex items-center justify-center gap-2">
            💬 WhatsApp
          </a>
          <a href={mailLink('', `Demande d'info : ${product.name}`)}
             className="flex-1 bg-off-white hover:bg-gray-100 text-dark
                        font-semibold text-sm py-3 rounded-xl text-center
                        transition-colors no-underline flex items-center justify-center gap-2
                        border border-gray-100">
            📧 Email
          </a>
        </div>
      </div>
    </Modal>
  )
}
