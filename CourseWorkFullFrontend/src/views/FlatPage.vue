<!-- <script setup>
import { ref } from 'vue'
let flat = ref({
  id: 1,
  count_rooms: 1,
  kv_meters: 32,
  floor: 2,
  sum_floor_in_house: 6,
  housing_complex: 'Нирванна',
  price: 100000000,
  date_start_price: '12.12.2000',
  new_price: 100000,
  date_redact_price: '13.12.2001',
  hasBalcon: true,
  sovmSU: true,
  material_house: 'Кирпичный',
  description:
    'Уютная 1-комнатная квартира ждет вас в ЖК «Нирвана»! Площадь 32 м², 2 этаж из 6. Идеальный вариант для комфортного проживания в современном жилом комплексе. Узнайте больше о преимуществах этого предложения!',
})

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}
</script>

<template>
  <section class="container mx-auto mt-10 mb-15">
    <article class="mx-25 flex flex-col gap-15">
      <article class="grid grid-cols-2 gap-x-30">
        <article class="flex flex-col gap-4 w-full">
          <img
            src="../components/Images/FlatExample/Example_Flat.png"
            alt="Главное фото"
            class="w-full aspect-video object-cover rounded-lg"
          />
          <article class="grid grid-cols-3 gap-2">
            <img
              src="../components/Images/FlatExample/Flat_example2.jpg"
              alt="Превью 1"
              class="w-full aspect-video object-cover rounded-lg"
            />
            <img
              src="../components/Images/FlatExample/Flat_example3.jpg"
              alt="Превью 2"
              class="w-full aspect-video object-cover rounded-lg"
            />
            <img
              src="../components/Images/FlatExample/Flat_example4.jpg"
              alt="Превью 3"
              class="w-full aspect-video object-cover rounded-lg"
            />
          </article>
        </article>
        <article class="mt-5 flex flex-col gap-7.5">
          <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-indigo-900 leading-snug">
            {{ flat.count_rooms }}-к. квартира, {{ flat.kv_meters }}м²,
            {{ flat.floor + '/' + flat.sum_floor_in_house }} эт. <br />
            ЖК {{ flat.housing_complex }}
          </h2>
          <article class="flex flex-col gap-4.5">
            <article class="flex flex-row items-end gap-5">
              <p class="sm:text-xl text-base">Цена:</p>
              <b class="font-bold text-lg sm:text-2xl">{{ numberWithSpaces(flat.new_price) }} ₽</b>
            </article>
            <article class="flex flex-row items-end gap-5">
              <p class="sm:text-xl text-base">Цена за м²:</p>
              <b class="font-bold text-lg sm:text-2xl"
                >{{ numberWithSpaces(Math.floor(flat.new_price / flat.kv_meters)) }} ₽</b
              >
            </article>
            <article class="flex flex-row items-end gap-5">
              <p class="sm:text-xl text-base">Балкон:</p>
              <b class="font-bold text-lg sm:text-2xl">{{ flat.hasBalcon ? 'Есть' : 'Нет' }}</b>
            </article>
            <article class="flex flex-row items-end gap-5">
              <p class="sm:text-xl text-base">Совм. с/у:</p>
              <b class="font-bold text-lg sm:text-2xl">{{
                flat.sovmSU ? 'Объединены' : 'Раздельный'
              }}</b>
            </article>
            <article class="flex flex-row items-end gap-5">
              <p class="sm:text-xl text-base">Тип дома:</p>
              <b class="font-bold text-lg sm:text-2xl">{{ flat.material_house }}</b>
            </article>
          </article>
          <article class="flex flex-row gap-7.5">
            <button
              class="flex flex-row items-center cursor-pointer border-2 border-rose-800 px-4 gap-3 rounded-lg font-bold text-rose-800 hover:bg-rose-800 hover:text-white transition delay-50 duration-300"
            >
              В избранное
              <svg fill="white" width="32" height="30">
                <path
                  d="M31 8.70762C31 10.7107 30.1731 12.5614 28.8163 13.9331L15.9894 29L3.54417 14.325C1.97527 12.9098 1 10.9285 1 8.70762C1 4.4619 4.60424 1 9.05654 1C11.9399 1 14.4629 2.45879 15.8834 4.63608C17.3251 2.45879 19.8905 1 22.8163 1C27.3322 1 31 4.4619 31 8.70762Z"
                  stroke="#AA1A70"
                  stroke-width="2"
                  stroke-miterlimit="10"
                />
              </svg>
            </button>
            <button
              class="cursor-pointer border-2 border-orange-100 bg-orange-100 p-4 gap-3 rounded-lg font-bold text-orange-950 hover:bg-orange-200 transition duration-300"
            >
              Связаться
            </button>
          </article>
        </article>
      </article>
      <article class="grid grid-cols-2 gap-x-30">
        <article class="flex flex-col gap-1">
          <h3 class="text-xl sm:text-2xl md:text-3xl font-bold leading-snug">Описание</h3>
          <p>{{ flat.description }}</p>
        </article>
        <article class="flex flex-col gap-1">
          <h3 class="text-xl sm:text-2xl md:text-3xl font-bold leading-snug">Изменение цены</h3>
          <article class="flex flex-col gap-7.5">
            <article class="flex flex-col">
              <h4 class="text-base sm:text-lg md:text-xl font-bold leading-snug mb-1">
                Цена на старте:
              </h4>
              <p class="text-xl sm:text-2xl md:text-3xl font-bold leading-snug">
                {{ numberWithSpaces(flat.price) }} ₽
              </p>
              <p class="md:text-lg text-base text-gray-500">
                (в момент {{ flat.date_start_price }})
              </p>
            </article>
            <article
              class="flex-col"
              :class="[flat.new_price && flat.date_redact_price ? 'flex' : 'hidden']"
            >
              <h4 class="text-base sm:text-lg md:text-xl font-bold leading-snug mb-1">
                Текущая цена на момент изменения:
              </h4>
              <p class="text-xl sm:text-2xl md:text-3xl font-bold leading-snug">
                {{ numberWithSpaces(flat.new_price) }} ₽
              </p>
              <p class="md:text-lg text-base text-gray-500">
                (в момент {{ flat.date_redact_price }})
              </p>
            </article>
          </article>
        </article>
      </article>
    </article>
  </section>
