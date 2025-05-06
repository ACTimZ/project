<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/axios'
import { useRouter } from 'vue-router'
import ChatModal from '../ModalWindows/ChatModal.vue'
import gsap from 'gsap'

let router = useRouter()
let isLoading = ref(true)
let isModalVisible = ref(false)
let selectedFlat = ref(null)
let favourites = ref([])
let userId = JSON.parse(localStorage.getItem('user')).id

let hoverIn = (e) => {
  gsap.to(e.currentTarget, { duration: 0.4, scale: 1.01, y: -5 })
}
let hoverOut = (e) => {
  gsap.to(e.currentTarget, { duration: 0.4, scale: 1, y: 0 })
}

function openChat(flatData) {
  selectedFlat.value = flatData
  isModalVisible.value = true
}

let fetchFavourites = async () => {
  if (!userId) return

  isLoading.value = true

  try {
    // доделать отображение в избранном
    let response = await axios.get(`/favourites?user_id=${userId}`)

    favourites.value = response.data

    for (let element of favourites.value) {
      console.log(element)
      // console.log(element.flat.images[0])
    }
    // console.log(favourites.value)
  } catch (error) {
    console.error('Ошибка при получении избранного:', error)
  } finally {
    isLoading.value = false
  }
}

let deleteCard = async (flat_id_card) => {
  try {
    await axios.delete('/favourites', {
      data: {
        user_id: userId,
        flat_id: flat_id_card
      }
    })
    favourites.value = favourites.value.filter(item => item.flat.id !== flat_id_card)
    console.log(`Квартира №${flat_id_card} удалена из избранного!`)
  } catch (error) {
    console.error('Ошибка при обновлении избранного:', error)
  }
}

onMounted(() => {
  fetchFavourites()
  // deleteCard()
})

function goBack() {
  router.back()
}
</script>

<template>
  <section class="container mx-auto relative mb-15">
    <ChatModal :visible="isModalVisible" :chat-user="{ name: 'Админ' }" :is-admin-view="true"
      @close="isModalVisible = false" :key="selectedFlat?.id" @send="(msg) => console.log('Отправлено:', msg)"
      v-if="selectedFlat"
      :initial-message="`Здравствуйте, хочу связаться с квартирой №${selectedFlat.id}, имеющей ${selectedFlat.square_meters} кв. метров и стоящей ${selectedFlat.price_current} рублей!`" />

    <article class="sticky top-7.5 z-50 mt-5 md:ms-0 ms-5">
      <button @click="goBack"
        class="bg-indigo-900 text-white font-bold px-5 py-3 rounded-xl hover:bg-indigo-800 transition duration-150 cursor-pointer">
        {{ '<' }} Назад </button>
    </article>
    <article class="flex flex-col mx-15">
      <article class="flex flex-row sm:mt-[-25px] mb-7 justify-center">
        <h2 class="lg:text-3xl text-xl font-medium">Избранное</h2>
      </article>

      <!-- Список избранного -->
      <article class="flex flex-col gap-12.5">

        <article v-if="isLoading" class="text-center mb-25 mt-15 text-xl">
          Загружаем Ваше избранное...
        </article>

        <article v-else-if="favourites.length === 0" class="text-center my-10 text-xl flex flex-col items-center gap-5">
          <h3 class="font-bold">
            У Вас нет квартир в избранном!
          </h3>
          <p class="font-light">Поспешите, пока не поднялась ключевая ставка:</p>
          <a href="/catalog"
            class="font-bold text-indigo-900 bg-orange-100 hover:bg-orange-200 duration-150 py-3 xl:px-7 xl:text-xl rounded-sm md:text-md md:px-4 hidden lg:block">
            Каталог
          </a>
        </article>

        <article v-else v-for="item_flat in favourites" :key="item_flat.flat.id"
          class="bg-white flex flex-col md:flex-row rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-lg shadow-indigo-200 catalog-card"
          @mouseenter="hoverIn" @mouseleave="hoverOut">
          <article
            class="order-1 md:order-2 w-full md:w-[40%] flex items-center justify-center p-4 bg-white border-5 border-indigo-50 rounded-e-lg">
            <article class="w-full h-64 md:h-full max-h-[400px] overflow-hidden rounded-md">
              <img :src="item_flat.flat.images[0] || '../Images/Another_Example_Flat.jpg'" alt="Квартира"
                class="w-full h-full object-cover object-center" />
            </article>
          </article>
          <article class="order-2 md:order-1 w-full md:w-[60%] p-6 sm:p-8 relative bg-indigo-50 flex flex-col gap-5">
            <button @click="deleteCard(item_flat.flat.id)"
              class="absolute md:top-4 top-1 right-4 font-medium hover:bg-rose-300 hover:text-rose-950 px-3 py-1 rounded-lg duration-150 cursor-pointer">
              X Удалить
            </button>

            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-indigo-900 leading-snug">
              {{ item_flat.flat.rooms_count }}-к. квартира, {{ item_flat.flat.square_meters }} м², {{
                item_flat.flat.floor }}/{{
                item_flat.flat.floors_in_house
              }}
              эт. <br />
              ЖК "{{ item_flat.flat.housing_complex }}"
            </h2>

            <article class="flex flex-col sm:flex-row sm:items-center sm:gap-4">
              <article>
                <p class="font-bold text-lg sm:text-xl">Цена:</p>
                <p class="font-bold text-2xl sm:text-3xl">
                  {{ item_flat.flat.price_current }} ₽
                </p>
                <p class="text-sm sm:text-base text-gray-600">
                  {{ (item_flat.flat.price_current / item_flat.flat.square_meters).toFixed(2) }} ₽ за м²
                </p>
              </article>
            </article>

            <p class="text-sm sm:text-base md:text-lg text-black line-clamp-4">
              {{ item_flat.flat.description }}
            </p>

            <button @click="openChat(item_flat.flat)"
              class="px-6 py-2 bg-orange-100 text-indigo-900 text-base sm:text-lg font-semibold rounded-md w-fit">
              связаться
            </button>

            <router-link :to="`/flat/${item_flat.flat.id}`" class="absolute bottom-4 right-4 text-sm text-gray-600">
              подробнее →
            </router-link>
          </article>
        </article>
      </article>
    </article>
  </section>
</template>
