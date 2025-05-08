<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from '@/axios'
import HeaderComponent from '@/components/Header/HeaderComponent.vue'
import FooterComponent from '@/components/Footer/FooterComponent.vue'

let router = useRouter()
let activeTab = ref('flats')
let flats = ref([])
let isAdmin = ref(false)
let appeals = ref([])

let fetchAppeals = async () => {
  try {
    let response = await axios.get('/appeals')
    appeals.value = response.data
    console.log(response.value)
  } catch (error) {
    console.error('Ошибка при загрузке обращений:', error)
  }
}

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

let fetchFlats = async () => {
  try {
    let response = await axios.get('/flats?forAdmin=true')
    flats.value = response.data
  } catch (error) {
    console.error('Ошибка при загрузке квартир:', error)
  }
}

let deleteFlat = async (id) => {
  try {
    await axios.delete(`/flats/${id}`)
    flats.value = flats.value.filter(flat => flat.id !== id)
    alert(`Квартира №${id} удалена!`)
  } catch (error) {
    console.error('Ошибка при удалении квартиры:', error)
  }
}

let goToEdit = (id) => {
  router.push(`/flats/${id}/edit`)
}

let goToView = (id) => {
  router.push(`/flat/${id}`)
}

let goToCreate = () => {
  router.push('/admin/flats/create')
}

onMounted(() => {
  fetchFlats()
  fetchAppeals()
})

let tabs = [
  { name: 'Квартиры', key: 'flats' },
  { name: 'Обращения', key: 'requests' },
]

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}

function formatDate(dateString) {
  let date = new Date(dateString);

  let options = {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: false,
    timeZone: 'Europe/Moscow',
  };

  return new Intl.DateTimeFormat('ru-RU', options).format(date);
}
</script>

<template>
  <HeaderComponent />
  <section class="container mx-auto p-4 my-6" v-if="isAdmin">
    <article class="flex justify-center gap-4 mb-4">
      <button v-for="tab in tabs" :key="tab.key" @click="activeTab = tab.key" :class="[
        'px-6 py-2 rounded-xl text-lg font-semibold cursor-pointer transition',
        activeTab === tab.key
          ? 'bg-indigo-900 text-white hover:bg-indigo-800'
          : 'bg-indigo-100 text-indigo-900 hover:bg-indigo-200'
      ]">
        {{ tab.name }}
      </button>
    </article>

    <article v-if="activeTab === 'flats'" class="text-right mb-4 mt-[-25px]">
      <button @click="goToCreate"
        class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition font-medium cursor-pointer">
        Создать квартиру
      </button>
    </article>
    <table v-if="activeTab === 'flats'" class="w-full bg-white shadow-md rounded-xl overflow-hidden">
      <thead class="bg-sky-100">
        <tr>
          <th class="px-4 py-3 text-center">ID</th>
          <th class="px-4 py-3 text-center">Изменено в</th>
          <th class="px-4 py-3 text-center">Количество комнат</th>
          <th class="px-4 py-3 text-center">Название ЖК</th>
          <th class="px-4 py-3 text-center">Текущая цена</th>
          <th class="px-4 py-3 text-center">Действие</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item_flat in flats" :key="item_flat.id" class="border-b border-stone-200 hover:bg-stone-50">
          <td class="px-4 py-3 text-center">{{ item_flat.id }}</td>
          <td class="px-4 py-3 text-center">{{ formatDate(item_flat.updated_at) }}</td>
          <td class="px-4 py-3 text-center">{{ item_flat.rooms_count }}</td>
          <td class="px-4 py-3 text-center">{{ item_flat.housing_complex }}</td>
          <td class="px-4 py-3 text-center">{{ numberWithSpaces(item_flat.price_current.toLocaleString()) }} ₽</td>
          <td class="px-4 py-3">
            <div class="flex justify-center items-center gap-2">
              <button @click="goToView(item_flat.id)"
                class="bg-sky-100 text-blue-800 px-3 py-1 rounded hover:bg-blue-200 text-sm cursor-pointer transition font-medium">Просмотр</button>
              <button @click="goToEdit(item_flat.id)"
                class="bg-orange-100 text-orange-800 px-3 py-1 rounded hover:bg-orange-300 text-sm cursor-pointer transition font-medium">Изменить</button>
              <button @click="deleteFlat(item_flat.id)"
                class="bg-red-100 text-red-800 px-3 py-1 rounded hover:bg-red-700 hover:text-white text-sm cursor-pointer transition font-medium">Удалить</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <article v-if="activeTab === 'requests'">
      <table class="w-full bg-white shadow-md rounded-xl overflow-hidden mt-12.5">
        <thead class="bg-sky-100">
          <tr>
            <th class="px-4 py-3 text-center">Пользователь</th>
            <th class="px-4 py-3 text-center">Контакты</th>
            <th class="px-4 py-3 text-center">Тип сообщения</th>
            <th class="px-4 py-3 text-center">Сообщение</th>
            <th class="px-4 py-3 text-center">Создано</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="appeal in appeals" :key="appeal.id" class="border-b border-stone-200 transition" :class="[appeal.type == 'отзыв' ? 'bg-orange-50 hover:bg-orange-100' : appeal.type == 'квартира' ? 'bg-teal-50 hover:bg-teal-100' : 'hover:bg-stone-50']">
            <td class="px-4 py-3 text-center">{{ appeal.first_name }} {{ appeal.last_name }}</td>
            <td class="px-4 py-3 text-center whitespace-pre-line">{{ appeal.email + "\n" }}{{ appeal.phone }}</td>
            <td class="px-4 py-3 text-center capitalize">{{ appeal.type }}</td>
            <td class="px-4 py-3 text-center max-w-100">{{ appeal.message }}</td>
            <td class="px-4 py-3 text-center">{{ formatDate(appeal.created_at) }}</td>
          </tr>
        </tbody>
      </table>
    </article>

  </section>
  <section v-else class="text-center text-3xl mt-25 mb-50 font-bold">
    Вы не обладаете правами админа!
  </section>

  <FooterComponent />
</template>
