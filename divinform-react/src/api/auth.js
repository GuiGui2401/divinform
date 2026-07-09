import api from './axios'

export const authAPI = {
  login:   (data) => api.post('/auth/login', data),
  logout:  ()     => api.post('/auth/logout'),
  refresh: ()     => api.post('/auth/refresh'),
  me:      ()     => api.get('/auth/me'),
}
