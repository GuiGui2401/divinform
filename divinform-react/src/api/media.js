import api from './axios'

export const mediaAPI = {
  // folder: 'products' | 'categories' | 'settings' | 'misc'
  upload: (file, folder = 'misc') => {
    const fd = new FormData()
    fd.append('file', file)
    fd.append('folder', folder)
    // Content-Type à undefined => axios pose le multipart/form-data + boundary
    return api.post('/admin/uploads', fd, { headers: { 'Content-Type': undefined } })
  },
}
