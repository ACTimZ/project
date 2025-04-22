<script setup>
import { ref } from 'vue'
import ChatModal from '../ModalWindows/ChatModal.vue'

const isModalVisible = ref(false)
const selectedFlat = ref(null)
const count_page = ref(1)
let list = ref(5)

function openChat(flatData) {
  selectedFlat.value = flatData
  isModalVisible.value = true
}

let flat = {
  id: 1,
  count_rooms: 1,
  kv_meters: 32,
  floor: 2,
  sum_floor_in_house: 6,
  housing_complex: 'Нирванна',
  price: 100000000,
  description:
    'Уютная 1-комнатная квартира ждет вас в ЖК «Нирвана»! Площадь 32 м², 2 этаж из 6. Идеальный вариант для комфортного проживания в современном жилом комплексе. Узнайте больше о преимуществах этого предложения!',
}

const isFavourite = ref(false)

function toggleFavourite() {
  isFavourite.value = !isFavourite.value
}

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}
</script>
<template>
  <section class="container mx-auto">
    <article class="flex flex-col mx-15">
      <ChatModal
        :visible="isModalVisible"
        :chat-user="{ name: 'Админ' }"
        :is-admin-view="true"
        @close="isModalVisible = false"
        :key="selectedFlat?.id"
        @send="(msg) => console.log('Отправлено:', msg)"
        v-if="selectedFlat"
        :initial-message="`Здравствуйте, хочу связаться с квартирой №${selectedFlat.id}, имеющая ${selectedFlat.kv_meters} кв. метров и стоящая ${numberWithSpaces(selectedFlat.price)} рублей!`"
      />

      <!-- пагинация сверху -->
      <article
        class="flex sm:flex-row flex-col sm:items-center items-start sm:justify-between sm:gap-0 gap-1 mt-10 mb-7"
      >
        <h2 class="lg:text-3xl text-xl font-medium">Рекомендуем эти варианты:</h2>
        <article class="flex flex-row items-center gap-3">
          <button class="font-black text-2xl" @click="count_page--">{{ '<' }}</button>
          <p class="flex flex-row items-center gap-3 lg:text-2xl text-lg">
            <b class="font-black lg:text-3xl text-2xl text-indigo-900">{{ count_page }}</b>
            из
            <b class="font-medium">999</b>
          </p>
          <button class="font-black text-2xl" @click="count_page++">{{ '>' }}</button>
        </article>
      </article>

      <!-- Каталог -->
      <article class="flex flex-col gap-12.5">
        <article
          v-for="i in list"
          :key="i"
          class="bg-white flex flex-col md:flex-row rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-lg shadow-indigo-200"
        >
          <article
            class="order-1 md:order-2 w-full md:w-[40%] flex items-center justify-center p-4 bg-white border-5 border-indigo-50 rounded-e-lg"
          >
            <article class="w-full h-64 md:h-full max-h-[400px] overflow-hidden rounded-md">
              <img
                src="../Images/Another_Example_Flat.jpg"
                alt="Квартира"
                class="w-full h-full object-cover object-center"
              />
            </article>
          </article>
          <article
            class="order-2 md:order-1 w-full md:w-[60%] p-6 sm:p-8 relative bg-indigo-50 flex flex-col gap-5"
          >
            <button
              @click="toggleFavourite"
              class="absolute top-4 right-4 cursor-pointer"
              aria-label="Добавить в избранное"
            >
              <svg
                viewBox="0 0 27 26"
                xmlns="http://www.w3.org/2000/svg"
                class="w-8 h-8 transition-colors duration-300"
                :fill="isFavourite ? '#AA1A70' : 'none'"
              >
                <path
                  d="M25.6417 7.38294C25.6417 9.01184 24.9724 10.5168 23.8741 11.6322L13.4912 23.8844L3.41732 11.9509C2.14735 10.8001 1.35791 9.18889 1.35791 7.38294C1.35791 3.93039 4.2754 1.11523 7.87936 1.11523C10.2134 1.11523 12.2556 2.3015 13.4054 4.07203C14.5724 2.3015 16.649 1.11523 19.0173 1.11523C22.6728 1.11523 25.6417 3.93039 25.6417 7.38294Z"
                  stroke="#AA1A70"
                  stroke-miterlimit="10"
                />
              </svg>
            </button>

            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-indigo-900 leading-snug">
              {{ flat.count_rooms }}-к. квартира, {{ flat.kv_meters }} м², {{ flat.floor }}/{{
                flat.sum_floor_in_house
              }}
              эт. <br />
              ЖК "{{ flat.housing_complex }}"
            </h2>

            <article>
              <p class="font-bold text-lg sm:text-xl">Цена:</p>
              <p class="font-bold text-2xl sm:text-3xl">{{ numberWithSpaces(flat.price) }} ₽</p>
              <p class="text-sm sm:text-base text-gray-600">
                {{ numberWithSpaces(Math.floor(flat.price / flat.kv_meters)) }} ₽ за м²
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

            <router-link to="/flat" class="absolute bottom-4 right-4 text-sm text-gray-600">
              подробнее →
            </router-link>
          </article>
        </article>
      </article>

      <!-- Пагинация снизу -->
      <article class="my-8 flex flex-row justify-center">
        <article class="flex flex-row items-center md:gap-7 gap-3">
          <article class="font-bold flex flex-row items-center gap-3 text-2xl">
            <button>{{ '<<' }}</button>
            <button>{{ '<' }}</button>
          </article>
          <article class="flex flex-row items-center md:gap-3 gap-1.5 md:text-2xl text-lg">
            <article class="sm:flex flex-row items-center hidden">
              {{ 1 }}
              ...
              {{ '3 4 5' }}
            </article>
            <b class="md:text-3xl sm:text-xl text-3xl font-black text-indigo-900">{{ 6 }}</b>
            <article class="sm:flex flex-row items-center hidden">
              {{ '7 8 9' }}
              ...
              {{ 15 }}
            </article>
          </article>
          <article class="font-bold flex flex-row items-center gap-3 text-2xl">
            <button>{{ '>' }}</button>
            <button>{{ '>>' }}</button>
          </article>
        </article>
      </article>
    </article>
  </section>
</template>
