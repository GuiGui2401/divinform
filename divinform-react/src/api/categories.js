import api from './axios'

export const categoriesAPI = {
  // ── Public (/v1/) ─────────────────────────────────────
  getAll:  ()         => api.get('/v1/categories'),
  getOne:  (slug)     => api.get(`/v1/categories/${slug}`),

  // ── Admin (/admin/) ───────────────────────────────────
  create:  (data)     => api.post('/admin/categories', data),
  update:  (id, data) => api.put(`/admin/categories/${id}`, data),
  delete:  (id)       => api.delete(`/admin/categories/${id}`),
}
