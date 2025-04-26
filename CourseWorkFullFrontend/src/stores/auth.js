import { defineStore } from 'pinia'
import axios from '@/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token'),
  }),

  actions: {
    async register(userData) {
      try {
        await axios.get('/sanctum/csrf-cookie')
        const response = await axios.post('/register', userData)
        this.user = response.data.user
        this.token = response.data.token
        localStorage.setItem('token', response.data.token)
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
        this.token = response.data.token
        localStorage.setItem('token', response.data.token)
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
        this.token = null
        localStorage.removeItem('token')
        return true
      } catch (error) {
        console.error('Ошибка выхода:', error)
        throw error
      }
    },
  },

  getters: {
    isAuthenticated: (state) => !!state.token,
    isAdmin: (state) => state.user?.role === 'admin',
  },
})
