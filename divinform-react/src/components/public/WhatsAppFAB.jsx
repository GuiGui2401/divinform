import { waLink } from '@/utils/contact'

export default function WhatsAppFAB() {
  return (
    <a
      href={waLink()}
      target="_blank"
      rel="noopener noreferrer"
      title="Contactez-nous sur WhatsApp"
      className="fixed bottom-7 left-7 z-40 w-14 h-14 bg-[#25D366] hover:bg-[#20B858]
                 rounded-full flex items-center justify-center text-2xl shadow-lg
                 hover:scale-110 transition-all duration-200"
    >
      💬
    </a>
  )
}
