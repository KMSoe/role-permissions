<template>
  <nav class="px-2 py-2.5 dark:bg-gray-900 bg-white border-gray-200 rounded sm:px-4">
    <div class="container flex flex-wrap items-center justify-between mx-auto">
      <a href="https://flowbite.com/" class="flex items-center">
        <img src="https://flowbite.com/docs/images/logo.svg" class="mr-3 h-6 sm:h-9" alt="Flowbite Logo" />
        <span class="self-center dark:text-white whitespace-nowrap text-xl font-semibold">Flowbite</span>
      </a>
      <div class="flex md:order-2">
        <button type="button" class="bg-indigo-800 hover:bg-indigo-800 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-800 dark:focus:ring-indigo-800 mr-3 px-5 py-2.5 text-center text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-4 md:mr-0">Get started</button>
        <button data-collapse-toggle="navbar-cta" type="button" class="dark:hover:bg-gray-700 dark:focus:ring-gray-600 inline-flex items-center p-2 dark:text-gray-400 text-gray-500 text-sm hover:bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 md:hidden" aria-controls="navbar-cta" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
        </button>
      </div>
      <div class="hidden items-center justify-between w-full md:flex md:order-1 md:w-auto" id="navbar-cta">
        <ul class="md:dark:bg-gray-900 flex flex-col mt-4 p-4 bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-lg md:flex-row md:mt-0 md:text-sm md:font-medium md:bg-white md:border-0 md:space-x-8">
          <li>
            <a href="#" class="bg-indigo-800 md:text-indigo-700 block pl-3 pr-4 py-2 text-white dark:text-white rounded md:p-0 md:bg-transparent" aria-current="page">Home</a>
          </li>
          <li>
            <a href="#" class="dark:hover:bg-gray-700 dark:hover:text-white md:hover:bg-transparent md:hover:text-indigo-700 md:dark:hover:text-white md:dark:hover:bg-transparent block pl-3 pr-4 py-2 dark:text-gray-400 text-gray-700 hover:bg-gray-100 dark:border-gray-700 rounded md:p-0">About</a>
          </li>
          <li>
            <a href="#" class="dark:hover:bg-gray-700 dark:hover:text-white md:hover:bg-transparent md:hover:text-indigo-700 md:dark:hover:text-white md:dark:hover:bg-transparent block pl-3 pr-4 py-2 dark:text-gray-400 text-gray-700 hover:bg-gray-100 dark:border-gray-700 rounded md:p-0">Services</a>
          </li>
          <li>
            <a href="#" class="dark:hover:bg-gray-700 dark:hover:text-white md:hover:bg-transparent md:hover:text-indigo-700 md:dark:hover:text-white md:dark:hover:bg-transparent block pl-3 pr-4 py-2 dark:text-gray-400 text-gray-700 hover:bg-gray-100 dark:border-gray-700 rounded md:p-0">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
