<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/axios'
import { useRouter } from 'vue-router'
import ChatModal from '../ModalWindows/ChatModal.vue'

const router = useRouter()
const isModalVisible = ref(false)
const selectedFlat = ref(null)
const favourites = ref([]) // Список избранного

// Функция для открытия чата
function openChat(flatData) {
  selectedFlat.value = flatData
  isModalVisible.value = true
}

// Загрузка данных избранного при монтировании компонента
onMounted(async () => {
  try {
    const response = await axios.get('/favorites') // Запрос к API
    favourites.value = response.data // Сохраняем данные в переменную
  } catch (error) {
    console.error('Ошибка загрузки избранного:', error)
  }
})

// Функция для удаления объекта из избранного
async function removeFromFavourites(flatId) {
  try {
    await axios.delete(`/favorites/${flatId}`) // Удаление через API
    favourites.value = favourites.value.filter(flat => flat.id !== flatId) // Обновляем список
  } catch (error) {
    console.error('Ошибка удаления из избранного:', error)
  }
}

// Функция для возврата назад
function goBack() {
  router.back()
}
</script>

<template>
  <section class="container mx-auto relative">
    <ChatModal
      :visible="isModalVisible"
      :chat-user="{ name: 'Админ' }"
      :is-admin-view="true"
      @close="isModalVisible = false"
      :key="selectedFlat?.id"
      @send="(msg) => console.log('Отправлено:', msg)"
      v-if="selectedFlat"
      :initial-message="`Здравствуйте, хочу связаться с квартирой №${selectedFlat.id}, имеющей ${selectedFlat.kv_meters} кв. метров и стоящей ${selectedFlat.price} рублей!`"
    />

    <article class="sticky top-7.5 z-50 mt-5 md:ms-0 ms-5">
      <button
        @click="goBack"
        class="bg-indigo-900 text-white font-bold px-5 py-3 rounded-xl hover:bg-indigo-800 transition duration-150 cursor-pointer"
      >
        {{ '<' }} Назад
      </button>
    </article>

    <article class="flex flex-col mx-15">
      <article class="flex flex-row sm:mt-[-25px] mb-7 justify-center">
        <h2 class="lg:text-3xl text-xl font-medium">Избранное</h2>
      </article>

      <!-- Список избранного -->
      <article class="flex flex-col gap-12.5">
        <article
          v-for="flat in favourites"
          :key="flat.id"
          class="bg-white flex flex-col md:flex-row rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-lg shadow-indigo-200 catalog-card"
        >
          <article
            class="order-1 md:order-2 w-full md:w-[40%] flex items-center justify-center p-4 bg-white border-5 border-indigo-50 rounded-e-lg"
          >
            <article class="w-full h-64 md:h-full max-h-[400px] overflow-hidden rounded-md">
              <img
                :src="flat.image || '../Images/Another_Example_Flat.jpg'"
                alt="Квартира"
                class="w-full h-full object-cover object-center"
              />
            </article>
          </article>
          <article
            class="order-2 md:order-1 w-full md:w-[60%] p-6 sm:p-8 relative bg-indigo-50 flex flex-col gap-5"
          >
            <button
              @click="removeFromFavourites(flat.id)"
              class="absolute md:top-4 top-1 right-4 font-medium hover:bg-rose-300 hover:text-rose-950 px-3 py-1 rounded-lg duration-150 cursor-pointer"
            >
              X Удалить
            </button>

            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-indigo-900 leading-snug">
              {{ flat.count_rooms }}-к. квартира, {{ flat.kv_meters }} м², {{ flat.floor }}/{{
                flat.sum_floor_in_house
              }}
              эт. <br />
              ЖК "{{ flat.housing_complex }}"
            </h2>

            <article class="flex flex-col sm:flex-row sm:items-center sm:gap-4">
              <article>
                <p class="font-bold text-lg sm:text-xl">Цена:</p>
                <p class="font-bold text-2xl sm:text-3xl">
                  {{ flat.price.toLocaleString() }} ₽
                </p>
                <p class="text-sm sm:text-base text-gray-600">
                  {{ (flat.price / flat.kv_meters).toFixed(2).toLocaleString() }} ₽ за м²
                </p>
              </article>
            </article>

            <p class="text-sm sm:text-base md:text-lg text-black line-clamp-4">
              {{ flat.description }}
            </p>

            <button
              @click="openChat(flat)"
              class="px-6 py-2 bg-orange-100 text-indigo-900 text-base sm:text-lg font-semibold rounded-md w-fit"
            >
              связаться
            </button>

            <router-link to="/flat" class="absolute bottom-4 right-4 text-sm text-gray-600">
              подробнее →
            </router-link>
          </article>
        </article>
      </article>
    </article>
  </section>
</template>
