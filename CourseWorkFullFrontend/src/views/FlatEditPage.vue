<template>
  <HeaderComponent/>
  <article class="container mx-auto py-6" v-if="isAdmin">
    <h1 class="text-2xl font-bold mb-4">Редактирование квартиры</h1>

    <form v-if="form" @submit.prevent="handleSubmit" class="space-y-4">
      <article>
        <label>Количество комнат</label>
        <input v-model.number="form.rooms_count" type="number" class="w-full border border-gray-300 rounded px-3 py-2"
          required />
      </article>

      <article>
        <label>Площадь (м²)</label>
        <input v-model.number="form.square_meters" type="number" step="0.01"
          class="w-full border border-gray-300 rounded px-3 py-2" required />
      </article>

      <article>
        <label>Этаж</label>
        <input v-model.number="form.floor" type="number" class="w-full border border-gray-300 rounded px-3 py-2"
          required />
      </article>

      <article>
        <label>Этажность дома</label>
        <input v-model.number="form.floors_in_house" type="number"
          class="w-full border border-gray-300 rounded px-3 py-2" required />
      </article>

      <article>
        <label>Жилой комплекс</label>
        <input v-model="form.housing_complex" type="text" class="w-full border border-gray-300 rounded px-3 py-2"
          required />
      </article>

      <article>
        <label>Цена сейчас</label>
        <input v-model.number="form.price_current" type="number" step="0.01"
          class="w-full border border-gray-300 rounded px-3 py-2" required />
      </article>

      <article>
        <label>Цена стартовая</label>
        <input v-model.number="form.price_start" type="number" step="0.01"
          class="w-full border border-gray-300 rounded px-3 py-2" required />
      </article>

      <article>
        <label>
          <input type="checkbox" v-model="form.has_balcony" />
          Балкон
        </label>
      </article>

      <article>
        <label>
          <input type="checkbox" v-model="form.bathroom_combined" />
          Совмещённый санузел
        </label>
      </article>

      <article>
        <label>Тип дома</label>
        <select v-model="form.house_type" class="w-full border border-gray-300 rounded px-3 py-2" required>
          <option value="Кирпичный">Кирпичный</option>
          <option value="Панельный">Панельный</option>
          <option value="Газобетонный">Газобетонный</option>
        </select>
      </article>

      <article>
        <label>Описание</label>
        <textarea v-model="form.description" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
      </article>

      <article>
        <label>Изображения (через запятую)</label>
        <input v-model="form.imagesText" type="text" class="w-full border border-gray-300 rounded px-3 py-2" />
      </article>

      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 cursor-pointer transition">Сохранить
        изменения</button>
    </form>

    <article v-else class="text-gray-600">Загрузка данных квартиры...</article>
  </article>
  <article v-else class="text-center text-3xl mt-25 mb-50 font-bold">
    Вы не обладаете правами админа!
  </article>
  <FooterComponent/>
</template>

<script setup>
import HeaderComponent from '@/components/Header/HeaderComponent.vue'
import FooterComponent from '@/components/Footer/FooterComponent.vue'
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useFlatsStore } from '@/stores/flats'

let route = useRoute()
let router = useRouter()
let flatsStore = useFlatsStore()
let form = ref(null)
let isAdmin = ref(false)

try {
  let user = JSON.parse(localStorage.getItem('user') || 'null')
  let rights = user?.role ?? null
  if (rights == "admin") {
    isAdmin.value = true
  } else {
    setTimeout(() => {
      router.push("/")
    }, 5000);
  }
} catch {
  isAdmin.value = false
}

onMounted(async () => {
  try {
    let flat = await flatsStore.fetchFlatById(route.params.id)
    form.value = {
      ...flat,
      imagesText: flat.images.join(', ')
    }
  } catch (e) {
    console.error('Ошибка при загрузке квартиры:', e)
  }
})

let handleSubmit = async () => {
  try {
    let updatedFlat = {
      ...form.value,
      images: form.value.imagesText
        .split(',')
        .map(img => img.trim())
        .slice(0, 4)
    }
    delete updatedFlat.imagesText

    await flatsStore.updateFlat(route.params.id, updatedFlat)
    router.push('/profile/admin')
  } catch (e) {
    console.error('Ошибка при обновлении квартиры вот-вот:', e)
  }
}
</script>
