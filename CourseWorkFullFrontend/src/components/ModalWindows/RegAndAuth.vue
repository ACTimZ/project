<script setup>
import { ref, watch } from 'vue'

const visible = defineModel('visible')

const showRegister = ref(false)
const showLogin = ref(false)

watch(
  visible,
  (newVal) => {
    showRegister.value = newVal
    if (!newVal) showLogin.value = false
  },
  { immediate: true },
)

// Форма регистрации
const registerForm = ref({
  firstName: '',
  lastName: '',
  email: '',
  phone: '',
  password: '',
  agree: false,
})

// Форма логина
const loginForm = ref({
  email: '',
  password: '',
})

const toggleModal = () => {
  showRegister.value = !showRegister.value
  showLogin.value = !showLogin.value
}

const closeModal = () => {
  showRegister.value = false
  showLogin.value = false
  visible.value = false // ← закрытие окна автоматически отражается в родителе
}

const submitRegister = () => {
  console.log(registerForm.value)
}

const submitLogin = () => {
  console.log(loginForm.value)
}
</script>

<template>
  <article>
    <!-- Registration Modal -->
    <article
      v-if="showRegister"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
      <article
        class="w-full max-w-4xl bg-gray-100 rounded-xl relative xl:mx-60 sm:mx-15 mx-5 lg:pt-10 pt-5 pb-7 lg:px-26 px-5"
      >
        <button @click="closeModal" class="absolute top-4 right-4 text-3xl cursor-pointer">
          &times;
        </button>
        <h2 class="self-center text-3xl font-bold text-center mb-6">Регистрация</h2>

        <form class="flex flex-col gap-5">
          <article class="flex flex-col md:flex-row lg:gap-10 gap-4">
            <input
              v-model="registerForm.firstName"
              type="text"
              placeholder="Имя"
              class="md:w-6/12 w-full border border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
            />
            <input
              v-model="registerForm.lastName"
              type="text"
              placeholder="Фамилия"
              class="md:w-6/12 w-full border border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
            />
          </article>

          <article class="flex flex-col md:flex-row lg:gap-10 gap-4">
            <input
              v-model="registerForm.phone"
              type="tel"
              placeholder="Телефон"
              class="md:w-6/12 w-full border border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
            />
            <input
              v-model="registerForm.email"
              type="email"
              placeholder="Почта"
              class="md:w-6/12 w-full border border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
            />
          </article>

          <input
            v-model="registerForm.password"
            type="password"
            placeholder="Пароль"
            class="w-full border border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
          />

          <article class="flex flex-row items-start gap-4">
            <input
              v-model="registerForm.agree"
              type="checkbox"
              class="w-6 h-6 border border-gray-300 rounded-sm text-sky-100 focus:ring-2 focus:ring-sky-100 mt-1.5"
            />
            <label class="text-sm md:text-base leading-tight">
              Принимаю
              <a href="#" class="text-amber-600 font-medium">условия использования</a><br />
              и ознакомлен с
              <a href="#" class="text-amber-600 font-medium">политикой конфиденциальности</a>
            </label>
          </article>

          <button
            @click.prevent="submitRegister"
            class="cursor-pointer self-center py-3.5 lg:px-6 md:px-2.5 px-8 bg-orange-100 lg:text-lg md:text-md text-lg font-bold text-indigo-900 rounded text-center lg:mt-3"
          >
            Создать аккаунт
          </button>
          <p class="text-sm text-center mt-2">
            Создан аккаунт?
            <button
              @click="toggleModal"
              class="cursor-pointer text-indigo-900 font-semibold hover:underline"
            >
              Войти
            </button>
          </p>
        </form>
      </article>
    </article>

    <!-- Login Modal -->
    <article
      v-if="showLogin"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
      <article
        class="w-full max-w-2xl bg-gray-100 rounded-xl relative xl:mx-60 sm:mx-15 mx-5 lg:pt-10 pt-5 pb-7 lg:px-26 px-10"
      >
        <button @click="closeModal" class="absolute top-4 right-4 text-3xl cursor-pointer">
          &times;
        </button>
        <h2 class="text-3xl font-bold text-center mb-6">Авторизация</h2>

        <form class="flex flex-col gap-5">
          <input
            v-model="loginForm.email"
            type="email"
            placeholder="Почта"
            class="w-full border border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
          />

          <input
            v-model="loginForm.password"
            type="password"
            placeholder="Пароль"
            class="w-full border border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
          />

          <p class="text-sm text-right">
            <a href="#" class="text-indigo-900 hover:underline">Забыли пароль?</a>
          </p>

          <button
            @click.prevent="submitLogin"
            class="cursor-pointer self-center py-3.5 lg:px-6 md:px-2.5 px-8 bg-orange-100 lg:text-lg md:text-md text-lg font-bold text-indigo-900 rounded text-center lg:mt-3"
          >
            Войти
          </button>
          <p class="text-sm text-center mt-2">
            Желаете присоединиться к нам?
            <button
              @click="toggleModal"
              class="cursor-pointer text-indigo-900 font-semibold hover:underline"
            >
              Регистрация
            </button>
          </p>
        </form>
      </article>
    </article>
  </article>
</template>
