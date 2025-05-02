<script setup>
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'
import AppealsAboutFlatsComponent from './AppealsAboutFlatsComponent.vue'
import FeedbackFormComponent from './FeedbackFormComponent.vue'
import PersonalInformationComponent from './PersonalInformationComponent.vue'

const authStore = useAuthStore()
const router = useRouter()

const logout = async () => {
  await authStore.logout()
  router.push('/')
}
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
    </article>

    <article
      class="flex flex-col gap-17.5 md:mt-[-15px] mt-5 sm:mx-15 mx-5 xl:mb-20 lg:mb-15 mb-10"
    >
      <PersonalInformationComponent />
      <AppealsAboutFlatsComponent />
      <FeedbackFormComponent />
    </article>
  </section>
</template>
