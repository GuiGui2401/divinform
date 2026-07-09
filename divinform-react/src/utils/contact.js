import { getSetting } from './settingsStore'

// Indicatif pays par défaut : Gabon (+241).
const DEFAULT_CC = import.meta.env.VITE_COUNTRY_CODE || '241'

const FALLBACK_PHONE = '060337821'
const FALLBACK_EMAIL = 'divinformelevage@gmail.com'

/**
 * Normalise un numéro au format E.164 sans le « + » (ce qu'attend wa.me).
 *
 * Au Gabon le zéro initial est un préfixe de numérotation nationale : il doit
 * disparaître à l'international, sinon WhatsApp résout un tout autre compte.
 *   060337821        → 24160337821
 *   241060337821     → 24160337821   (le zéro en trop est retiré)
 *   +241 60 33 78 21 → 24160337821
 */
export const toE164 = (raw, cc = DEFAULT_CC) => {
  let digits = String(raw ?? '').replace(/\D/g, '')
  if (!digits) return ''
  if (digits.startsWith('00')) digits = digits.slice(2)

  const national = digits.startsWith(cc) ? digits.slice(cc.length) : digits
  return cc + national.replace(/^0+/, '')
}

const waNumber = () =>
  toE164(getSetting('whatsapp', import.meta.env.VITE_WHATSAPP_NUMBER || FALLBACK_PHONE))

const waHref = (msg) => `https://wa.me/${waNumber()}?text=${encodeURIComponent(msg)}`

/** Lien WhatsApp générique, ou ciblé sur un produit de la ferme. */
export const waLink = (productName = '') => {
  const tmpl = productName
    ? getSetting('wa_msg_product', "Bonjour, je suis intéressé(e) par : {product}. Pouvez-vous me donner plus d'informations ?")
    : getSetting('wa_msg_default', 'Bonjour, je souhaite avoir des informations sur le centre de formation.')
  return waHref(tmpl.replace('{product}', productName))
}

/** Lien WhatsApp d'inscription à une formation. */
export const waFormationLink = (formationTitle = '', sessionLabel = '') => {
  const tmpl = getSetting(
    'wa_msg_formation',
    "Bonjour, je souhaite m'inscrire à la formation : {formation}. Pouvez-vous me communiquer les modalités ?",
  )
  return waHref(tmpl.replace('{formation}', formationTitle).replace('{session}', sessionLabel))
}

export const callLink = (phone) => `tel:+${toE164(phone || getSetting('phone1', FALLBACK_PHONE))}`

export const mailLink = (email, subject = '') => {
  const addr = email || getSetting('email', FALLBACK_EMAIL)
  return `mailto:${addr}${subject ? `?subject=${encodeURIComponent(subject)}` : ''}`
}

/** Affichage national lisible : 060337821 → « 060 33 78 21 ». */
export const formatPhone = (raw) => {
  const e164 = toE164(raw)
  if (!e164.startsWith(DEFAULT_CC)) return String(raw ?? '')
  const national = '0' + e164.slice(DEFAULT_CC.length)
  return national.replace(/^(\d{3})(\d{2})(\d{2})(\d{2})$/, '$1 $2 $3 $4')
}
