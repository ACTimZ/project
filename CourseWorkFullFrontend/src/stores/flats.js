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
    async fetchFlats(page = 1, filters = {}) {
      try {
        const response = await axios.get('/flats', {
          params: { ...filters, page },
        })
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
  },
})
