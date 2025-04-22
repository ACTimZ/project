<script setup>
import LogoComponent from '../OtherUIElements/LogoComponent.vue'
function sendAlert(text) {
  alert(text)
}
</script>
<template>
  <footer class="bg-zinc-100">
    <article
      class="container mx-auto flex flex-col 2xl:gap-10 gap-5 xl:py-10 lg:pt-6 lg:pb-12.5 md:px-5 sm:px-15 px-5 pt-3 pb-8 footer-container"
    >
      <article class="item-a">
        <LogoComponent />
      </article>
      <article class="flex flex-row justify-between">
        <article class="flex flex-col 2xl:gap-10 xl:gap-5 justify-between items-start">
          <article class="flex flex-col 2xl:gap-12 lg:gap-7 gap-7.5 item-b">
            <article class="flex flex-col lg:gap-2">
              <h4 class="font-bold lg:text-2xl text-xl 2xl:text-3xl">Рабочий телефон:</h4>
              <b class="font-bold xl:text-4xl text-2xl text-indigo-900">89005005555</b>
            </article>
            <article class="hidden md:flex flex-col gap-2.5">
              <h4 class="font-bold lg:text-2xl 2xl:text-3xl text-xl">Информация:</h4>
              <article class="flex flex-col gap-1">
                <a href="#" class="font-light text-md" @click="sendAlert('SOON WILL BE ADDED')"
                  >Политика конфиденциальности</a
                >
                <a href="#" class="font-light text-md" @click="sendAlert('SOON WILL BE ADDED')"
                  >Условия использования</a
                >
              </article>
            </article>
          </article>

          <article class="flex flex-col gap-4.5 item-d md:items-start items-center">
            <h4 class="font-bold lg:text-2xl text-xl 2xl:text-3xl">Наши соц. сети:</h4>
            <ul
              class="xl:flex items-center xl:gap-5 md:gap-4.5 gap-6 grid md:grid-cols-2 grid-cols-1 md:ms-1"
            >
              <li class="">
                <a
                  href="https://web.telegram.org/a/"
                  class=""
                  target="_blank"
                  rel="noopener noreferrer"
                  ><img src="../icons/tg.svg" alt="" class="h-[50px] w-[50px]"
                /></a>
              </li>
              <li class="">
                <a
                  href="https://web.whatsapp.com/"
                  class=""
                  target="_blank"
                  rel="noopener noreferrer"
                  ><img src="../icons/whatsup.svg" alt="" class="h-[50px] w-[50px]"
                /></a>
              </li>
              <li class="">
                <a href="https://vk.ru/feed" class="" target="_blank" rel="noopener noreferrer"
                  ><img src="../icons/vk.svg" alt="" class="h-[50px] w-[50px]"
                /></a>
              </li>
              <li class="">
                <a href="https://ok.ru/" class="" target="_blank" rel="noopener noreferrer"
                  ><img src="../icons/ok.svg" alt="" class="h-[50px] w-[50px]"
                /></a>
              </li>
            </ul>
          </article>
        </article>
        <ul
          class="xl:flex xl:flex-row 2xl:gap-25 xl:gap-16.5 grid md:grid-cols-2 grid-cols-1 item-c lg:gap-y-12.5 gap-y-8 lg:gap-x-25 gap-x-5"
        >
          <li class="flex flex-col gap-1.5 xl:w-4/12 2xl:w-5/12 w-10/12">
            <h4 class="font-bold lg:text-2xl text-xl text-indigo-900 2xl:text-3xl">
              Главная страница
            </h4>
            <ul class="flex flex-col gap-3">
              <li>
                <router-link
                  :to="{ path: '/', hash: '#main_reviews' }"
                  class="font-light lg:text-lg text-md"
                  >Отзывы</router-link
                >
              </li>
              <li>
                <router-link
                  :to="{ path: '/', hash: '#main_preimushestva' }"
                  class="font-light lg:text-lg text-md"
                  >Преимущества</router-link
                >
              </li>
              <li>
                <router-link to="/" class="font-light lg:text-lg text-md">О нас</router-link>
              </li>
              <li>
                <router-link
                  :to="{ path: '/', hash: '#main_faq' }"
                  class="font-light lg:text-lg text-md"
                  >Вопросы</router-link
                >
              </li>
            </ul>
          </li>
          <li class="hidden md:flex flex-col gap-1.5 xl:w-4/12 lg:w-10/12 w-8/12">
            <h4 class="font-bold lg:text-2xl text-xl text-indigo-900 2xl:text-3xl">Каталог</h4>
            <ul class="flex flex-col gap-3">
              <li>
                <a
                  href="#"
                  class="font-light lg:text-lg text-md"
                  @click="sendAlert('SOON WILL BE ADDED')"
                  >Квартиры до 4 млн рублей</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="font-light lg:text-lg text-md"
                  @click="sendAlert('SOON WILL BE ADDED')"
                  >Популярное</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="font-light lg:text-lg text-md"
                  @click="sendAlert('SOON WILL BE ADDED')"
                  >Обзор самой дорогой квартиры</a
                >
              </li>
            </ul>
          </li>
          <li class="flex flex-col gap-1.5">
            <h4 class="font-bold lg:text-2xl text-xl text-indigo-900 2xl:text-3xl">Спонсоры</h4>
            <ul class="flex flex-col gap-3">
              <li>
                <a
                  href="https://www.sberbank.com/ru"
                  class="font-light lg:text-lg text-md"
                  target="_blank"
                  rel="noopener noreferrer"
                  >Сбер</a
                >
              </li>
              <li>
                <a
                  href="https://www.acron.ru/"
                  class="font-light lg:text-lg text-md"
                  target="_blank"
                  rel="noopener noreferrer"
                  >Акрон</a
                >
              </li>
              <li>
                <a
                  href="https://proektstroi.ru/"
                  class="font-light lg:text-lg text-md"
                  target="_blank"
                  rel="noopener noreferrer"
                  >Проектстрой</a
                >
              </li>
              <li>
                <a
                  href="https://www.gazprom.ru/"
                  class="font-light lg:text-lg text-md"
                  target="_blank"
                  rel="noopener noreferrer"
                  >Газпром</a
                >
              </li>
              <li>
                <a
                  href="https://lukoil.ru/"
                  class="font-light lg:text-lg text-md"
                  target="_blank"
                  rel="noopener noreferrer"
                  >Лукойл</a
                >
              </li>
            </ul>
          </li>
          <li class="hidden md:flex flex-col gap-1.5 lg:w-3/12 md:w-5/12 sm:w-6/12">
            <h4 class="font-bold lg:text-2xl text-xl text-indigo-900 2xl:text-3xl">Контакты</h4>
            <ul class="flex flex-col gap-3">
              <li>
                <router-link
                  :to="{ path: '/contacts', hash: '#information_contacts' }"
                  class="font-light lg:text-lg text-md"
                  >Контакты</router-link
                >
              </li>
              <li>
                <router-link
                  :to="{ path: '/contacts', hash: '#information_contacts' }"
                  class="font-light lg:text-lg text-md"
                  >Почта</router-link
                >
              </li>
              <li>
                <router-link
                  :to="{ path: '/contacts', hash: '#information_contacts' }"
                  class="font-light lg:text-lg text-md"
                  >Адрес</router-link
                >
              </li>
              <li>
                <router-link
                  :to="{ path: '/contacts', hash: '#requisites_contacts' }"
                  class="font-light lg:text-lg text-md"
                  >Реквизиты</router-link
                >
              </li>
            </ul>
          </li>
        </ul>
      </article>

      <article class="xl:flex flex-col gap-2.5 hidden">
        <h4 class="font-bold text-2xl 2xl:text-3xl">О нас подробнее</h4>
        <p class="text-lg font-light">
          Наша компания специализируется на продаже квартир в новостройках, предлагая широкий выбор
          современных жилых комплексов в самых привлекательных районах города. Мы помогаем клиентам
          найти идеальное жилье, учитывая их потребности и бюджет. Наша команда профессионалов
          обеспечивает полный цикл услуг: от консультаций и подбора объектов до оформления сделок.
          Мы гарантируем прозрачность и надежность на каждом этапе, чтобы покупка квартиры стала для
          вас приятным и безопасным процессом.
        </p>
      </article>
    </article>
  </footer>
</template>

<style scoped>
/* @media (max-width: 1279px) {
  .footer-container {
    display: grid;
    grid-template-areas:
      'a a a'
      'w c c'
      'd c c';
  }

  .item-a {
    grid-area: a;
  }

  .item-d {
    grid-area: d;
  }

  .item-c {
    grid-area: c;
    display: grid;
    grid-template-columns: 1fr 1fr;
  }

  .item-b {
    grid-area: w;
  }
} */
</style>
