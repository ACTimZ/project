<template>
  <article class="flex flex-col gap-7.5">
    <h2 class="self-center text-3xl font-bold text-center">Задайте вопрос или оставьте отзыв:</h2>
    <form
      action=""
      class="bg-gray-100 xl:mx-60 sm:mx-15 mx-5 rounded-xl flex flex-col gap-5 lg:pt-10 pt-5 pb-7 lg:px-26 px-10"
    >
      <article class="flex flex-row lg:gap-10 gap-4">
        <input
          type="text"
          placeholder="Имя"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
        />
        <input
          type="text"
          placeholder="Фамилия"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
        />
      </article>
      <article class="flex flex-row lg:gap-10 gap-4">
        <input
          type="text"
          placeholder="Телефон"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
        />
        <input
          type="email"
          placeholder="Почта"
          class="w-6/12 border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 focus:bg-white"
        />
      </article>
      <textarea
        name=""
        id=""
        class="border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md focus:outline-none focus:border-gray-500 resize-none focus:bg-white"
        placeholder="Что вы хотели бы написать?"
      ></textarea>
      <article class="flex flex-col md:flex-row gap-4">
        <!-- Левая часть: чекбокс с условиями -->
        <article class="w-full md:w-6/12 flex flex-row items-start gap-5">
          <input
            type="checkbox"
            id="checkbox_form_for_questions"
            class="md:w-5 md:h-5 w-7 h-7 border border-gray-300 rounded-sm text-sky-100 focus:ring-2 focus:ring-sky-100 mt-1.5"
            required
          />
          <label for="checkbox_form_for_questions" class="text-sm md:text-base leading-tight">
            Принимаю
            <a href="" class="text-amber-600 font-medium">условия использования</a><br />
            и ознакомлен с
            <a href="" class="text-amber-600 font-medium">политикой конфиденциальности</a>
          </label>
        </article>

        <!-- Правая часть: select -->
        <article class="w-full md:w-6/12 flex items-center">
          <select
            id="messageType"
            name="messageType"
            class="w-full border-1 border-gray-300 rounded-xl bg-gray-50 p-5 text-md text-gray-700 focus:outline-none focus:border-gray-500 focus:bg-white"
            required
          >
            <option value="" disabled selected hidden>Хочу отправить как...</option>
            <option value="отзыв">Отзыв</option>
            <option value="вопрос">Вопрос</option>
          </select>
        </article>
      </article>
      <button
        type="submit"
        class="self-center py-3.5 lg:px-6 md:px-2.5 px-8 bg-orange-100 lg:text-lg md:text-md text-lg font-bold text-indigo-900 rounded text-center lg:mt-3"
      >
        Отправить
      </button>
    </form>
  </article>
</template>
