<script setup>
import { ref } from 'vue'
import axios from '@/axios'

let firstName = ref('')
let lastName = ref('')
let phone = ref('')
let email = ref('')
let message = ref('')
let isAccepted = ref(false)

let submitForm = async () => {
  if (!isAccepted.value) {
    alert('Вы должны принять условия использования!')
    return
  }

  if (message.value.length > 100) {
    alert("Сообщение не должно превышать 100 символов!")
    return
  }

  try {
    await axios.post('/appeals', {
      first_name: firstName.value,
      last_name: lastName.value,
      phone: phone.value,
      email: email.value,
      type: 'вопрос',
      message: message.value
    })
    alert('Форма успешно отправлена!')
    firstName.value = ''
    lastName.value = ''
    phone.value = ''
    email.value = ''
    message.value = ''
    isAccepted.value = false
  } catch (error) {
    console.error('Ошибка при отправке формы:', error)

    if (error.response?.status === 422) {
      console.error('Ошибки валидации:', error.response.data.errors)
      alert('Форма заполнена неверно. Проверьте поля.')
    } else {
      alert('Произошла ошибка при отправке. Попробуйте позже.')
    }
  }
}
</script>
<template>
  <section class="container mx-auto">
    <form @submit.prevent="submitForm"
      class="bg-sky-50 xl:mx-60 sm:mx-15 mx-5 rounded-xl flex flex-col gap-5 lg:pt-10 pt-5 pb-7 lg:px-26 px-10">
      <article class="flex flex-row lg:gap-10 gap-4">
        <input type="text" v-model="firstName" placeholder="Имя"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white" />
        <input type="text" v-model="lastName" placeholder="Фамилия"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white" />
      </article>
      <article class="flex flex-row lg:gap-10 gap-4">
        <input type="text" v-model="phone" placeholder="Телефон"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white" />
        <input type="email" v-model="email" placeholder="Почта"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white" />
      </article>
      <article class="relative">
        <textarea name="" id=""
          class="w-12/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 resize-none focus:bg-white"
          v-model="message" placeholder="Что вы хотели бы написать?"></textarea>
          <p class="text-right text-sm mt-1 absolute bottom-2.5 right-2.5 z-50" :class="[message.length <= 100 ? 'text-teal-700' : 'text-red-700']">
            {{ message.length }}/100 символов
          </p>
      </article>
      <article class="">
        <article class="lg:ms-7.5 ms-3 flex flex-row items-center gap-5">
          <input type="checkbox" v-model="isAccepted" id="checkbox_form_for_questions"
            class="md:w-5 md:h-5 w-7 h-7 border border-gray-300 rounded-sm text-sky-100 focus:ring-2 focus:ring-sky-100"
            required />
          <label for="checkbox_form_for_questions" class="text-sm md:text-base">
            Принимаю <a href="" class="text-amber-600 font-medium">условия использования</a> <br />
            и ознакомлен с
            <a href="" class="text-amber-600 font-medium">политикой конфиденциальности</a>
          </label>
        </article>
      </article>
      <button type="submit"
        class="self-center py-3.5 lg:px-6 md:px-2.5 px-8 bg-orange-100 lg:text-lg md:text-md text-lg font-bold text-indigo-900 rounded text-center">
        Отправить
      </button>
    </form>
  </section>
</template>
