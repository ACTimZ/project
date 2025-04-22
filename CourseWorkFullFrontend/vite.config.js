import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'

import tailwindcss from '@tailwindcss/vite' // Добавление библиотеки tailwind

import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueDevTools(),
    tailwindcss() // Подключение tailwind
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
})
