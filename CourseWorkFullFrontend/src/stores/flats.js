import { defineStore } from 'pinia'
import axios from '@/axios'

export let useFlatsStore = defineStore('flats', {
    state: () => ({
        flats: [],
        currentFlat: null
    }),

    actions: {
        async fetchFlats() {
            try {
                let response = await axios.get('/flats')
                this.flats = response.data
            } catch (error) {
                console.error('Ошибка получения квартир:', error)
                throw error
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
        }
    }
})
