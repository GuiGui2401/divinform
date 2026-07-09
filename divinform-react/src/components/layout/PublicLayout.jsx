import { Outlet } from 'react-router-dom'
import { useEffect } from 'react'
import { useDispatch } from 'react-redux'
import { fetchCategories } from '@/store/slices/categoriesSlice'
import { fetchFormations } from '@/store/slices/formationsSlice'
import { fetchProducts }   from '@/store/slices/productsSlice'
import { fetchSettings }   from '@/store/slices/settingsSlice'
import { useSettings }     from '@/hooks/useSettings'
import Navbar from './Navbar'
import Footer from './Footer'
import WhatsAppFAB from '../public/WhatsAppFAB'
import ProductModal from '../public/ProductModal'

export default function PublicLayout() {
  const dispatch = useDispatch()
  const { get } = useSettings()

  useEffect(() => {
    dispatch(fetchFormations())
    dispatch(fetchCategories())
    dispatch(fetchProducts())
    dispatch(fetchSettings())
  }, [dispatch])

  // Titre d'onglet + méta-description pilotés par les réglages SEO
  useEffect(() => {
    const title = get('meta_title')
    if (title) document.title = title
    const desc = get('meta_description')
    if (desc) {
      let tag = document.querySelector('meta[name="description"]')
      if (!tag) {
        tag = document.createElement('meta')
        tag.setAttribute('name', 'description')
        document.head.appendChild(tag)
      }
      tag.setAttribute('content', desc)
    }
  }, [get])

  return (
    <div className="min-h-screen flex flex-col">
      <Navbar />
      <main className="flex-1">
        <Outlet />
      </main>
      <Footer />
      <WhatsAppFAB />
      <ProductModal />
    </div>
  )
}
