<template>
  <article
    class="flex lg:flex-row flex-col lg:justify-around items-center lg:gap-0 gap-7.5 lg:py-0 py-5"
  >
    <article class="flex flex-col items-start xl:gap-10 gap-8 lg:w-12/12 md:w-8/12">
      <h2 class="text-2xl font-bold lg:block hidden">Контактная информация</h2>
      <article class="flex flex-row items-center xl:gap-4.5 lg:gap-2 gap-4">
        <img src="../../icons/Copyright.svg" alt="" />
        <p class="font-medium xl:text-xl text-lg">ООО “Домострой партнер”</p>
      </article>
      <article class="flex flex-row items-center xl:gap-4.5 lg:gap-2 gap-4">
        <img src="../../icons/PhoneLine.svg" alt="" />
        <p class="font-medium xl:text-xl text-lg">8-900-500-55-55</p>
      </article>
      <article class="flex flex-row items-center xl:gap-4.5 lg:gap-2 gap-4">
        <img src="../../icons/MapPoint.svg" alt="" />
        <p class="font-medium xl:text-xl text-lg lg:w-fit">
          Великий Новгород, площадь Победы-Софийская, 1
        </p>
      </article>
      <article class="flex flex-row items-center xl:gap-4.5 lg:gap-2 gap-4">
        <img src="../../icons/SvgEmail.svg" alt="" class="" />
        <p class="font-medium xl:text-xl text-lg">domostroy@partnermail.ru</p>
      </article>
    </article>
    <article class="flex sm:w-fit w-full">
      <iframe
        src="https://yandex.ru/map-widget/v1/?ll=31.270281%2C58.523338&z=17.03"
        allowfullscreen="true"
        style="position: relative"
        class="rounded-2xl xl:w-150 lg:w-100 xl:h-105 lg:h-90 md:w-120 md:h-80 sm:w-120 sm:h-70 w-full h-60"
      ></iframe>
    </article>
  </article>
</template>
