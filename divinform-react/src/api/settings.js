import api from './axios'

export const settingsAPI = {
  getPublic:  ()        => api.get('/v1/settings'),
  getAll:     ()        => api.get('/admin/settings'),
  update:     (data)    => api.put('/admin/settings', data),
  uploadImage: (file)   => {
    const fd = new FormData()
    fd.append('file', file)
    // Content-Type à undefined => axios pose le multipart/form-data + boundary
    return api.post('/admin/settings/upload', fd, { headers: { 'Content-Type': undefined } })
  },
  getStats:   ()        => api.get('/admin/stats'),
  getUsers:   ()        => api.get('/admin/users'),
  createUser: (data)    => api.post('/admin/users', data),
  updateUser: (id, data)=> api.put(`/admin/users/${id}`, data),
  deleteUser: (id)      => api.delete(`/admin/users/${id}`),
}
