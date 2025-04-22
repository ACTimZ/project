<script setup>
import { useRouter } from 'vue-router'
import { ref, onMounted, computed } from 'vue'
import { gsap } from 'gsap'
import ChatModal from '../ModalWindows/ChatModal.vue'

let priceChange = computed(() => {
  let diff = flat.new_price - flat.price
  return {
    diff: Math.abs(diff),
    isIncrease: diff > 0,
    isDecrease: diff < 0,
    text:
      diff === 0
        ? null
        : `Цена ${diff > 0 ? 'увеличилась' : 'уменьшилась'} на: ${numberWithSpaces(Math.abs(diff))} ₽`,
  }
})

const isModalVisible = ref(false)
const selectedFlat = ref(null)

function openChat(flatData) {
  selectedFlat.value = flatData
  isModalVisible.value = true
}

onMounted(() => {
  let btn_load_more = document.getElementById('load_more')

  btn_load_more.addEventListener('mousemove', () => {
    gsap.to(btn_load_more, {
      scale: 1.1,
    })
  })

  btn_load_more.addEventListener('mouseleave', () => {
    gsap.to(btn_load_more, {
      scale: 1,
    })
  })

  let card = document.querySelectorAll('.catalog-card')

  card.forEach((element) => {
    element.addEventListener('mousemove', () => {
      gsap.to(element, {
        scale: 1.01,
      })
    })

    element.addEventListener('mouseleave', () => {
      gsap.to(element, {
        scale: 1,
      })
    })
  })
})

let list = ref(5)

let flat = {
  id: 1,
  count_rooms: 1,
  kv_meters: 32,
  floor: 2,
  sum_floor_in_house: 6,
  housing_complex: 'Нирванна',
  price: 100000,
  new_price: 100000,
  description:
    'Уютная 1-комнатная квартира ждет вас в ЖК «Нирвана»! Площадь 32 м², 2 этаж из 6. Идеальный вариант для комфортного проживания в современном жилом комплексе. Узнайте больше о преимуществах этого предложения!',
}
function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}

let router = useRouter()

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
      :initial-message="`Здравствуйте, хочу связаться с квартирой №${selectedFlat.id}, имеющей ${selectedFlat.kv_meters} кв. метров и стоящей ${numberWithSpaces(selectedFlat.price)} рублей!`"
    />
    <!-- asd -->
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

      <!-- Каталог -->
      <article class="flex flex-col gap-12.5">
        <article
          v-for="i in list"
          :key="i"
          class="bg-white flex flex-col md:flex-row rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-lg shadow-indigo-200 catalog-card"
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

            <!-- <article>
              <p class="font-bold text-lg sm:text-xl">Цена:</p>
              <p class="font-bold text-2xl sm:text-3xl">{{ numberWithSpaces(flat.new_price) }} ₽</p>
              <p class="text-sm sm:text-base text-gray-600">
                {{ numberWithSpaces(Math.floor(flat.new_price / flat.kv_meters)) }} ₽ за м²
              </p>
            </article> -->
            <article class="flex flex-col sm:flex-row sm:items-center sm:gap-4">
              <article>
                <p class="font-bold text-lg sm:text-xl">Цена:</p>
                <p class="font-bold text-2xl sm:text-3xl">
                  {{ numberWithSpaces(flat.new_price) }} ₽
                </p>
                <p class="text-sm sm:text-base text-gray-600">
                  {{ numberWithSpaces(Math.floor(flat.new_price / flat.kv_meters)) }} ₽ за м²
                </p>
              </article>

              <article
                v-if="priceChange.text"
                :class="[
                  'mt-3 sm:mt-0 sm:ml-2 px-3 py-2 rounded-md text-white text-sm sm:text-base w-fit',
                  priceChange.isIncrease ? 'bg-green-500' : 'bg-red-500',
                ]"
              >
                {{ priceChange.text }}
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

      <article class="my-10 flex flex-row justify-center">
        <a href="" class="lg:text-2xl text-xl font-medium" id="load_more">Прогрузить еще</a>
      </article>
    </article>
  </section>
</template>
