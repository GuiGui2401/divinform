import api from './axios'

const P = '/admin/farm'

export const farmAPI = {
  dashboard: () => api.get(`${P}/dashboard`),

  // Ateliers
  getUnits:   ()        => api.get(`${P}/units`),
  createUnit: (data)    => api.post(`${P}/units`, data),
  updateUnit: (id, d)   => api.put(`${P}/units/${id}`, d),
  deleteUnit: (id)      => api.delete(`${P}/units/${id}`),

  // Bandes
  getBatches:   (params) => api.get(`${P}/batches`, { params }),
  createBatch:  (data)   => api.post(`${P}/batches`, data),
  updateBatch:  (id, d)  => api.put(`${P}/batches/${id}`, d),
  deleteBatch:  (id)     => api.delete(`${P}/batches/${id}`),

  // Animaux
  getAnimals:   (params) => api.get(`${P}/animals`, { params }),
  createAnimal: (data)   => api.post(`${P}/animals`, data),
  updateAnimal: (id, d)  => api.put(`${P}/animals/${id}`, d),
  deleteAnimal: (id)     => api.delete(`${P}/animals/${id}`),

  // Aliments & stocks
  getFeedItems:   (params) => api.get(`${P}/feed-items`, { params }),
  createFeedItem: (data)   => api.post(`${P}/feed-items`, data),
  updateFeedItem: (id, d)  => api.put(`${P}/feed-items/${id}`, d),
  deleteFeedItem: (id)     => api.delete(`${P}/feed-items/${id}`),

  getMovements:   (params) => api.get(`${P}/feed-movements`, { params }),
  createMovement: (data)   => api.post(`${P}/feed-movements`, data),
  deleteMovement: (id)     => api.delete(`${P}/feed-movements/${id}`),

  // Suivi vétérinaire
  getHealthEvents:   (params) => api.get(`${P}/health-events`, { params }),
  createHealthEvent: (data)   => api.post(`${P}/health-events`, data),
  deleteHealthEvent: (id)     => api.delete(`${P}/health-events/${id}`),
}

export const UNIT_TYPES = [
  { value: 'aviculture',   label: 'Aviculture' },
  { value: 'pisciculture', label: 'Pisciculture' },
  { value: 'porcin',       label: 'Élevage porcin' },
  { value: 'cuniculture',  label: 'Cuniculture' },
  { value: 'autre',        label: 'Autre' },
]

export const BATCH_STATUSES = [
  { value: 'en_cours',   label: 'En cours',   cls: 'bg-blue-50 text-blue-dark' },
  { value: 'disponible', label: 'Disponible', cls: 'bg-green/10 text-green' },
  { value: 'termine',    label: 'Terminée',   cls: 'bg-gray-100 text-gray-med' },
]

export const ANIMAL_STATUSES = [
  { value: 'actif',   label: 'Actif',    cls: 'bg-green/10 text-green' },
  { value: 'vendu',   label: 'Vendu',    cls: 'bg-blue-50 text-blue-dark' },
  { value: 'reforme', label: 'Réformé',  cls: 'bg-amber-50 text-amber-800' },
  { value: 'mort',    label: 'Mort',     cls: 'bg-gray-100 text-gray-med' },
]

export const MOVEMENT_TYPES = [
  { value: 'entree',     label: 'Entrée (réception)',      cls: 'bg-green/10 text-green' },
  { value: 'sortie',     label: 'Sortie (ration)',         cls: 'bg-blue-50 text-blue-dark' },
  { value: 'perte',      label: 'Perte',                   cls: 'bg-red-50 text-red-500' },
  { value: 'ajustement', label: 'Inventaire (ajustement)', cls: 'bg-amber-50 text-amber-800' },
]

export const HEALTH_TYPES = [
  { value: 'traitement',  label: 'Traitement',   cls: 'bg-blue-50 text-blue-dark' },
  { value: 'vaccination', label: 'Vaccination',  cls: 'bg-green/10 text-green' },
  { value: 'visite',      label: 'Visite véto',  cls: 'bg-amber-50 text-amber-800' },
  { value: 'mortalite',   label: 'Mortalité',    cls: 'bg-red-50 text-red-500' },
]

export const fmtDate = (iso) =>
  iso ? new Date(iso).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' }) : '—'

export const today = () => new Date().toISOString().slice(0, 10)
