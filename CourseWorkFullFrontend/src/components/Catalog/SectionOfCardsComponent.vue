<script setup>
import { ref, onMounted, watch } from 'vue'
import { useFlatsStore } from '@/stores/flats'
import ChatModal from '../ModalWindows/ChatModal.vue'

const props = defineProps({
  filters: Object,
})

const isModalVisible = ref(false)
const selectedFlat = ref(null)
const flatsStore = useFlatsStore()

watch(
  () => props.filters,
  () => {
    fetchFlats()
  },
  { deep: true }
)

function openChat(flatData) {
  selectedFlat.value = flatData
  isModalVisible.value = true
}

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
})

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}
</script>

<template>
  <section class="container mx-auto">
    <article class="flex flex-col mx-15">
      <ChatModal
        :visible="flatsStore.isModalVisible"
        :chat-user="{ name: 'Админ' }"
        :is-admin-view="true"
        @close="flatsStore.isModalVisible = false"
        :key="flatsStore.selectedFlat?.id"
        @send="(msg) => console.log('Отправлено:', msg)"
        v-if="flatsStore.selectedFlat"
        :initial-message="`Здравствуйте, хочу связаться с квартирой №${flatsStore.selectedFlat.id}, имеющей ${flatsStore.selectedFlat.square_meters} кв. метров и стоящей ${numberWithSpaces(flatsStore.selectedFlat.price_current)} рублей!`"
      />

      <article
        class="flex sm:flex-row flex-col sm:items-center items-start sm:justify-between sm:gap-0 gap-1 mt-10 mb-7"
      >
        <h2 class="lg:text-3xl text-xl font-medium">Рекомендуем эти варианты:</h2>
        <article class="flex flex-row items-center gap-3">
          <button
            class="font-black text-2xl"
            @click="changePage('prev')"
            :disabled="flatsStore.currentPage === 1"
          >
            {{ '<' }}
          </button>
          <p class="flex flex-row items-center gap-3 lg:text-2xl text-lg">
            <b class="font-black lg:text-3xl text-2xl text-indigo-900">{{ flatsStore.currentPage }}</b>
            из
            <b class="font-medium">{{ flatsStore.totalPages }}</b>
          </p>
          <button
            class="font-black text-2xl"
            @click="changePage('next')"
            :disabled="flatsStore.currentPage === flatsStore.totalPages"
          >
            {{ '>' }}
          </button>
        </article>
      </article>

      <article class="flex flex-col gap-12.5">
        <article
          v-for="flat in flatsStore.flats"
          :key="flat.id"
          class="bg-white flex flex-col md:flex-row rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-lg shadow-indigo-200"
        >
          <article
            class="order-1 md:order-2 w-full md:w-[40%] flex items-center justify-center p-4 bg-white border-5 border-indigo-50 rounded-e-lg"
          >
            <article class="w-full h-64 md:h-full max-h-[400px] overflow-hidden rounded-md">
              <img
                :src="flat.images?.[0] || '../Images/Another_Example_Flat.jpg'"
                alt="Квартира"
                class="w-full h-full object-cover object-center"
              />
            </article>
          </article>
          <article
            class="order-2 md:order-1 w-full md:w-[60%] p-6 sm:p-8 relative bg-indigo-50 flex flex-col gap-5"
          >
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

            <button
              @click="openChat(flat)"
              class="px-6 py-2 bg-orange-100 text-indigo-900 text-base sm:text-lg font-semibold rounded-md w-fit"
            >
              связаться
            </button>

            <router-link
              :to="`/flat/${flat.id}`"
              class="absolute bottom-4 right-4 text-sm text-gray-600"
            >
              подробнее →
            </router-link>
          </article>
        </article>
      </article>

      <article class="my-8 flex flex-row justify-center">
        <article class="flex flex-row items-center md:gap-7 gap-3">
          <button
            class="font-bold text-2xl"
            @click="changePage('prev')"
            :disabled="flatsStore.currentPage === 1"
          >
            {{ '<' }}
          </button>
          <p class="font-medium text-lg">
            Страница {{ flatsStore.currentPage }} из {{ flatsStore.totalPages }}
          </p>
          <button
            class="font-bold text-2xl"
            @click="changePage('next')"
            :disabled="flatsStore.currentPage === flatsStore.totalPages"
          >
            {{ '>' }}
          </button>
        </article>
      </article>
    </article>
  </section>
</template>
