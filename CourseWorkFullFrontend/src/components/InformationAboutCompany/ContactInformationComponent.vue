<script setup>
import AnotherInformationLastBlockComponent from './AnotherUIBindingComponents/AnotherInformationLastBlockComponent.vue'
import ContactsCompanyFirstBlockComponent from './AnotherUIBindingComponents/ContactsCompanyFirstBlockComponent.vue'
import HowToContactUsCardsComponent from './AnotherUIBindingComponents/HowToContactUsCardsComponent.vue'
import RequisitesComponent from './AnotherUIBindingComponents/RequisitesComponent.vue'
</script>

<template>
  <section class="container mx-auto">
    <article class="md:mx-25 mb-15 mx-10 mt-6 flex flex-col lg:gap-10 md:gap-3">
      <h1 id="information_contacts" class="self-center font-bold lg:text-3xl text-2xl">
        Контактная информация
      </h1>
      <article class="flex flex-col lg:gap-17.5 gap-10">
        <ContactsCompanyFirstBlockComponent />
        <HowToContactUsCardsComponent />
        <RequisitesComponent />
        <AnotherInformationLastBlockComponent />
      </article>
    </article>
  </section>
</template>
