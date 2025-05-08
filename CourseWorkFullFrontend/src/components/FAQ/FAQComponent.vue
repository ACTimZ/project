<script setup>
import { ref } from 'vue'

let faqs = ref({
  'Вопросы о недвижимости': {
    'Как забронировать квартиру?': {
      answer:
        'Обратитесь в наш отдел продаж по телефону, на сайте или лично. Выберите квартиру, и мы оформим договор бронирования с задатком.',
      open: false,
    },
    'Тип жилья вы какой предоставляете?': {
      answer:
        'Предлагаем студии, однокомнатные, двух- и трехкомнатные квартиры, включая варианты с улучшенной планировкой и отделкой.',
      open: false,
    },
    'Какое количество этажей в среднем в каждом доме?': {
      answer:
        'В среднем от 3 до 12 этажей в жилых комплексах, с учетом удобства, безопасности и освещения.',
      open: false,
    },
  },

  'Вопросы о сайте': {
    'Как посмотреть ваши варианты квартир?': {
      answer:
        'Вы можете ознакомиться с нашими вариантами на сайте, где представлены планы и фотографии квартир, или записаться на просмотр, чтобы увидеть жилье вживую.',
      open: false,
    },
    'Как с вами связаться?': {
      answer:
        'Связаться с нами можно по телефону, через электронную почту, заполнив форму обратной связи на сайте или посетив наш офис.',
      open: false,
    },
    'Когда вы ответите?': {
      answer:
        'Мы стараемся ответить на все запросы в течение 24 часов. В экстренных случаях вы можете позвонить и получить ответ быстрее.',
      open: false,
    },
  },

  'Вопросы о качестве': {
    'Как вы относитесь к клиентам?': {
      answer:
        'Мы ценим клиентов, всегда готовы помочь и обеспечиваем индивидуальный подход к каждому.',
      open: false,
    },
    'Как долго будут существовать дома, построенные вами?': {
      answer:
        'Наши дома прослужат десятилетия, мы используем только качественные и проверенные материалы.',
      open: false,
    },
    'Ваша недвижимость проходит какие-нибудь экспертные проверки на качество?': {
      answer:
        'Да, каждая наша недвижимость проходит строгие экспертные проверки качества и безопасности.',
      open: false,
    },
  },
})

let toggle = (category, question) => {
  faqs.value[category][question].open = !faqs.value[category][question].open
}
</script>

<template>
  <article class="max-w-7xl mx-auto px-4 py-8">
    <article class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
      <article
        v-for="(questions, category) in faqs"
        :key="category"
        class="bg-indigo-50 rounded-xl p-8 shadow-sm"
      >
        <h2 class="text-xl font-semibold mb-4">{{ category }}</h2>

        <article class="space-y-2">
          <article v-for="(item, question) in questions" :key="question" class="rounded-lg">
            <button
              class="w-full flex items-start justify-between gap-2 py-2 px-3 hover:bg-indigo-100 rounded-lg"
              @click="toggle(category, question)"
            >
              <article class="flex items-start gap-3">
                <!-- стрелка -->
                <img
                  src="../icons/Arrow_for_faq.svg"
                  alt=""
                  :class="[
                    'w-4 h-4 mt-1 transition-transform duration-300',
                    item.open ? 'rotate-90' : 'rotate-0',
                  ]"
                />

                <span class="text-sm text-left font-medium">
                  {{ question }}
                </span>
              </article>
            </button>

            <transition name="fade">
              <article v-if="item.open" class="pl-7 pr-3 pb-3 text-sm text-gray-700">
                {{ item.answer }}
              </article>
            </transition>
          </article>
        </article>
      </article>
    </article>
  </article>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-4px);
}
</style>
