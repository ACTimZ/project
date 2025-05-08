<script setup>
import { ref, onMounted, watch } from 'vue'
import { useFlatsStore } from '@/stores/flats'
import ChatModal from '../ModalWindows/ChatModal.vue'
import axios from '@/axios'

let props = defineProps({
  filters: Object,
})

// let isModalVisible = ref(false)
let selectedFlat = ref(null)
let flatsStore = useFlatsStore()

let showContactModal = ref(false)
let message = ref('')
let isAccepted = ref(false)
let user = ref({})

watch(
  () => props.filters,
  () => {
    fetchFlats()
  },
  { deep: true }
)

// function openChat(flatData) {
//   selectedFlat.value = flatData
//   isModalVisible.value = true
// }

async function fetchFlats(page = 1) {
  try {
    await flatsStore.fetchFlats(page, props.filters)
  } catch (error) {
    console.error('Ошибка загрузки квартир:', error)
  }
}

function changePage(direction) {
  if (direction === 'next' && flatsStore.currentPage < flatsStore.totalPages) {
    fetchFlats(flatsStore.currentPage + 1)
  } else if (direction === 'prev' && flatsStore.currentPage > 1) {
    fetchFlats(flatsStore.currentPage - 1)
  }
}

onMounted(() => {
  fetchFlats()
  let savedUser = localStorage.getItem('user')
  if (savedUser) {
    user.value = JSON.parse(savedUser)
    console.log(user.value.first_name)
  }
})

