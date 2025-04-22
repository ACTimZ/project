<script setup>
import BlockOurRecomendationsComponent from '@/components/BlockOurRecomendations/BlockOurRecomendationsComponent.vue'
import FAQComponent from '@/components/FAQ/FAQComponent.vue'
import FormForSendingQuestionComponent from '@/components/DoUserHaveAnyQuestionsForm/FormForSendingQuestionComponent.vue'
import SectionReviewsCardsComponent from '@/components/ReviewsCards/SectionReviewsCardsComponent.vue'
import WelcomeBlockComponent from '@/components/WelcomeFirstBlock/WelcomeBlockComponent.vue'
import HeaderComponent from '@/components/Header/HeaderComponent.vue'
import FooterComponent from '@/components/Footer/FooterComponent.vue'
</script>

<template>
  <HeaderComponent />
  <main class="flex flex-col">
    <WelcomeBlockComponent />
    <h1
      id="main_preimushestva"
      class="flex self-center xl:text-3xl lg:text-xl md:text-md text-lg font-medium mt-12 mb-8.75"
    >
      Наши рекомендации и советы
    </h1>
    <BlockOurRecomendationsComponent />
    <h1
      id="main_reviews"
      class="flex self-center xl:text-3xl lg:text-xl md:text-md text-lg font-medium mt-12 mb-8.75"
    >
      Отзывы
    </h1>
    <SectionReviewsCardsComponent />
    <h1
      id="main_faq"
      class="flex self-center xl:text-3xl lg:text-xl md:text-md text-lg font-medium mt-12"
    >
      Ответы на вопросы
    </h1>
    <FAQComponent />
    <h1
      id="main_form_for_sending_questions"
      class="flex self-center xl:text-3xl lg:text-xl md:text-md text-lg font-medium mt-6 mb-8.75"
    >
      Возникли другие вопросы?
    </h1>
    <FormForSendingQuestionComponent />
    <h1
      id="main_map"
      class="flex self-center xl:text-3xl lg:text-xl md:text-md text-lg font-medium mt-12 mb-8.75"
    >
      Мы на карте
    </h1>
    <div class="self-center w-12/12 lg:mb-25 mb-10 flex flex-row justify-center">
      <iframe
        class="2xl:h-150 xl:h-120 lg:h-90 md:h-60 h-90 lg:w-12/12 sm:w-8/12 w-11/12"
        src="https://yandex.ru/map-widget/v1/?ll=31.272892%2C58.524143&z=15.68"
        height=""
        allowfullscreen="true"
        style="position: relative"
      ></iframe>
    </div>
  </main>
  <FooterComponent />
</template>
