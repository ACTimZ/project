<script setup>
import { ref } from 'vue'
import ButtonCatalogComponent from './Buttons/Catalog/ButtonCatalogComponent.vue'
import CreateProfileComponent from './Buttons/RelatedWithProfile/CreateProfileComponent.vue'
import LogoComponent from '../OtherUIElements/LogoComponent.vue'
import RegAndAuth from '../ModalWindows/RegAndAuth.vue'

const isProfileModalVisible = ref(false)

function sendAlert(text) {
  alert(text)
}
</script>

<template>
  <header class="bg-gray-50">
    <article class="bg-gray-50 container mx-auto">
      <article
        class="border-b border-gray-500 text-gray-600 flex-row justify-between py-4 hidden xl:flex"
      >
        <ul class="flex gap-10 text-sm">
          <li>
            <a
              href="https://vc.ru/life/1546678-moya-podborka-luchshih-kvartir-dlya-arendy-posutochno-v-centre-velikogo-novgoroda-v-2024"
              target="_blank"
              rel="noopener noreferrer"
              >Лучшие квартиры от застройщика</a
            >
          </li>
          <li>
            <a
              href="https://yandex.ru/maps/geo/velikiy_novgorod/53149420/?ll=31.310137%2C58.560956&z=11"
              class="flex items-center gap-1"
              target="_blank"
              rel="noopener noreferrer"
            >
              <img src="../icons/NavigationArrow.svg" alt="" />Великий Новгород
            </a>
          </li>
        </ul>
        <ul class="flex gap-10 text-sm">
          <li><a href="#" @click="sendAlert('SOON WILL BE ADDED')">Политика использования</a></li>
          <li>
            <router-link :to="{ path: '/', hash: '#main_preimushestva' }">Преимущества</router-link>
          </li>
          <li>
            <router-link :to="{ path: '/', hash: '#main_reviews' }">Отзывы</router-link>
          </li>
          <li>
            <router-link :to="{ path: '/', hash: '#main_faq' }">Вопросы</router-link>
          </li>
          <li>
            <router-link :to="{ path: '/', hash: '#main_form_for_sending_questions' }"
              >Обратная связь</router-link
            >
          </li>
          <li>
            <router-link :to="{ path: '/', hash: '#main_map' }">Наш офис</router-link>
          </li>
        </ul>
      </article>

      <article class="flex flex-row items-center justify-between sm:gap-10 py-5 gap-3">
        <article class="flex flex-row items-center justify-between sm:w-8/12 w-5/12">
          <LogoComponent />
          <ul
            class="flex items-center font-medium text-indigo-900 xl:w-5/12 justify-between md:gap-10 sm:gap-5"
          >
            <li>
              <router-link to="/contacts" class="sm:block hidden">Контакты</router-link>
            </li>
            <li>
              <router-link to="/" class="lg:block hidden">О компании</router-link>
            </li>
            <li>
              <router-link to="/" class="sm:block hidden">Главная</router-link>
            </li>
          </ul>
          <a
            href="tel:+79005005555"
            class="flex items-center gap-1 font-medium text-indigo-900 sm:text-md text-sm"
          >
            <img src="../icons/phone.svg" alt="" />89005005555
          </a>
        </article>
        <article class="flex flex-row sm:gap-5 gap-3 items-center">
          <ButtonCatalogComponent />
          <CreateProfileComponent @open="isProfileModalVisible = true" />
          <!-- <CreateProfileComponent /> -->
        </article>
      </article>
    </article>
  </header>
  <RegAndAuth v-model:visible="isProfileModalVisible" />
</template>

<style scoped></style>
