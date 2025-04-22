<script setup>
import LearnOpinionPeoplesButtonComponent from './Buttons/LearnOpinionPeoplesButtonComponent.vue'
import LetsGoButtonComponent from './Buttons/LetsGoButtonComponent.vue'
</script>

<template>
  <section class="bg-sky-50">
    <article
      class="container mx-auto flex flex-row 2xl:justify-evenly lg:justify-center sm:justify-between justify-center items-center sm:py-0 py-10"
    >
      <article
        class="flex flex-col lg:gap-10 md:gap-7 gap-10 md:w-6/12 lg:mb-0 md:mb-7.5 sm:mb-3 mb-0 w-5/12 relative lg:left-0 md:left-5 sm:left-10 sm:items-start items-center"
      >
        <h1
          class="xl:text-3xl lg:text-2xl md:text-lg text-xl font-medium md:w-12/12 sm:w-75 sm:text-start text-center w-90"
        >
          Приобретайте недвижимость, которая будет приносить не только
          <b class="text-amber-600 font-black">радость</b>, но и
          <b class="text-green-700 font-black">выгоду</b>
        </h1>
        <p class="xl:text-2xl lg:text-xl md:text-md text-lg sm:text-start text-center">
          Ваш идеальный объект – всего <b class="font-black text-indigo-900">в нескольких шагах</b>
        </p>
        <article
          class="flex md:flex-row flex-col sm:items-start md:items-center items-center lg:gap-7 md:gap-3.5 gap-5 lg:w-12/12 md:w-98"
        >
          <LetsGoButtonComponent />
          <LearnOpinionPeoplesButtonComponent />
        </article>
      </article>
      <img
        src="../Images/ManOnTheWelcomeBlock.png"
        alt=""
        class="h-fit xl:w-100.5 w-85 md:block hidden"
      />
      <img
        src="../Images/HandsomeBusinessManInSmallScreensAtTheFirstWelcomeBlock.png"
        alt=""
        class="sm:block md:hidden sm:w-5.5/12 hidden"
      />
    </article>
  </section>
</template>
