<script setup>
import { ref } from 'vue'
import ChatModal from '@/components/ModalWindows/ChatModal.vue'

let msgs = ref([
  { message: 'Здравствуйте!', isAnswered: true, name: 'Иван Иванов', email: 'ivan@mail.ru' },
  {
    message: 'Окей, как скажите!',
    isAnswered: true,
    name: 'Мария Смирнова',
    email: 'maria@mail.ru',
  },
  { message: '', isAnswered: false, name: 'Павел Орлов', email: 'pavel@mail.ru' },
])

let showChatModal = ref(false)
let selectedChat = ref(null)

function openChat(chat) {
  selectedChat.value = chat
  showChatModal.value = true
}
</script>

<template>
  <ChatModal
    :visible="showChatModal"
    :chatUser="selectedChat"
    :isAdminView="true"
    @close="showChatModal = false"
  />

  <article class="flex flex-col">
    <h2 class="font-bold lg:text-3xl sm:text-2xl text-lg self-center mb-5">Обращения</h2>

    <article class="relative overflow-x-auto">
      <table class="w-full table-fixed">
        <thead class="text-lg uppercase text-gray-500">
          <tr>
            <th class="px-4 py-3 w-[10%] text-center">№</th>
            <th class="px-4 py-3 w-[65%] text-center">Сообщение</th>
            <th class="px-4 py-3 w-[15%] text-center">Статус</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(msg, index) in msgs"
            :key="index"
            class="bg-stone-100 border-b-15 border-white"
          >
            <td class="px-4 py-7 text-xl text-center font-medium text-gray-900">
              <button @click="openChat(msg)" class="w-full cursor-pointer">
                {{ index + 1 }}
              </button>
            </td>
            <td class="px-4 py-7 text-center">
              <button
                @click="openChat(msg)"
                class="w-[60%] truncate overflow-hidden text-ellipsis whitespace-nowrap cursor-pointer"
              >
                {{ msg.message === '' ? 'Ваше сообщение' : msg.message }}
              </button>
            </td>
            <td class="text-center">
              <button
                @click="openChat(msg)"
                class="px-5 py-3 text-sm rounded-xl font-medium cursor-pointer transition"
                :class="
                  msg.isAnswered ? 'bg-green-300 text-green-900' : 'bg-gray-300 text-gray-900'
                "
              >
                {{ msg.isAnswered ? 'Отвечено' : 'Отправлено' }}
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </article>

    <button
      class="text-xl font-medium cursor-pointer hover:bg-indigo-100 self-center py-3 px-5 rounded-xl transition"
    >
      Прогрузить еще чаты
    </button>
  </article>
</template>
