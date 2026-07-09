import { useSelector } from 'react-redux'
import { selectSettings } from '@/store/slices/settingsSlice'

/**
 * Accès aux réglages publics du site.
 *   const { get, list } = useSettings()
 *   get('site_name', 'Ferme Divinform')          // valeur scalaire avec repli
 *   list('stats', DEFAULT_STATS)         // liste (tableau) avec repli
 */
export function useSettings() {
  const values = useSelector(selectSettings) || {}

  const get = (key, fallback = '') => {
    const v = values[key]
    return (v === undefined || v === null || v === '') ? fallback : v
  }

  const list = (key, fallback = []) => {
    const v = values[key]
    return Array.isArray(v) && v.length ? v : fallback
  }

  return { values, get, list }
}
