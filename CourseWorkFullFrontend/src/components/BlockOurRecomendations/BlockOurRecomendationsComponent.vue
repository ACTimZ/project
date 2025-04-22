<script setup>
function sendAlert(text) {
  alert(text)
}
</script>
<template>
  <section class="">
    <article
      class="container mx-auto grid lg:grid-cols-3 grid-cols-2 xl:grid-rows-2 md:grid-rows-1 grid-rows-2 gap-4"
    >
      <article
        class="bg-violet-50 flex flex-row justify-between md:items-center items-start px-7 col-start-1 col-end-3 rounded-2xl"
      >
        <article class="flex flex-col 2xl:gap-10.5 xl:gap-7 md:gap-5 gap-10 lg:py-0 py-5 relative">
          <h5 class="font-medium 2xl:text-3xl xl:text-2xl text-xl">
            Как подобрать нужную квартиру
          </h5>
          <article class="flex flex-row md:gap-5 gap-2.5">
            <article
              class="text-indigo-900 md:text-md text-sm xl:px-5 lg:px-1 md:px-5 sm:px-1.5 px-4 xl:py-2 sm:py-1 py-2 border-2 rounded-lg flex flex-col items-center"
            >
              <b>Иметь желание</b>
              <p class="sm:block hidden">для приобретения</p>
              <p class="sm:hidden block font-bold">купить квартиру</p>
            </article>
            <article
              class="text-indigo-900 hidden md:text-md text-sm xl:px-5 lg:px-1 md:px-5 px-1.5 xl:py-2 py-1 border-2 rounded-lg sm:flex flex-col items-center"
            >
              <b>Уметь пользоваться</b>
              <p>фильтром</p>
            </article>
          </article>
          <p class="xl:text-lg text-md md:block hidden">
            Самый простой вариант - нажмите на одну из кнопок ниже:
          </p>
          <article class="flex flex-row gap-5 text-indigo-900">
            <a
              href="#"
              @click="sendAlert('SOON WILL BE ADDED')"
              class="py-3 md:px-5 px-3.5 rounded bg-orange-100 font-medium sm:block hidden"
              >выгодный вариант</a
            >
            <router-link
              to="/catalog"
              class="sm:py-3 py-4 sm:border-0 border-2 border-indigo-900 md:px-5 sm:px-3.5 px-5 sm:rounded rounded-lg bg-white"
            >
              в каталог
            </router-link>
          </article>
        </article>
        <img
          src="../Images/HouseForRecomendations.png"
          class="xl:w-100 sm:w-70 self-end w-50"
          alt=""
        />
      </article>
      <article
        class="bg-violet-50 ps-7 flex flex-col justify-start lg:gap-0 gap-10 lg:justify-between relative py-5 lg:col-start-3 lg:row-start-1 row-start-2 col-start-1 col-end-3 rounded-2xl"
      >
        <h5 class="font-medium 2xl:text-3xl text-xl">“Выбор джентельмена”</h5>
        <article
          class="flex sm:flex-row flex-col-reverse sm:items-center items-start sm:gap-5 gap-2.5"
        >
          <article
            class="text-indigo-900 xl:px-10 px-5 lg:py-1 py-3 border-2 rounded-lg flex lg:flex-col flex-row xl:gap-0 gap-1.5 items-center"
          >
            <p>от <b class="text-lg">6%</b></p>
            <p>ставка</p>
          </article>
          <article
            class="text-indigo-900 xl:px-4 lg:px-1 px-5 lg:py-1 py-3 border-2 rounded-lg flex lg:flex-col flex-row xl:gap-0 gap-1.5 items-center"
          >
            <p>от <b class="text-lg">1 года</b></p>
            <p>срок ипотеки</p>
          </article>
        </article>
        <p class="w-7/12 font-medium 2xl:text-md text-sm xl:block hidden">
          Воспользуйтесь выгодными условиями ипотеки от застройщика
        </p>
        <article class="flex flex-row gap-5 text-indigo-900 justify-between">
          <article
            class="flex lg:flex-col md:flex-row flex-col lg:items-start md:items-center items-start gap-3"
          >
            <a
              href="#"
              @click="sendAlert('SOON WILL BE ADDED')"
              class="py-3 px-10 rounded bg-orange-100 font-medium"
              >подробнее</a
            >
            <router-link to="/catalog" class="py-3 px-7 rounded bg-white"> в каталог </router-link>
          </article>
          <img
            src="../Images/KeysForRecomendations.png"
            alt=""
            class="absolute xl:w-50 lg:w-30 sm:w-60 w-50 right-0 bottom-0"
          />
        </article>
      </article>

      <article
        class="bg-violet-50 ps-7 hidden xl:flex flex-col justify-start lg:gap-0 gap-10 lg:justify-between relative py-5 lg:row-start-2 col-start-1 col-end-2 rounded-2xl"
      >
        <h5 class="font-medium 2xl:text-3xl text-xl">Как нас найти?</h5>
        <article class="flex flex-col sm:items-center sm:gap-5 gap-2.5 self-start">
          <article
            class="text-indigo-900 xl:px-10 px-5 lg:py-1 py-3 border-2 rounded-lg flex lg:flex-col flex-row xl:gap-0 gap-1.5 items-center"
          >
            <b class="text-lg">по номеру</b>
            <p>телефона</p>
          </article>
          <article
            class="text-indigo-900 xl:px-4 lg:px-1 px-5 lg:py-1 py-3 border-2 rounded-lg flex lg:flex-col flex-row xl:gap-0 gap-1.5 items-center"
          >
            <b class="text-lg">зная наш адрес</b>
          </article>
        </article>
        <p class="w-7/12 font-medium 2xl:text-md text-sm xl:block hidden">
          Либо в шапке сайта, либо в нижней части. <br />
          А проще - нажав кнопку:
        </p>
        <article class="flex flex-row gap-5 text-indigo-900 justify-between">
          <article
            class="flex lg:flex-col md:flex-row flex-col lg:items-start md:items-center items-start gap-3"
          >
            <router-link to="/contacts" class="py-3 px-10 rounded bg-orange-100 font-medium">
              контакты
            </router-link>
          </article>
          <img
            src="../Images/HandsomeBusinessManInSmallScreensAtTheFirstWelcomeBlock.png"
            alt=""
            class="absolute xl:w-50 lg:w-30 sm:w-60 w-50 right-0 bottom-0"
          />
        </article>
      </article>

      <article
        class="bg-violet-50 xl:flex hidden flex-row justify-between md:items-center items-start px-7 col-start-2 col-end-4 rounded-2xl"
      >
        <article class="flex flex-col 2xl:gap-10.5 xl:gap-7 md:gap-5 gap-10 lg:py-0 py-5 relative">
          <h5 class="font-medium 2xl:text-3xl xl:text-2xl text-xl">Лучший вариант квартиры</h5>
          <article class="flex flex-row md:gap-5 gap-2.5">
            <article
              class="text-indigo-900 md:text-md text-sm xl:px-5 lg:px-1 md:px-5 sm:px-1.5 px-4 xl:py-2 sm:py-1 py-2 border-2 rounded-lg flex flex-col items-center"
            >
              <b>60 м²</b>
              <p class="sm:block hidden">Общая площадь</p>
            </article>
            <article
              class="text-indigo-900 hidden md:text-md text-sm xl:px-5 lg:px-1 md:px-5 px-1.5 xl:py-2 py-1 border-2 rounded-lg sm:flex flex-col items-center"
            >
              <b>60.000 ₽</b>
              <p>за м²</p>
            </article>
          </article>
          <p class="xl:text-lg text-md md:block hidden">
            Просторная площадь, привлекательная цена <br />
            и элитный район - лучшее, что может быть
          </p>
          <article class="flex flex-row gap-5 text-indigo-900">
            <a
              href="#"
              @click="sendAlert('SOON WILL BE ADDED')"
              class="py-3 md:px-5 px-3.5 rounded bg-orange-100 font-medium sm:block hidden"
              >подробнее</a
            >
            <router-link
              to="/catalog"
              class="sm:py-3 py-4 sm:border-0 border-2 border-indigo-900 md:px-5 sm:px-3.5 px-5 sm:rounded rounded-lg bg-white"
            >
              в каталог
            </router-link>
          </article>
        </article>
        <img
          src="../Images/ViewSomeFlatForRecomendations.png"
          class="xl:w-100 sm:w-70 self-end w-50"
          alt=""
        />
      </article>
    </article>
  </section>
</template>
