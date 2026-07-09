import { useEffect } from 'react'

export default function Modal({ open, onClose, children, maxWidth = 'max-w-2xl' }) {
  useEffect(() => {
    document.body.style.overflow = open ? 'hidden' : ''
    return () => { document.body.style.overflow = '' }
  }, [open])

  if (!open) return null

  return (
    <div
      className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-dark/80 backdrop-blur-sm"
      onClick={(e) => e.target === e.currentTarget && onClose()}
    >
      <div className={`bg-white rounded-3xl w-full ${maxWidth} max-h-[90vh] overflow-y-auto shadow-lg-blue
                       animate-fade-in`}>
        {children}
      </div>
    </div>
  )
}
