import api from './axios'

export const productsAPI = {
  // ── Public (/v1/) ─────────────────────────────────────
  getAll:       (params)     => api.get('/v1/products', { params }),
  getOne:       (slug)       => api.get(`/v1/products/${slug}`),
  trackView:    (id)         => api.post(`/v1/products/${id}/view`),
  trackContact: (id)         => api.post(`/v1/products/${id}/contact`),

  // ── Admin (/admin/) ───────────────────────────────────
  adminGetAll:  (params)     => api.get('/admin/products', { params }),
  create:       (formData)   => api.post('/admin/products', formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  }),
  update:       (id, formData) => api.post(`/admin/products/${id}?_method=PUT`, formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  }),
  delete:       (id)         => api.delete(`/admin/products/${id}`),
  uploadImages: (id, fd)     => api.post(`/admin/products/${id}/images`, fd, {
    headers: { 'Content-Type': 'multipart/form-data' },
  }),
  deleteImage:  (id, index)  => api.delete(`/admin/products/${id}/images/${index}`),
}