</template> -->
<script setup>
import HeaderComponent from '@/components/Header/HeaderComponent.vue'
import FooterComponent from '@/components/Footer/FooterComponent.vue'
import ChatModal from '@/components/ModalWindows/ChatModal.vue'
import { useRouter } from 'vue-router'
import { ref } from 'vue'
let flat = ref({
  id: 1,
  count_rooms: 1,
  kv_meters: 32,
  floor: 2,
  sum_floor_in_house: 6,
  housing_complex: 'Нирванна',
  price: 100000000,
  date_start_price: '12.12.2000',
  new_price: 100000,
  date_redact_price: '13.12.2001',
  hasBalcon: true,
  sovmSU: true,
  material_house: 'Кирпичный',
  description:
    'Уютная 1-комнатная квартира ждет вас в ЖК «Нирвана»! Площадь 32 м², 2 этаж из 6. Идеальный вариант для комфортного проживания в современном жилом комплексе. Узнайте больше о преимуществах этого предложения!',
})

let showChat = ref(false)
let prefilledMessage = ref('')

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}

let isFavourite = ref(false)

function toggleFavourite() {
  isFavourite.value = !isFavourite.value
}

let router = useRouter()

function goBack() {
  router.back()
}

function openChatWithPrefilledMessage() {
  prefilledMessage.value = `Здравствуйте! Хочу узнать подробнее о квартире №${flat.value.id} (${flat.value.kv_meters}м²) стоимостью ${numberWithSpaces(flat.value.new_price)} ₽.`
  showChat.value = true
}
</script>

