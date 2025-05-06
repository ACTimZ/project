<script setup>
import HeaderComponent from '@/components/Header/HeaderComponent.vue'
import FooterComponent from '@/components/Footer/FooterComponent.vue'
import ChatModal from '@/components/ModalWindows/ChatModal.vue'
import { useRouter, useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import axios from '@/axios'

// import { useAuthStore } from '@/stores/auth'
// const authStore = useAuthStore()

const flat = ref(null)
const isLoading = ref(true)
// const showChat = ref(false)
// const prefilledMessage = ref('')
const isFavourite = ref(false)

const router = useRouter()
const route = useRoute()
const userId = JSON.parse(localStorage.getItem('user')).id

// async function checkIfFavourite() {
//   try {
//     const response = await axios.get('/profile/favourites')
//     isFavourite.value = response.data.some(fav => fav.flat_id === flat.value.id)
//   } catch (error) {
//     console.log("Ответ:")
//     console.error('Ошибка проверки избранного:', error)
//   }
// }

// function isUserAuthenticated() {
//   return !!localStorage.getItem('user')
// }

// function isUserAuthenticated() {
//   return authStore.isAuthenticated
// }

const fetchFavourites = async () => {
  if (!userId) return

  try {
    const { data } = await axios.get(`/favourites?user_id=${userId}`)
    // console.log(data)
    isFavourite.value = data.some(fav => fav.flat_id == route.params.id)
    // console.log(isFavourite.value)
  } catch (error) {
    console.error('Ошибка при получении избранного:', error)
  } finally {
    isLoading.value = false
  }
}

const toggleFavourite = async () => {
  if (!userId) {
    alert('Сначала авторизуйтесь!')
    return
  }

  try {
    if (isFavourite.value) {
      let data = await axios.delete('/favourites', {
        data: {
          user_id: userId,
          flat_id: route.params.id
        }
      })

      isFavourite.value = false

      alert(data.data.message)
    } else {
      let data = await axios.post('/favourites', {
        user_id: Number(userId),
        flat_id: Number(route.params.id),
      })

      isFavourite.value = true

      alert(data.data.message)
    }
  } catch (error) {
    console.error('Ошибка при обновлении избранного:', error)
  }
}

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}

async function fetchFlat() {
  try {
    const response = await axios.get(`/flats/${route.params.id}`)
    flat.value = response.data
  } catch (error) {
    console.error('Ошибка загрузки данных о квартире:', error)
  } finally {
    isLoading.value = false
  }
}

// async function toggleFavourite() {
//   if (!isUserAuthenticated()) {
//     alert('Пожалуйста, авторизуйтесь, чтобы добавить квартиру в избранное.')
//     return
//   }

//   try {
//     if (isFavourite.value) {
//       await axios.delete(`/profile/favourites/${flat.value.id}`)
//       isFavourite.value = false
//     } else {
//       await axios.post(`/profile/favourites/${flat.value.id}`)
//       isFavourite.value = true
//     }
//   } catch (error) {
//     console.error('Ошибка изменения состояния избранного:', error)
//   }
// }

function goBack() {
  router.back()
}

// function openChatWithPrefilledMessage() {
//   if (flat.value) {
//     prefilledMessage.value = `Здравствуйте! Хочу узнать подробнее о квартире №${flat.value.id} (${flat.value.square_meters}м²) стоимостью ${numberWithSpaces(flat.value.price_current)} ₽.`
//     showChat.value = true
//   }
// }

onMounted(() => {
  fetchFlat(),
    fetchFavourites()
  // if (isUserAuthenticated()) {
  //   checkIfFavourite()
  // }
})
</script>

