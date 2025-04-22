<!-- <template>
  <article class="relative bg-amber-100">
    <article class="container mx-auto">
      <article class="flex flex-col gap-5 relative bg-amber-50 xl:mx-45 lg:mx-25 mx-5 md:py-10 pt-1 pb-3.5">
        <h4 class="text-2xl font-medium">Фильтры</h4>
        <form action="" class="flex flex-col gap-5">
          <article class="flex flex-col gap-4">
            <article class="flex flex-row items-center xl:gap-4 gap-2.5">
              <input
                type="number"
                placeholder="Количество комнат"
                class="w-4/12 text-xs md:text-sm border-1 border-gray-300 rounded-xl bg-gray-50 p-3.5 xl:text-md focus:outline-none focus:border-gray-500 focus:bg-white"
              />
              <input
                type="number"
                placeholder="Какой этаж"
                class="w-4/12 text-xs md:text-sm border-1 border-gray-300 rounded-xl bg-gray-50 p-3.5 xl:text-md focus:outline-none focus:border-gray-500 focus:bg-white"
              />
              <article
                class="flex flex-row items-center justify-start gap-2.5 w-60 xl:text-md text-sm"
              >
                <input type="checkbox" name="" id="InputWithBalkon" class="" />
                <label for="InputWithBalkon">С балконом</label>
              </article>
              <input
                type="number"
                placeholder="Цена от"
                class="w-4/12 text-xs md:text-sm border-1 border-gray-300 rounded-xl bg-gray-50 p-3.5 xl:text-md focus:outline-none focus:border-gray-500 focus:bg-white"
              />
              <input
                type="number"
                placeholder="Цена до"
                class="w-4/12 text-xs md:text-sm border-1 border-gray-300 rounded-xl bg-gray-50 p-3.5 xl:text-md focus:outline-none focus:border-gray-500 focus:bg-white"
              />
            </article>
            <article class="flex flex-row items-center xl:gap-4 gap-2.5">
              <input
                type="text"
                placeholder="Какой ЖК"
                class="w-4/12 text-xs md:text-sm border-1 border-gray-300 rounded-xl bg-gray-50 p-3.5 xl:text-md focus:outline-none focus:border-gray-500 focus:bg-white"
              />
              <input
                type="text"
                placeholder="Тип дома"
                class="w-4/12 text-xs md:text-sm border-1 border-gray-300 rounded-xl bg-gray-50 p-3.5 xl:text-md focus:outline-none focus:border-gray-500 focus:bg-white"
              />
              <article
                class="flex flex-row items-center justify-start gap-2.5 w-60 xl:text-md text-sm"
              >
                <input type="checkbox" name="" id="InputWithSanusel" class="" />
                <label for="InputWithSanusel">Совмещенный санузел</label>
              </article>
              <input
                type="number"
                placeholder="Цена за м² от"
                class="w-4/12 text-xs md:text-sm border-1 border-gray-300 rounded-xl bg-gray-50 p-3.5 xl:text-md focus:outline-none focus:border-gray-500 focus:bg-white"
              />
              <input
                type="number"
                placeholder="Цена за м² до"
                class="w-4/12 text-xs md:text-sm border-1 border-gray-300 rounded-xl bg-gray-50 p-3.5 xl:text-md focus:outline-none focus:border-gray-500 focus:bg-white"
              />
            </article>
          </article>
          <button
            type="submit"
            class="xl:self-end self-center font-medium rounded-lg lg:text-xl text-base px-7 pb-3 pt-2.5 bg-indigo-900 text-white"
          >
            применить
          </button>
        </form>
      </article>
    </article>
    <button class="absolute bottom-2.5 right-5 font-medium text-gray-600 hidden xl:block">
      свернуть / развернуть
    </button>
    <button class="absolute bottom-2.5 right-5 font-medium text-gray-600 text-3xl block xl:hidden">
      ^
    </button>
  </article>
</template> -->
<template>
  <article class="relative bg-sky-50">
    <article class="container mx-auto">
      <article
        ref="panelRef"
        :style="{ maxHeight: maxHeight + 'px' }"
        class="overflow-hidden transition-[max-height] duration-700 ease-in-out flex flex-col gap-5 xl:mx-45 lg:mx-25 mx-5 md:pb-10 md:pt-3 pt-1 pb-3.5"
      >
        <h4 class="text-2xl font-medium">Фильтры</h4>

        <form action="" class="flex flex-col gap-5">
          <article class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            <input
              type="number"
              placeholder="Количество комнат"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white"
            />
            <input
              type="number"
              placeholder="Какой этаж"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white"
            />
            <input
              type="text"
              placeholder="Какой ЖК"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white"
            />
            <input
              type="text"
              placeholder="Тип дома"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white"
            />
            <input
              type="number"
              placeholder="Цена от"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white"
            />
            <input
              type="number"
              placeholder="Цена до"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white"
            />
            <input
              type="number"
              placeholder="Цена за м² от"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white"
            />
            <input
              type="number"
              placeholder="Цена за м² до"
              class="text-xs md:text-sm border border-gray-300 rounded-xl bg-gray-50 p-3.5 focus:outline-none focus:border-gray-500 focus:bg-white"
            />

            <label class="flex items-center gap-2 text-sm xl:text-md col-span-1">
              <input type="checkbox" /> Совмещенный санузел
            </label>
            <label class="flex items-center gap-2 text-sm xl:text-md col-span-1">
              <input type="checkbox" /> С балконом
            </label>
          </article>

          <button
            type="submit"
            class="xl:self-end self-center font-medium rounded-lg lg:text-xl text-base px-7 pb-3 pt-2.5 bg-indigo-900 text-white"
          >
            применить
          </button>
        </form>

        <button
          @click="toggleCollapse"
          class="absolute bottom-1.5 right-5 font-medium text-gray-600 hidden xl:block"
        >
          {{ isCollapsed ? 'развернуть' : 'свернуть' }}
        </button>
        <button
          @click="toggleCollapse"
          class="absolute bottom-1.5 right-5 font-medium text-gray-600 text-3xl block xl:hidden"
        >
          {{ isCollapsed ? '˅' : '^' }}
        </button>
      </article>
    </article>
  </article>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'

const isCollapsed = ref(false)
const panelRef = ref(null)
const maxHeight = ref(0)

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