<template>
  <HeaderComponent />
  <main class="container mx-auto mt-10 mb-20 px-4 sm:px-6 lg:px-8 relative">
    <article class="absolute top-[-25px] left-[-1%]">
      <button
        @click="goBack"
        class="bg-indigo-900 text-white font-bold px-5 py-3 rounded-xl hover:bg-indigo-800 transition duration-150 cursor-pointer"
      >
        {{ '<' }} Назад
      </button>
    </article>
    <article class="flex flex-col md:gap-15 gap-8">
      <article class="grid grid-cols-1 lg:grid-cols-2 lg:gap-x-30 gap-8">
        <article class="flex flex-col gap-4 w-full">
          <img
            src="../components/Images/FlatExample/Example_Flat.png"
            alt="Главное фото"
            class="w-full aspect-video object-cover rounded-xl"
          />
          <div class="grid grid-cols-3 gap-2">
            <img
              src="../components/Images/FlatExample/Flat_example2.jpg"
              alt="Превью 1"
              class="w-full aspect-video object-cover rounded-xl"
            />
            <img
              src="../components/Images/FlatExample/Flat_example3.jpg"
              alt="Превью 2"
              class="w-full aspect-video object-cover rounded-xl"
            />
            <img
              src="../components/Images/FlatExample/Flat_example4.jpg"
              alt="Превью 3"
              class="w-full aspect-video object-cover rounded-xl"
            />
          </div>
        </article>

        <article class="flex flex-col gap-8">
          <h2
            class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-indigo-900 leading-tight"
          >
            {{ flat.count_rooms }}-к. квартира, {{ flat.kv_meters }}м²,
            {{ flat.floor + '/' + flat.sum_floor_in_house }} эт. <br />
            ЖК {{ flat.housing_complex }}
          </h2>

          <article class="flex flex-col gap-5">
            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Цена:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(flat.new_price) }} ₽
              </b>
            </div>

            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Цена за м²:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(Math.floor(flat.new_price / flat.kv_meters)) }} ₽
              </b>
            </div>

            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Балкон:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ flat.hasBalcon ? 'Есть' : 'Нет' }}
              </b>
            </div>

            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Совм. с/у:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ flat.sovmSU ? 'Объединены' : 'Раздельный' }}
              </b>
            </div>

            <div class="flex flex-row items-end gap-4">
              <p class="text-sm sm:text-base md:text-lg lg:text-xl">Тип дома:</p>
              <b class="text-base sm:text-xl md:text-2xl font-bold">
                {{ flat.material_house }}
              </b>
            </div>
          </article>

          <article class="flex flex-col sm:flex-row gap-4">
            <button
              @click="toggleFavourite"
              :class="[
                'cursor-pointer flex items-center justify-center gap-3 border-2 px-5 py-2 rounded-lg font-bold transition duration-300',
                isFavourite
                  ? 'bg-rose-800 text-white border-rose-800'
                  : 'text-rose-800 border-rose-800 hover:bg-rose-100',
              ]"
            >
              {{ isFavourite ? 'В избранном' : 'Добавить в избранное' }}
              <svg
                fill="white"
                width="28"
                height="28"
                viewBox="0 0 32 30"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M31 8.70762C31 10.7107 30.1731 12.5614 28.8163 13.9331L15.9894 29L3.54417 14.325C1.97527 12.9098 1 10.9285 1 8.70762C1 4.4619 4.60424 1 9.05654 1C11.9399 1 14.4629 2.45879 15.8834 4.63608C17.3251 2.45879 19.8905 1 22.8163 1C27.3322 1 31 4.4619 31 8.70762Z"
                  stroke="#a50036"
                  stroke-width="2"
                  stroke-miterlimit="10"
                />
              </svg>
            </button>
            <button
              @click="openChatWithPrefilledMessage"
              class="cursor-pointer border-2 border-orange-200 bg-orange-100 px-5 py-2 rounded-lg font-bold text-orange-900 hover:bg-orange-200 transition duration-300"
            >
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
                {{ numberWithSpaces(flat.price) }} ₽
              </p>
              <p class="text-xs sm:text-sm text-gray-500">(в момент {{ flat.date_start_price }})</p>
            </div>

            <div v-if="flat.new_price && flat.date_redact_price">
              <h4 class="text-sm sm:text-base md:text-lg font-semibold mb-1">
                Текущая цена на момент изменения:
              </h4>
              <p class="text-base sm:text-xl md:text-2xl font-bold">
                {{ numberWithSpaces(flat.new_price) }} ₽
              </p>
              <p class="text-xs sm:text-sm text-gray-500">
                (в момент {{ flat.date_redact_price }})
              </p>
            </div>
          </div>
        </article>
      </article>
    </article>
  </main>
  <ChatModal
    v-if="showChat"
    :visible="showChat"
    :initialMessage="prefilledMessage"
    @close="showChat = false"
  />

  <FooterComponent />
</template>
