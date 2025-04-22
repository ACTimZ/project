<script setup>
const emit = defineEmits(['open'])
</script>

<template>
  <!-- <router-link
    to="/profile"
    class="font-bold border-2 border-indigo-900 sm:py-3 sm:px-7 py-2 px-3 xl:text-xl rounded-sm text-indigo-900 md:text-md"
    >ПРОФИЛЬ</router-link
  > -->
  <button
    @click="emit('open')"
    class="font-bold border-2 border-indigo-900 sm:py-3 sm:px-7 py-2 px-3 xl:text-xl rounded-sm text-indigo-900 md:text-md"
  >
    ПРОФИЛЬ
  </button>
</template>
