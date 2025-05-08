<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/axios'
import { useRouter } from 'vue-router'
// import ChatModal from '../ModalWindows/ChatModal.vue'
import gsap from 'gsap'

let router = useRouter()
let isLoading = ref(true)
// let isModalVisible = ref(false)
let selectedFlat = ref(null)
let favourites = ref([])
let isAuthenticated = ref(true)

let showContactModal = ref(false)
let message = ref('')
let isAccepted = ref(false)
let user = ref({})

// let userId = JSON.parse(localStorage.getItem('user')).id
let userId = null
try {
  let user = JSON.parse(localStorage.getItem('user') || 'null')
  userId = user?.id ?? null
  if (!userId) isAuthenticated.value = false
} catch {
  isAuthenticated.value = false
}

let hoverIn = (e) => {
  gsap.to(e.currentTarget, { duration: 0.4, scale: 1.01, y: -5 })
}
let hoverOut = (e) => {
  gsap.to(e.currentTarget, { duration: 0.4, scale: 1, y: 0 })
}

// function openChat(flatData) {
//   selectedFlat.value = flatData
//   isModalVisible.value = true
// }

function openContactModal(flatData) {
  if (localStorage.getItem('user')) {
    selectedFlat.value = flatData
    showContactModal.value = true
  } else {
    alert('Авторизуйтесь, прежде чем отправлять нам сообщения!')
  }
}

async function submitContactForm() {
  if (!isAccepted.value) {
    alert("Вы должны принять условия использования.")
    return
  }

  if (message.value.length > 100) {
    alert("Сообщение не должно превышать 100 символов.")
    return
  }

  try {
    await axios.post('/appeals', {
      first_name: user.value.first_name,
      last_name: user.value.last_name,
      phone: user.value.phone,
      email: user.value.email,
      type: 'квартира',
      message: `Свяжитесь со мной по квартире №${selectedFlat.value?.id}`
    })

    alert('Мы приняли Ваше сообщение! Ожидайте ответа в ближайшее время!')
    message.value = ''
    isAccepted.value = false
    showContactModal.value = false
  } catch (error) {
    console.error(error)
    alert('Ошибка при отправке обращения.')
  }
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
  if (isAuthenticated.value) fetchFavourites()
  let savedUser = localStorage.getItem('user')
  if (savedUser) {
    user.value = JSON.parse(savedUser)
  }
  // deleteCard()
})

function goBack() {
  router.back()
}

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}
</script>

<template>
  <section class="container mx-auto relative mb-15">
    <article v-if="!isAuthenticated" class="text-center mt-25 mb-40 text-2xl font-semibold">
      Сначала авторизуйтесь, чтобы просматривать избранное!
    </article>

    <template v-else>
      <teleport to="body">
        <article v-if="showContactModal" class="fixed inset-0 bg-black/50 flex justify-center items-center z-50">
          <article class="bg-white rounded-xl py-8 px-6 w-full max-w-xl relative">
            <button class="absolute top-3 right-4 text-xl font-bold cursor-pointer" @click="showContactModal = false">×</button>

            <h2 class="text-2xl font-bold mb-7 text-center text-indigo-900">
              Мы свяжемся с Вами по квартире №{{ selectedFlat?.id }}
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
              <button
                class="bg-orange-100 text-indigo-900 font-bold mt-5 py-2 rounded-lg hover:bg-orange-200 transition cursor-pointer"
                @click="submitContactForm">
                Свяжитесь со мной
              </button>
            </article>
          </article>
        </article>
      </teleport>
      <!-- <ChatModal :visible="isModalVisible" :chat-user="{ name: 'Админ' }" :is-admin-view="true"
        @close="isModalVisible = false" :key="selectedFlat?.id" @send="(msg) => console.log('Отправлено:', msg)"
        v-if="selectedFlat"
        :initial-message="`Здравствуйте, хочу связаться с квартирой №${selectedFlat.id}, имеющей ${selectedFlat.square_meters} кв. метров и стоящей ${selectedFlat.price_current} рублей!`" /> -->

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

          <article v-else-if="favourites.length === 0"
            class="text-center my-10 text-xl flex flex-col items-center gap-5">
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
                    {{ numberWithSpaces(item_flat.flat.price_current) }} ₽
                  </p>
                  <p class="text-sm sm:text-base text-gray-600">
                    {{ numberWithSpaces((item_flat.flat.price_current / item_flat.flat.square_meters).toFixed(2)) }} ₽
                    за м²
                  </p>
                </article>
              </article>

              <p class="text-sm sm:text-base md:text-lg text-black line-clamp-4">
                {{ item_flat.flat.description }}
              </p>

              <button @click="openContactModal(item_flat.flat)"
                class="px-6 py-2 bg-orange-100 text-indigo-900 text-base sm:text-lg font-semibold rounded-md w-fit hover:bg-orange-200 transition cursor-pointer">
                связаться
              </button>


              <router-link :to="`/flat/${item_flat.flat.id}`" class="absolute bottom-4 right-4 text-sm text-gray-600">
                подробнее →
              </router-link>
            </article>
          </article>
        </article>
      </article>

    </template>
  </section>
</template>
