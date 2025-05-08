<script setup>
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'
// import AppealsAboutFlatsComponent from './AppealsAboutFlatsComponent.vue'
import FeedbackFormComponent from './FeedbackFormComponent.vue'
import PersonalInformationComponent from './PersonalInformationComponent.vue'
import { onMounted, ref } from 'vue'

let authStore = useAuthStore()
let router = useRouter()
let role = ref("")

let logout = async () => {
  await authStore.logout()
  router.push('/')
}

onMounted(() => {
  let isAuth = JSON.parse(localStorage.getItem('user') || 'null')
  role.value = isAuth ? isAuth.role : false
})
</script>

<template>
  <section class="container mx-auto relative">
    <article class="sticky top-7.5 z-50 mt-5 md:ms-0 ms-5 flex flex-col gap-5 items-start">
      <router-link
        to="/profile/favourites"
        class="cursor-pointer hover:bg-rose-800 bg-white hover:text-white duration-150 border-rose-800 border-2 rounded-lg py-3 px-4 font-bold text-rose-800"
      >
        Перейти в избранное ➞
      </router-link>
      <button
        @click="logout"
        class="bg-red-500 text-white font-bold py-2 px-4 rounded-lg self-start cursor-pointer"
      >
        Выйти
      </button>
      <router-link to="/profile/admin" class="px-3 bg-teal-700 py-2 rounded-xl font-medium text-white cursor-pointer hover:bg-teal-600 transition" v-if="role == 'admin'">
        Админ-панель
      </router-link>
    </article>

    <article
      class="flex flex-col gap-25 md:mt-[-15px] mt-5 sm:mx-15 mx-5 xl:mb-20 lg:mb-15 mb-10"
    >
    <h1 v-if="role == 'admin' " class="text-center text-3xl font-bold mt-[-125px]">Вы - <span class="underline italic">админ</span></h1>
      <PersonalInformationComponent />
      <!-- <AppealsAboutFlatsComponent /> -->
      <FeedbackFormComponent />
    </article>
  </section>
</template>