<template>
  <HeaderComponent />
  <main class="container mx-auto mt-10 mb-20 px-4 sm:px-6 lg:px-8 relative">
    <article class="absolute top-[-25px] left-[-1%]">
      <button @click="goBack"
        class="bg-indigo-900 text-white font-bold px-5 py-3 rounded-xl hover:bg-indigo-800 transition duration-150 cursor-pointer">
        {{ '<' }} Назад </button>
    </article>

    <article v-if="isLoading" class="text-center py-10">
      <p>Загрузка данных...</p>
    </article>

    <article v-else-if="flat" class="flex flex-col md:gap-15 gap-8">
      <article class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-30 gap-8">
        <article class="flex flex-col gap-4 w-full">
          <img :src="flat.images?.[0] || '../components/Images/FlatExample/Example_Flat.png'" alt="Главное фото"
            class="w-full aspect-video object-cover rounded-xl" />
          <div class="grid grid-cols-3 gap-2">
            <img v-for="(image, index) in flat.images?.slice(1)" :key="index" :src="image" alt="Превью"
              class="w-full aspect-video object-cover rounded-xl" />
          </div>
        </article>

        <article class="flex flex-col gap-8">
          <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-indigo-900 leading-tight">
            {{ flat.rooms_count }}-к. квартира, {{ flat.square_meters }}м²,
            {{ flat.floor + '/' + flat.floors_in_house }} эт. <br />
            ЖК {{ flat.housing_complex }}
          </h2>

          <article class="flex flex-col gap-5">
            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Цена:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(flat.price_current) }} ₽
              </b>
            </div>

            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Цена за м²:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(Math.floor(flat.price_current / flat.square_meters)) }} ₽
              </b>
            </div>

            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Балкон:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ flat.has_balcony ? 'Есть' : 'Нет' }}
              </b>
            </div>

            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Совм. с/у:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ flat.bathroom_combined ? 'Объединены' : 'Раздельный' }}
              </b>
            </div>

            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Тип дома:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ flat.house_type }}
              </b>
            </div>
          </article>

          <article class="flex flex-col sm:flex-row gap-4">
            <button @click="toggleFavourite" :class="[
              'cursor-pointer flex items-center justify-center gap-3 border-2 px-5 py-2 rounded-lg font-bold transition duration-300',
              isFavourite
                ? 'bg-rose-800 text-white border-rose-800'
                : 'text-rose-800 border-rose-800 hover:bg-rose-100',
            ]">
              {{ isFavourite ? 'В избранном' : 'Добавить в избранное' }}
            </button>
            <button @click="openChatWithPrefilledMessage"
              class="cursor-pointer border-2 border-orange-200 bg-orange-100 px-5 py-2 rounded-lg font-bold text-orange-900 hover:bg-orange-200 transition duration-300">
              Связаться
            </button>
          </article>
        </article>
      </article>

      <article class="grid grid-cols-1 md:grid-cols-2 md:gap-30 gap-7.5">
        <article class="flex flex-col gap-3">
          <h3 class="text-lg sm:text-xl md:text-2xl font-bold">Описание</h3>
          <p class="text-sm sm:text-base md:text-lg leading-relaxed">{{ flat.description }}</p>
        </article>

        <article class="flex flex-col gap-3">
          <h3 class="text-lg sm:text-xl md:text-2xl font-bold">Изменение цены</h3>
          <div class="flex flex-col gap-4">
            <div>
              <h4 class="text-sm sm:text-base md:text-lg font-semibold mb-1">Цена на старте:</h4>
              <p class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(flat.price_start) }} ₽
              </p>
              <p class="text-xs sm:text-sm text-gray-500">(в момент {{ flat.created_at }})</p>
            </div>

            <div v-if="flat.price_current != flat.price_start">
              <h4 class="text-sm sm:text-base md:text-lg font-semibold mb-1">
                Текущая цена на момент изменения:
              </h4>
              <p class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(flat.price_current) }} ₽
              </p>
              <p class="text-xs sm:text-sm text-gray-500">
                (в момент {{ flat.updated_at }})
              </p>
            </div>
          </div>
        </article>
      </article>
    </article>

    <article v-else class="text-center py-10">
      <p>Квартира не найдена.</p>
    </article>
  </main>
  <ChatModal v-if="showChat" :visible="showChat" :initialMessage="prefilledMessage" @close="showChat = false" />
  <FooterComponent />
</template>
