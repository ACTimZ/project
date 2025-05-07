import { defineStore } from 'pinia'
import axios from '@/axios'

export let useFlatsStore = defineStore('flats', {
  state: () => ({
    flats: [],
    currentFlat: null,
    currentPage: 1,
    totalPages: 1,
  }),

  actions: {
    // async fetchFlats(page = 1) {
    //   try {
    //     const response = await axios.get(`/flats?page=${page}`)
    //     this.flats = response.data.data
    //     this.currentPage = response.data.current_page
    //     this.totalPages = response.data.last_page
    //   } catch (error) {
    //     console.error('Ошибка загрузки квартир:', error)
    //   }
    // },
    async fetchFlats(page = 1, filters = {}) {
      try {
        const params = { page, ...filters }

        const response = await axios.get('/flats', { params })
        this.flats = response.data.data
        this.currentPage = response.data.current_page
        this.totalPages = response.data.last_page
      } catch (error) {
        console.error('Ошибка загрузки квартир:', error)
      }
    },

    async fetchFlatById(id) {
      try {
        let response = await axios.get(`/flats/${id}`)
        this.currentFlat = response.data
        return response.data
      } catch (error) {
        console.error('Ошибка получения квартиры:', error)
        throw error
      }
    },

    async createFlat(flatData) {
      try {
        const response = await axios.post('/flats', flatData, {
          headers: {
            'Content-Type': 'application/json',
          },
        })
        return response.data
      } catch (error) {
        console.error('Ошибка при создании квартиры:', error)
        throw error
      }
    },

    async updateFlat(id, flatData) {
      try {
        const response = await axios.put(`/flats/${id}`, flatData)
        return response.data
      } catch (error) {
        console.error('Ошибка при обновлении квартиры вот:', error.response?.data.errors || error)
        throw error
      }
    },
  },
})
