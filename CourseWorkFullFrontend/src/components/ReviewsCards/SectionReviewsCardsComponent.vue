<script setup>
import { ref } from 'vue'
import ReviewImage1 from '../Images/ReviewsImage1.png'
import ReviewImage2 from '../Images/ReviewsImage2.png'
import ReviewImage3 from '../Images/ReviewsImage3.png'

let activeIndex = ref(0)

let slides = [
  {
    id: 1,
    image: ReviewImage1,
    title: 'Отличный выбор квартир',
    text: 'Помогли быстро подобрать квартиру, учли все пожелания. Всем рекомендую! Сервис на высоте',
  },
  {
    id: 2,
    image: ReviewImage2,
    title: 'Квартира моей мечты',
    text: 'Нашел именно то, что искал! Качество отличное, помогли с покупкой. Спасибо большое!',
  },
  {
    id: 3,
    image: ReviewImage3,
    title: 'Надежный партнер-застройщик',
    text: 'Все чётко, быстро, надежно. Оформили все документы без проблем. Буду рекомендовать',
  },
]

function nextSlide() {
  activeIndex.value = (activeIndex.value + 1) % slides.length
}

function prevSlide() {
  activeIndex.value = (activeIndex.value - 1 + slides.length) % slides.length
}
</script>

<template>
  <section class="relative container mx-auto">
    <article class="relative overflow-hidden flex items-center flex-col lg:h-96 h-80">
      <article
        v-for="(slide, index) in slides"
        :key="slide.id"
        class="absolute transition-opacity duration-700 ease-in-out flex justify-center w-full"
        :class="{
          'opacity-100 z-20': index === activeIndex,
          'opacity-0 z-10 pointer-events-none': index !== activeIndex,
        }"
      >
        <article class="flex flex-col relative">
          <img :src="slide.image" alt="" class="w-fit lg:w-130 xl:h-70.5" />
          <article class="bg-orange-100 px-3 py-3.5 flex flex-col gap-1 lg:w-130 w-101.5">
            <h5 class="font-medium lg:text-xl md:text-lg text-md">{{ slide.title }}</h5>
            <p class="font-light lg:text-md text-sm">{{ slide.text }}</p>
          </article>
          <article class="flex flex-row absolute right-2.5 top-2.5">
            <img
              v-for="i in 5"
              :key="i"
              src="../icons/StarFiiled.svg"
              alt="*"
              class="w-5 h-5"
            />
          </article>
        </article>
      </article>
    </article>

    <button
      @click="prevSlide"
      type="button"
      class="group absolute left-0 lg:left-50 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
    >
      <img src="../icons/arrow_for_slider.svg" alt="" class="rotate-180" />
    </button>
    <button
      @click="nextSlide"
      type="button"
      class="group absolute right-0 lg:right-50 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
    >
      <img src="../icons/arrow_for_slider.svg" alt="" />
    </button>
  </section>
</template>
