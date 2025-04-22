<script setup>
import { Carousel } from 'flowbite'
import { onMounted } from 'vue'

onMounted(() => {
  let carouselElement = document.getElementById('carousel-example')

  let items = [
    {
      position: 0,
      el: document.getElementById('carousel-item-1'),
    },
    {
      position: 1,
      el: document.getElementById('carousel-item-2'),
    },
    {
      position: 2,
      el: document.getElementById('carousel-item-3'),
    },
    {
      position: 0,
      el: document.getElementById('carousel-item-1'),
    },
  ]

  const carousel = new Carousel(carouselElement, items)

  document.getElementById('data-carousel-prev').addEventListener('click', () => {
    carousel.prev()
  })

  document.getElementById('data-carousel-next').addEventListener('click', () => {
    carousel.next()
  })
})
</script>

<template>
  <section id="carousel-example" class="relative container mx-auto">
    <article class="relative overflow-hidden flex items-center flex-col lg:h-96 h-80">
      <article id="carousel-item-1" class="hidden duration-700 ease-in-out">
        <article class="flex flex-col relative">
          <img src="../Images/ReviewsImage1.png" alt="" class="w-fit lg:w-130 xl:h-70.5" />
          <article class="bg-orange-100 px-3 py-3.5 flex flex-col gap-1 lg:w-130 w-101.5">
            <h5 class="font-medium lg:text-xl md:text-lg text-md">Отличный выбор квартир</h5>
            <p class="font-light lg:text-md text-sm">
              Помогли быстро подобрать квартиру, учли все пожелания. Всем рекомендую! Сервис на
              высоте
            </p>
          </article>
          <article class="flex flex-row absolute right-2.5 top-2.5">
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
          </article>
        </article>
      </article>

      <article id="carousel-item-2" class="hidden duration-700 ease-in-out">
        <article class="flex flex-col relative">
          <img src="../Images/ReviewsImage2.png" alt="" class="w-fit lg:w-130 xl:h-70.5" />
          <article class="bg-orange-100 px-3 py-3.5 flex flex-col gap-1 lg:w-130 w-101.5">
            <h5 class="font-medium lg:text-xl md:text-lg text-md">Квартира моей мечты</h5>
            <p class="font-light lg:text-md text-sm">
              Нашел именно то, что искал! Качество отличное, помогли с покупкой. Спасибо большое!
            </p>
          </article>
          <article class="flex flex-row absolute right-2.5 top-2.5">
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
          </article>
        </article>
      </article>

      <article id="carousel-item-3" class="hidden duration-700 ease-in-out">
        <article class="flex flex-col relative">
          <img src="../Images/ReviewsImage3.png" alt="" class="w-fit lg:w-130 xl:h-70.5" />
          <article class="bg-orange-100 px-3 py-3.5 flex flex-col gap-1 lg:w-130 w-101.5">
            <h5 class="font-medium lg:text-xl md:text-lg text-md">Надежный партнер-застройщик</h5>
            <p class="font-light lg:text-md text-sm">
              Все чётко, быстро, надежно. Оформили все документы без проблем. Буду рекомендовать
            </p>
          </article>
          <article class="flex flex-row absolute right-2.5 top-2.5">
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
            <img src="../icons/StarFiiled.svg" alt="*" />
          </article>
        </article>
      </article>
    </article>

    <button
      id="data-carousel-prev"
      type="button"
      class="group absolute left-0 lg:left-50 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
    >
      <img src="../icons/arrow_for_slider.svg" alt="" class="rotate-180" />
    </button>
    <button
      id="data-carousel-next"
      type="button"
      class="group absolute right-0 lg:right-50 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
    >
      <img src="../icons/arrow_for_slider.svg" alt="" class="" />
    </button>
  </section>
</template>
