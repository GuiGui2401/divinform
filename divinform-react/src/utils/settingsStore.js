// Cache module-level des réglages publics, pour les utilitaires non-React
// (ex: utils/contact.js). Alimenté par le slice Redux `settings`.
let _values = {}

export const setSettingsCache = (v) => { _values = v || {} }

export const getSetting = (key, fallback = '') => {
  const v = _values[key]
  return (v === undefined || v === null || v === '') ? fallback : v
}
