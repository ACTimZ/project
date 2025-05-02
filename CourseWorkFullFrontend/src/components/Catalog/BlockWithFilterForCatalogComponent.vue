<template>
  <article class="relative bg-sky-50">
    <article class="container mx-auto">
      <article ref="panelRef" :style="{ maxHeight: maxHeight + 'px' }"
        class="overflow-hidden transition-[max-height] duration-700 ease-in-out flex flex-col gap-5 xl:mx-45 lg:mx-25 mx-5 md:pb-10 md:pt-3 pt-1 pb-3.5">
        <h4 class="text-2xl font-medium">Фильтры</h4>

        <form @submit.prevent="applyFilters" class="flex flex-col gap-5">
          <article class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            <input v-model="filters.rooms_count" type="number" placeholder="Количество комнат"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white" />
            <input v-model="filters.floor" type="number" placeholder="Какой этаж"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white" />
            <input v-model="filters.housing_complex" type="text" placeholder="Какой ЖК"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white" />
            <input v-model="filters.house_type" type="text" placeholder="Тип дома"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white" />
            <input v-model="filters.price_min" type="number" placeholder="Цена от"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white" />
            <input v-model="filters.price_max" type="number" placeholder="Цена до"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white" />
            <input v-model="filters.price_per_m2_min" type="number" placeholder="Цена за м² от"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white" />
            <input v-model="filters.price_per_m2_max" type="number" placeholder="Цена за м² до"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white" />

            <label class="flex items-center gap-2 text-sm xl:text-md col-span-1">
              <input v-model="filters.bathroom_combined" type="checkbox" /> Совмещенный санузел
            </label>
            <label class="flex items-center gap-2 text-sm xl:text-md col-span-1">
              <input v-model="filters.has_balcony" type="checkbox" /> С балконом
            </label>
          </article>

          <button type="submit"
            class="xl:self-end self-center font-medium rounded-lg lg:text-xl text-base px-7 pb-3 pt-2.5 bg-indigo-900 text-white">
            применить
          </button>
        </form>

        <button @click="toggleCollapse" class="absolute bottom-1.5 right-5 font-medium text-gray-600 hidden xl:block">
          {{ isCollapsed ? 'развернуть' : 'свернуть' }}
        </button>
        <button @click="toggleCollapse"
          class="absolute bottom-1.5 right-5 font-medium text-gray-600 text-3xl block xl:hidden">
          {{ isCollapsed ? '˅' : '^' }}
        </button>
      </article>
    </article>
  </article>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'

const emit = defineEmits(['apply-filters'])

const isCollapsed = ref(false)
const panelRef = ref(null)
const maxHeight = ref(0)

const filters = ref({
  rooms_count: null,
  floor: null,
  housing_complex: '',
  house_type: '',
  price_min: null,
  price_max: null,
  price_per_m2_min: null,
  price_per_m2_max: null,
  bathroom_combined: false,
  has_balcony: false,
})

function applyFilters() {
  emit('apply-filters', filters.value)
}

const updateMaxHeight = async () => {
  await nextTick()
  if (panelRef.value) {
    if (isCollapsed.value) {
      maxHeight.value = 0
    } else {
      maxHeight.value = panelRef.value.scrollHeight
    }
  }
}

const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value
  updateMaxHeight()
}

onMounted(() => {
  updateMaxHeight()
  window.addEventListener('resize', updateMaxHeight)
})
</script>
