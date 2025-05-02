import { defineStore } from 'pinia'
import axios from '@/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
  }),

  actions: {
    async register(userData) {
      try {
        await axios.get('/sanctum/csrf-cookie')
        const response = await axios.post('/register', userData)
        this.user = response.data.user
        localStorage.setItem('user', JSON.stringify(response.data.user))
        return true
      } catch (error) {
        console.error('Ошибка регистрации:', error)
        throw error
      }
    },
    async login(credentials) {
      try {
        await axios.get('/sanctum/csrf-cookie')
        const response = await axios.post('/login', credentials)
        this.user = response.data.user
        localStorage.setItem('user', JSON.stringify(response.data.user))
        return true
      } catch (error) {
        console.error('Ошибка входа:', error)
        throw error
      }
    },
    async logout() {
      try {
        await axios.post('/logout')
        this.user = null
        localStorage.removeItem('user')
        return true
      } catch (error) {
        console.error('Ошибка выхода:', error)
        throw error
      }
    },
  },

  getters: {
    isAuthenticated: (state) => !!state.user,
    isAdmin: (state) => state.user?.role === 'admin',
  },
})
