<script setup>
import { ref } from 'vue'
import ChatModal from '@/components/ModalWindows/ChatModal.vue'
import HeaderComponent from '@/components/Header/HeaderComponent.vue'
import FooterComponent from '@/components/Footer/FooterComponent.vue'

const activeTab = ref('flats')

const tabs = [
  { name: 'Квартиры', key: 'flats' },
  { name: 'Пользователи', key: 'users' },
  { name: 'Чаты', key: 'chats' },
]

const flats = ref([
  { rooms: 2, area: 56, complex: 'Нирвана', price: 5500000 },
  { rooms: 1, area: 35, complex: 'Солнечный берег', price: 3200000 },
])

const users = ref([
  { firstName: 'Иван', lastName: 'Иванов', phone: '+79999999999', email: 'ivan@mail.ru' },
  { firstName: 'Ольга', lastName: 'Петрова', phone: '+78888888888', email: 'olga@mail.ru' },
])

const chats = ref([
  { name: 'Андрей', email: 'andrey@mail.ru', message: 'Здравствуйте!', isRead: true },
  { name: 'Мария', email: 'maria@mail.ru', message: 'Когда будет ответ?', isRead: false },
])

const showChatModal = ref(false)
const selectedChat = ref(null)

function openChat(chat) {
  selectedChat.value = chat
  showChatModal.value = true
}

function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}
</script>

<template>
  <HeaderComponent />
  <ChatModal
    :visible="showChatModal"
    :chatUser="selectedChat"
    :isAdminView="true"
    @close="showChatModal = false"
  />

  <section class="container mx-auto p-4 my-5">
    <!-- Tabs -->
    <article class="flex flex-wrap gap-4 justify-center mb-6">
      <button
        v-for="tab in tabs"
        :key="tab.key"
        @click="activeTab = tab.key"
        :class="[
          'px-4 py-2 rounded-lg text-lg font-semibold transition-colors duration-200 shadow-sm',
          activeTab === tab.key
            ? 'bg-indigo-600 text-white hover:bg-indigo-700'
            : 'bg-indigo-100 text-indigo-900 hover:bg-indigo-200',
        ]"
      >
        {{ tab.name }}
      </button>
    </article>

    <article class="flex flex-col lg:flex-row gap-6">
      <!-- Фильтр только для квартир -->
      <aside
        v-if="activeTab === 'flats'"
        class="w-full lg:w-1/4 bg-white rounded-xl p-4 shadow-md h-fit"
      >
        <h3 class="text-lg font-semibold mb-4">Фильтр</h3>
        <article class="flex flex-col gap-4">
          <input
            type="text"
            placeholder="ЖК"
            class="w-full border border-gray-300 rounded-xl bg-gray-50 p-3 text-md focus:outline-none focus:border-gray-500 focus:bg-white;"
          />
          <input
            type="number"
            placeholder="Количество комнат"
            class="w-full border border-gray-300 rounded-xl bg-gray-50 p-3 text-md focus:outline-none focus:border-gray-500 focus:bg-white;"
          />
          <input
            type="number"
            placeholder="Цена"
            class="w-full border border-gray-300 rounded-xl bg-gray-50 p-3 text-md focus:outline-none focus:border-gray-500 focus:bg-white;"
          />
          <input
            type="number"
            placeholder="Кв. метры"
            class="w-full border border-gray-300 rounded-xl bg-gray-50 p-3 text-md focus:outline-none focus:border-gray-500 focus:bg-white;"
          />
        </article>
      </aside>

      <!-- Таблица данных -->
      <article class="w-full overflow-x-auto">
        <table class="w-full table-auto border-collapse rounded-xl overflow-hidden">
          <thead class="bg-indigo-100 text-indigo-900">
            <tr>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'flats'">Комнаты</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'flats'">Площадь</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'flats'">ЖК</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'flats'">Цена</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'users'">Имя</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'users'">Фамилия</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'users'">Телефон</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'users'">Почта</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'chats'">Имя</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'chats'">Почта</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'chats'">Сообщение</th>
              <th class="px-4 py-3 text-left" v-if="activeTab === 'chats'">Статус</th>
              <th class="px-4 py-3 text-left">Действия</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(item, index) in activeTab === 'flats'
                ? flats
                : activeTab === 'users'
                  ? users
                  : chats"
              :key="index"
              class="border-b last:border-0 hover:bg-gray-50"
            >
              <!-- Flats -->
              <td class="px-4 py-3" v-if="activeTab === 'flats'">{{ item.rooms }}</td>
              <td class="px-4 py-3" v-if="activeTab === 'flats'">{{ item.area }}</td>
              <td class="px-4 py-3" v-if="activeTab === 'flats'">{{ item.complex }}</td>
              <td class="px-4 py-3" v-if="activeTab === 'flats'">
                {{ numberWithSpaces(item.price) }} ₽
              </td>

              <!-- Users -->
              <td class="px-4 py-3" v-if="activeTab === 'users'">{{ item.firstName }}</td>
              <td class="px-4 py-3" v-if="activeTab === 'users'">{{ item.lastName }}</td>
              <td class="px-4 py-3" v-if="activeTab === 'users'">{{ item.phone }}</td>
              <td class="px-4 py-3" v-if="activeTab === 'users'">{{ item.email }}</td>

              <!-- Chats -->
              <td class="px-4 py-3" v-if="activeTab === 'chats'">{{ item.name }}</td>
              <td class="px-4 py-3" v-if="activeTab === 'chats'">{{ item.email }}</td>
              <td class="px-4 py-3" v-if="activeTab === 'chats'">{{ item.message }}</td>
              <td class="px-4 py-3" v-if="activeTab === 'chats'">
                <span
                  :class="item.isRead ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800'"
                  class="px-2 py-1 rounded-lg text-sm"
                >
                  {{ item.isRead ? 'Прочитано' : 'Не прочитано' }}
                </span>
              </td>

              <!-- Actions -->
              <td class="px-4 py-3 flex gap-2">
                <template v-if="activeTab === 'flats'">
                  <button
                    class="px-3 py-1 rounded-md bg-red-100 text-red-800 text-sm hover:bg-red-200 transition-colors duration-200 shadow-sm"
                  >
                    Удалить
                  </button>

                  <button
                    class="px-3 py-1 rounded-md bg-yellow-100 text-yellow-800 text-sm hover:bg-yellow-200 transition-colors duration-200 shadow-sm"
                  >
                    Редактировать
                  </button>
                  <button
                    class="px-3 py-1 rounded-md bg-indigo-100 text-indigo-800 text-sm hover:bg-indigo-200 transition-colors duration-200 shadow-sm"
                  >
                    Просмотр
                  </button>
                </template>
                <template v-else-if="activeTab === 'users'">
                  <button
                    class="px-3 py-1 rounded-md bg-red-100 text-red-800 text-sm hover:bg-red-200 transition-colors duration-200 shadow-sm"
                  >
                    Удалить
                  </button>
                </template>
                <template v-else-if="activeTab === 'chats'">
                  <button
                    @click="openChat(item)"
                    class="px-3 py-1 rounded-md bg-indigo-100 text-indigo-800 text-sm hover:bg-indigo-200 transition-colors duration-200 shadow-sm"
                  >
                    Взаимодействовать
                  </button>
                </template>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Прогрузить еще -->
        <article class="text-center mt-6">
          <button
            class="text-lg font-semibold text-indigo-900 hover:text-indigo-700 transition duration-200 hover:underline"
          >
            Прогрузить еще
          </button>
        </article>
      </article>
    </article>
  </section>
  <FooterComponent />
</template>
