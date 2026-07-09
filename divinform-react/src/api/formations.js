import api from './axios'

export const formationsAPI = {
  // ── Public (/v1/) ─────────────────────────────────────
  getAll:       (params) => api.get('/v1/formations', { params }),
  getOne:       (slug)   => api.get(`/v1/formations/${slug}`),
  trackView:    (id)     => api.post(`/v1/formations/${id}/view`),
  trackContact: (id)     => api.post(`/v1/formations/${id}/contact`),
  inscrire:     (payload) => api.post('/v1/inscriptions', payload),

  // ── Admin (/admin/) ───────────────────────────────────
  adminGetAll: (params)     => api.get('/admin/formations', { params }),
  create:      (formData)   => api.post('/admin/formations', formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  }),
  update:      (id, formData) => api.post(`/admin/formations/${id}?_method=PUT`, formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  }),
  delete:      (id) => api.delete(`/admin/formations/${id}`),

  // Sessions
  getSessions:    (params) => api.get('/admin/formation-sessions', { params }),
  createSession:  (data)      => api.post('/admin/formation-sessions', data),
  updateSession:  (id, data)  => api.put(`/admin/formation-sessions/${id}`, data),
  deleteSession:  (id)        => api.delete(`/admin/formation-sessions/${id}`),

  // Demandes d'inscription
  getInscriptions:    (params)    => api.get('/admin/inscriptions', { params }),
  updateInscription:  (id, data)  => api.put(`/admin/inscriptions/${id}`, data),
  deleteInscription:  (id)        => api.delete(`/admin/inscriptions/${id}`),
}
