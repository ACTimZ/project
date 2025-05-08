<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/axios'

let role = ref("")
let user = ref({})
let message = ref("")
let messageType = ref("")
let isAccepted = ref(false)

user.value = JSON.parse(localStorage.getItem('user'))

onMounted(() => {
  let isAuth = JSON.parse(localStorage.getItem('user') || 'null')
  role.value = isAuth ? isAuth.role : false
})

const submitForm = async () => {
  if (!isAccepted.value) {
    alert("Вы должны принять условия использования.")
    return
  }

  if (!messageType.value) {
    alert("Пожалуйста, выберите тип обращения.")
    return
  }

  if (message.value.length > 100) {
    alert("Сообщение не должно превышать 100 символов.")
    return
  }

  try {
    console.log(messageType.value)
    await axios.post('/appeals', {
      first_name: user.value.first_name,
      last_name: user.value.last_name,
      phone: user.value.phone,
      email: user.value.email,
      type: messageType.value,
      message: message.value
    })

    alert('Обращение успешно отправлено!')
    message.value = ""
    messageType.value = ""
    isAccepted.value = false
  } catch (error) {
    console.error('Ошибка при отправке обращения:', error)
    alert('Произошла ошибка. Пожалуйста, попробуйте позже.')
  }
}
</script>

<template>
  <article class="flex flex-col gap-7.5" v-if="role != 'admin'">
    <h2 class="self-center text-3xl font-bold text-center">Задайте вопрос или оставьте отзыв:</h2>
    <form @submit.prevent="submitForm"
      class="bg-gray-100 xl:mx-60 sm:mx-15 mx-5 rounded-xl flex flex-col gap-5 lg:pt-10 pt-5 pb-7 lg:px-26 px-10">
      <article class="flex flex-row lg:gap-10 gap-4">
        <input type="text" placeholder="Имя" :value="user.first_name"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
          disabled />
        <input type="text" placeholder="Фамилия" :value="user.last_name"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
          disabled />
      </article>
      <article class="flex flex-row lg:gap-10 gap-4">
        <input type="text" :value="user.phone" placeholder="Телефон"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
          disabled />
        <input type="email" placeholder="Почта" :value="user.email"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
          disabled />
      </article>
      <article class="relative">
        <textarea name="" id="" v-model="message"
          class="w-12/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 resize-none focus:bg-white"
          placeholder="Что вы хотели бы написать?">
        </textarea>
        <p class="text-right text-sm mt-1 absolute bottom-2.5 right-2.5 z-50" :class="[message.length <= 100 ? 'text-teal-700' : 'text-red-700']">
          {{ message.length }}/100 символов
        </p>
      </article>
      <article class="flex flex-col md:flex-row gap-4">
        <!-- Левая часть: чекбокс с условиями -->
        <article class="w-full md:w-6/12 flex flex-row items-start gap-5">
          <input type="checkbox" v-model="isAccepted" id="checkbox_form_for_questions"
            class="md:w-5 md:h-5 w-7 h-7 border border-gray-300 rounded-sm text-sky-100 focus:ring-2 focus:ring-sky-100 mt-1.5"
            required />
          <label for="checkbox_form_for_questions" class="text-sm md:text-base leading-tight">
            Принимаю
            <a href="" class="text-amber-600 font-medium">условия использования</a><br />
            и ознакомлен с
            <a href="" class="text-amber-600 font-medium">политикой конфиденциальности</a>
          </label>
        </article>

        <!-- Правая часть: select -->
        <article class="w-full md:w-6/12 flex items-center">
          <select v-model="messageType" id="messageType" name="messageType"
            class="w-full border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md text-gray-700 focus:outline-none focus:border-gray-500 focus:bg-white"
            required>
            <option value="" disabled selected hidden>Хочу отправить как...</option>
            <option value="отзыв">Отзыв</option>
            <option value="вопрос">Вопрос</option>
          </select>
        </article>
      </article>
      <button type="submit"
        class="self-center py-3.5 lg:px-6 md:px-2.5 px-8 bg-orange-100 hover:bg-orange-200 lg:text-lg md:text-md text-lg font-bold text-indigo-900 rounded text-center lg:mt-3 cursor-pointer transition">
        Отправить
      </button>
    </form>
  </article>
</template>
