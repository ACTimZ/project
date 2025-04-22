<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  visible: Boolean,
  chatUser: Object,
  isAdminView: { type: Boolean, default: true },
  initialMessage: String,
})

const emit = defineEmits(['close', 'send'])

const messages = ref([
  { text: 'Здравствуйте! Вы оставляли заявку. Это так?', isAdmin: false },
  { text: 'Здравствуйте! Да, все верно', isAdmin: true },
])

const newMessage = ref('')

watch(
  [() => props.visible, () => props.initialMessage],
  ([visible, initialMessage]) => {
    if (visible && initialMessage) {
      newMessage.value = initialMessage
    }
  },
  { immediate: true },
)

function close() {
  emit('close')
}

function sendMessage() {
  if (newMessage.value.trim()) {
    messages.value.push({ text: newMessage.value, isAdmin: true })
    emit('send', newMessage.value)
    newMessage.value = ''
  }
}
</script>

<template>
  <article v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <article
      class="bg-white w-full max-w-2xl rounded-xl shadow-lg p-4 relative flex flex-col h-[80vh]"
    >
      <!-- Header -->
      <article class="flex items-center justify-between border-b pb-3 mb-3">
        <article class="flex items-center gap-2">
          <article class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
            <img src="../icons/HeadSet.svg" alt="Avatar" class="w-6 h-6" />
          </article>
          <h2 class="text-lg font-semibold">
            <!-- {{ isAdminView ? `${chatUser.firstName} ${chatUser.lastName}` : 'Тех. поддержка' }} -->

            {{ isAdminView ? 'Пользователь' : 'Тех. поддержка' }}
          </h2>
        </article>
        <button @click="close" class="text-xl text-gray-500 hover:text-black">&times;</button>
      </article>

      <!-- Messages -->
      <article class="flex-1 overflow-y-auto space-y-4 px-1">
        <article
          v-for="(message, index) in messages"
          :key="index"
          class="flex"
          :class="message.isAdmin ? 'justify-end' : 'justify-start'"
        >
          <article
            class="max-w-[75%] px-4 py-2 rounded-xl text-sm"
            :class="
              message.isAdmin
                ? 'bg-blue-200 text-black text-right'
                : 'bg-blue-600 text-white text-left'
            "
          >
            <article class="font-bold mb-1" v-if="!message.isAdmin">Тех. поддержка</article>
            <article class="font-bold mb-1" v-else>Вы</article>
            <p>{{ message.text }}</p>
          </article>
        </article>
      </article>

      <!-- Input -->
      <form @submit.prevent="sendMessage" class="flex items-center gap-2 mt-4 pt-3 border-t">
        <input
          v-model="newMessage"
          type="text"
          placeholder="Введите текст"
          class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:border-indigo-500 bg-gray-50"
        />
        <button
          type="submit"
          class="px-4 py-2 rounded-full bg-indigo-500 text-white hover:bg-indigo-600 transition"
        >
          Отправить
        </button>
      </form>
    </article>
  </article>
</template>
