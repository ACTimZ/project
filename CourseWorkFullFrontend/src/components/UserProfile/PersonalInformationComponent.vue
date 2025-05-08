<script setup>
import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()
</script>
<template>
  <article class="flex flex-col items-center md:gap-7.5 gap-3 mt-[-50px]">
    <h2 class="font-bold lg:text-3xl sm:text-2xl text-lg">Личная информация</h2>
    <article
      class="lg:text-2xl sm:text-lg text-base grid grid-cols-2 lg:gap-y-10 gap-y-5 gap-x-7 me-7"
    >
      <b class="col-start-1 row-start-1 text-end">Имя</b>
      <b class="col-start-1 row-start-2 text-end">Фамилия</b>
      <b class="col-start-1 row-start-3 text-end">Телефон</b>
      <b class="col-start-1 row-start-4 text-end">Почта</b>
      <p class="col-start-2 row-start-1 text-start">{{ authStore.user?.first_name }}</p>
      <p class="col-start-2 row-start-2 text-start">{{ authStore.user?.last_name }}</p>
      <p class="col-start-2 row-start-3 text-start">{{ authStore.user?.phone }}</p>
      <p class="col-start-2 row-start-4 text-start">{{ authStore.user?.email }}</p>
    </article>
  </article>
</template>
