<script setup>
import HeaderComponent from '@/components/Header/HeaderComponent.vue'
import FooterComponent from '@/components/Footer/FooterComponent.vue'
// import ChatModal from '@/components/ModalWindows/ChatModal.vue'
import { useRouter, useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import axios from '@/axios'
import gsap from 'gsap'

// import { useAuthStore } from '@/stores/auth'
// let authStore = useAuthStore()

let flat = ref(null)
let isLoading = ref(true)
// let showChat = ref(false)
// let prefilledMessage = ref('')
let isFavourite = ref(false)

let showContactModal = ref(false)
let message = ref('')
let isAccepted = ref(false)
let user = ref({})

let router = useRouter()
let route = useRoute()

let userIsAuth = JSON.parse(localStorage.getItem('user') || 'null')
let userId = userIsAuth?.id ?? "NaN"

let hoverInImageFlat = (e) => {
  gsap.to(e.currentTarget, {
    duration: 0.4,
    scale: 1.1,
    boxShadow: '0 0 0 4px white',
    zIndex: 150,
    ease: 'power2.out',
    transformOrigin: 'center center'
  });
};

let hoverOutImageFlat = (e) => {
  gsap.to(e.currentTarget, {
    duration: 0.4,
    scale: 1,
    boxShadow: '0 0 0 0 white',
    zIndex: 1,
    ease: 'power2.inOut'
  });
};

// async function checkIfFavourite() {
//   try {
//     let response = await axios.get('/profile/favourites')
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

let fetchFavourites = async () => {
  if (userId == "NaN") return

  try {
    let { data } = await axios.get(`/favourites?user_id=${userId}`)
    // console.log(data)
    isFavourite.value = data.some(fav => fav.flat_id == route.params.id)
    // console.log(isFavourite.value)
  } catch (error) {
    console.error('Ошибка при получении избранного:', error)
  } finally {
    isLoading.value = false
  }
}

let toggleFavourite = async () => {
  if (userId == "NaN") {
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
    let response = await axios.get(`/flats/${route.params.id}`)
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
  let savedUser = localStorage.getItem('user')
  if (savedUser) {
    user.value = JSON.parse(savedUser)
  }
  // if (isUserAuthenticated()) {
  //   checkIfFavourite()
  // }
})

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

function openContactModal() {
  if (localStorage.getItem('user')) {
    showContactModal.value = true
  } else {
    alert('Авторизуйтесь, прежде чем отправлять нам сообщения!')
  }
}

async function submitContactForm() {
  if (!isAccepted.value) {
    alert("Вы должны принять условия использования!")
    return
  }

  if (message.value.length > 100) {
    alert("Сообщение не должно превышать 100 символов!")
    return
  }

  try {
    await axios.post('/appeals', {
      first_name: user.value.first_name,
      last_name: user.value.last_name,
      phone: user.value.phone,
      email: user.value.email,
      type: 'квартира',
      message: `Свяжитесь со мной по квартире №${flat.value.id}`
    })

    alert('Мы приняли Ваше сообщение! Ожидайте ответа в ближайшее время!')
    message.value = ''
    isAccepted.value = false
    showContactModal.value = false
  } catch (error) {
    console.error(error)
    alert('Ошибка при отправке обращения')
  }
}

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
          <article class="grid grid-cols-3 gap-2">
            <img v-for="(image, index) in flat.images?.slice(1)" :key="index" :src="image" alt="Превью"
              class="w-full aspect-video object-cover rounded-xl" @mouseenter="hoverInImageFlat"
              @mouseleave="hoverOutImageFlat" />
          </article>
        </article>

        <article class="flex flex-col gap-8">
          <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-indigo-900 leading-tight">
            {{ flat.rooms_count }}-к. квартира, {{ flat.square_meters }}м²,
            {{ flat.floor + '/' + flat.floors_in_house }} эт. <br />
            ЖК "{{ flat.housing_complex }}"
          </h2>

          <article class="flex flex-col gap-5">
            <article class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Цена:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(flat.price_current) }} ₽
              </b>
            </article>

            <article class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Цена за м²:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(Math.floor(flat.price_current / flat.square_meters)) }} ₽
              </b>
            </article>

            <article class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Балкон:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ flat.has_balcony ? 'Есть' : 'Нет' }}
              </b>
            </article>

            <article class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Совм. с/у:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ flat.bathroom_combined ? 'Объединены' : 'Раздельный' }}
              </b>
            </article>

            <article class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Тип дома:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ flat.house_type }}
              </b>
            </article>
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
            <button @click="openContactModal"
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
          <article class="flex flex-col gap-4">
            <article>
              <h4 class="text-sm sm:text-base md:text-lg font-semibold mb-1">Цена на старте:</h4>
              <p class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(flat.price_start) }} ₽
              </p>
              <p class="text-xs sm:text-sm text-gray-500">(в момент {{ formatDate(flat.created_at) }})</p>
            </article>

            <article v-if="flat.price_current != flat.price_start">
              <h4 class="text-sm sm:text-base md:text-lg font-semibold mb-1">
                Текущая цена на момент изменения:
              </h4>
              <p class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(flat.price_current) }} ₽
              </p>
              <p class="text-xs sm:text-sm text-gray-500">
                (в момент {{ formatDate(flat.updated_at) }})
              </p>
            </article>
          </article>
        </article>
      </article>
    </article>

    <article v-else class="text-center py-10">
      <p>Квартира не найдена.</p>
    </article>
  </main>
  <teleport to="body">
    <article v-if="showContactModal" class="fixed inset-0 bg-black/50 flex justify-center items-center z-50">
      <article class="bg-white rounded-xl py-8 px-6 w-full max-w-xl relative">
        <button class="absolute top-3 right-4 text-xl font-bold" @click="showContactModal = false">×</button>

        <h2 class="text-2xl font-bold mb-7 text-center text-indigo-900">
          Мы свяжемся с Вами по квартире №{{ flat.id }}
        </h2>

        <article class="flex flex-col gap-4">
          <article class="flex gap-4">
            <input type="text" :value="user.first_name" disabled
              class="w-1/2 p-3 border border-gray-300 rounded-lg bg-gray-100" />
            <input type="text" :value="user.last_name" disabled
              class="w-1/2 p-3 border border-gray-300 rounded-lg bg-gray-100" />
          </article>
          <article class="flex gap-4">
            <input type="text" :value="user.phone" disabled
              class="w-1/2 p-3 border border-gray-300 rounded-lg bg-gray-100" />
            <input type="email" :value="user.email" disabled
              class="w-1/2 p-3 border border-gray-300 rounded-lg bg-gray-100" />
          </article>
          <!-- сообщение опционально -->
          <!--
        <textarea v-model="message" rows="3"
          class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 resize-none"
          placeholder="Дополнительное сообщение (до 100 символов)">
        </textarea>
        -->
          <label class="flex items-start flex-row text-sm">
            <input type="checkbox" v-model="isAccepted" class="mt-1 me-3" />
            Я принимаю <span class="text-orange-600 mx-1 font-medium">условия использования</span> и <span
              class="text-orange-600 mx-1 font-medium">политику конфиденциальности</span>.
          </label>
          <button class="bg-orange-100 text-indigo-900 font-bold mt-5 py-2 rounded-lg hover:bg-orange-200 transition"
            @click="submitContactForm">
            Свяжитесь со мной
          </button>
        </article>
      </article>
    </article>
  </teleport>

  <!-- <ChatModal v-if="showChat" :visible="showChat" :initialMessage="prefilledMessage" @close="showChat = false" /> -->
  <FooterComponent />
</template>
