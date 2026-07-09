import { getSetting } from './settingsStore'

// Numéro WhatsApp : réglage du site > variable d'env > repli
const waNumber = () =>
  (getSetting('whatsapp', import.meta.env.VITE_WHATSAPP_NUMBER || '237696809909') || '')
    .replace(/\D/g, '')

export const waLink = (productName = '') => {
  const tmpl = productName
    ? getSetting('wa_msg_product', "Bonjour, je suis intéressé par le produit : {product}. Pouvez-vous me donner plus d'informations ?")
    : getSetting('wa_msg_default', 'Bonjour, je voudrais avoir des informations sur vos produits fermiers.')
  const msg = tmpl.replace('{product}', productName)
  return `https://wa.me/${waNumber()}?text=${encodeURIComponent(msg)}`
}

export const callLink = (phone) =>
  `tel:${(phone || getSetting('phone1', '+237696809909')).replace(/\s/g, '')}`

export const mailLink = (email, subject = '') => {
  const addr = email || getSetting('email', 'contact@divinform.com')
  return `mailto:${addr}${subject ? `?subject=${encodeURIComponent(subject)}` : ''}`
}

export const formatPhone = (p) => p.replace(/(\+237)(\d{3})(\d{3})(\d{3})/, '$1 $2 $3 $4')