function openContactModal(flat) {
  if(localStorage.getItem('user')) {
    selectedFlat.value = flat
    showContactModal.value = true
  } else {
    alert("Авторизуйтесь, прежде чем отправлять нам сообщения!")
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
      message: `Свяжитесь со мной по квартире №${selectedFlat.value.id}`
      // ${message.value}
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

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}
</script>

<template>
  <section class="container mx-auto">
    <article class="flex flex-col mx-15">
      <ChatModal :visible="flatsStore.isModalVisible" :chat-user="{ name: 'Админ' }" :is-admin-view="true"
        @close="flatsStore.isModalVisible = false" :key="flatsStore.selectedFlat?.id"
        @send="(msg) => console.log('Отправлено:', msg)" v-if="flatsStore.selectedFlat"
        :initial-message="`Здравствуйте, хочу связаться с квартирой №${flatsStore.selectedFlat.id}, имеющей ${flatsStore.selectedFlat.square_meters} кв. метров и стоящей ${numberWithSpaces(flatsStore.selectedFlat.price_current)} рублей!`" />

      <article
        class="flex sm:flex-row flex-col sm:items-center items-start sm:justify-between sm:gap-0 gap-1 mt-10 mb-7">
        <h2 class="lg:text-3xl text-xl font-medium">Рекомендуем эти варианты:</h2>
        <article class="flex flex-row items-center gap-3">
          <button class="font-black text-2xl" @click="changePage('prev')" :disabled="flatsStore.currentPage === 1">
            {{ '<' }} </button>
              <p class="flex flex-row items-center gap-3 lg:text-2xl text-lg">
                <b class="font-black lg:text-3xl text-2xl text-indigo-900">{{ flatsStore.currentPage }}</b>
                из
                <b class="font-medium">{{ flatsStore.totalPages }}</b>
              </p>
              <button class="font-black text-2xl" @click="changePage('next')"
                :disabled="flatsStore.currentPage === flatsStore.totalPages">
                {{ '>' }}
              </button>
        </article>
      </article>

      <article class="flex flex-col gap-12.5">
        <article v-for="flat in flatsStore.flats" :key="flat.id"
          class="bg-white flex flex-col md:flex-row rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-lg shadow-indigo-200">
          <article
            class="order-1 md:order-2 w-full md:w-[40%] flex items-center justify-center p-4 bg-white border-5 border-indigo-50 rounded-e-lg">
            <article class="w-full h-64 md:h-full max-h-[400px] overflow-hidden rounded-md">
              <img :src="flat.images?.[0] || '../Images/Another_Example_Flat.jpg'" alt="Квартира"
                class="w-full h-full object-cover object-center" />
            </article>
          </article>
          <article class="order-2 md:order-1 w-full md:w-[60%] p-6 sm:p-8 relative bg-indigo-50 flex flex-col gap-5">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-indigo-900 leading-snug">
              {{ flat.rooms_count }}-к. квартира, {{ flat.square_meters }} м², {{ flat.floor }}/{{
                flat.floors_in_house
              }}
              эт. <br />
              ЖК "{{ flat.housing_complex }}"
            </h2>

            <article>
              <p class="font-bold text-lg sm:text-xl">Цена:</p>
              <p class="font-bold text-2xl sm:text-3xl">
                {{ numberWithSpaces(flat.price_current) }} ₽
              </p>
              <p class="text-sm sm:text-base text-gray-600">
                {{ numberWithSpaces(Math.floor(flat.price_current / flat.square_meters)) }} ₽ за м²
              </p>
            </article>

            <p class="text-sm sm:text-base md:text-lg text-black line-clamp-4">
              {{ flat.description }}
            </p>

            <button @click="openContactModal(flat)"
              class="px-6 py-2 bg-orange-100 text-indigo-900 text-base sm:text-lg font-semibold rounded-md w-fit hover:bg-orange-200 transition cursor-pointer">
              связаться
            </button>

            <router-link :to="`/flat/${flat.id}`" class="absolute bottom-4 right-4 text-sm text-gray-600">
              подробнее →
            </router-link>
          </article>
        </article>
      </article>

      <article class="my-8 flex flex-row justify-center">
        <article class="flex flex-row items-center md:gap-7 gap-3">
          <button class="font-bold text-2xl" @click="changePage('prev')" :disabled="flatsStore.currentPage === 1">
            {{ '<' }} </button>
              <p class="font-medium text-lg">
                Страница {{ flatsStore.currentPage }} из {{ flatsStore.totalPages }}
              </p>
              <button class="font-bold text-2xl" @click="changePage('next')"
                :disabled="flatsStore.currentPage === flatsStore.totalPages">
                {{ '>' }}
              </button>
        </article>
      </article>
    </article>
    <teleport to="body">
      <article v-if="showContactModal" class="fixed inset-0 bg-black/50 flex justify-center items-center z-50">
        <article class="bg-white rounded-xl py-8 px-6 w-full max-w-xl relative">
          <button class="absolute top-3 right-4 text-xl font-bold cursor-pointer" @click="showContactModal = false">×</button>

          <h2 class="text-2xl font-bold mb-7 text-center text-indigo-900">
            Мы свяжемся с Вами по квартире №{{ selectedFlat.id }}
          </h2>

          <article class="flex flex-col gap-4">
            <article class="flex gap-4">
              <input type="text" :value="user.first_name" disabled class="w-1/2 p-3 border border-gray-300 rounded-lg bg-gray-100" />
              <input type="text" :value="user.last_name" disabled class="w-1/2 p-3 border border-gray-300 rounded-lg bg-gray-100" />
            </article>
            <article class="flex gap-4">
              <input type="text" :value="user.phone" disabled class="w-1/2 p-3 border border-gray-300 rounded-lg bg-gray-100" />
              <input type="email" :value="user.email" disabled class="w-1/2 p-3 border border-gray-300 rounded-lg bg-gray-100" />
            </article>
            <!-- <article class="relative">
              <textarea v-model="message" rows="3"
                class="w-12/12 p-3 border border-gray-300 rounded-lg bg-gray-50 resize-none outline-none focus:border-gray-800"
                placeholder="Что вы хотите сообщить? (до 100 символов)">
          </textarea>
              <p class="text-sm text-right absolute bottom-2.5 right-2.5" :class="[message.length > 100 ? 'text-red-600' : 'text-gray-500']">
                {{ message.length }}/100
              </p>
            </article> -->
            <label class="flex items-start flex-row text-sm ">
              <input type="checkbox" v-model="isAccepted" class="mt-1 me-3" />
              Я принимаю <span class="text-orange-600 mx-1 font-medium">условия использования</span> и <span class="text-orange-600 mx-1 font-medium">политику конфиденциальности</span>.
            </label>
            <button class="bg-orange-100 text-indigo-900 font-bold mt-5 py-2 rounded-lg hover:bg-orange-200 transition cursor-pointer"
              @click="submitContactForm">
              Свяжитесь со мной
            </button>
          </article>
        </article>
      </article>
    </teleport>

  </section>
</template>
