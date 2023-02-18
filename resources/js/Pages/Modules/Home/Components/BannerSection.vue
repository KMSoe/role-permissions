<template>
  <div id="default-carousel" class="relative" data-carousel="static">
    <!-- Carousel wrapper -->
    <div class="relative h-56 rounded-lg overflow-hidden md:h-96">
      <!-- Item 1 -->
      <div v-for="item in items" :key="item.id" class="hidden duration-700 ease-in-out" data-carousel-item>
        <span class="absolute left-1/2 top-1/2 dark:text-gray-800 text-white text-2xl font-semibold -translate-x-1/2 -translate-y-1/2 sm:text-3xl">{{ item.title }}</span>
        <img :src="item.image" class="absolute left-1/2 top-1/2 block w-full -translate-x-1/2 -translate-y-1/2" :alt="item.title" />
      </div>
    
    </div>
    <!-- Slider indicators -->
    <div class="absolute z-30 bottom-5 left-1/2 flex -translate-x-1/2 space-x-3">
      <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 1" data-carousel-slide-to="0"></button>
      <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
      <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
    </div>
    <!-- Slider controls -->
    <button type="button" class="group absolute z-30 left-0 top-0 flex items-center justify-center px-4 h-full focus:outline-none cursor-pointer" data-carousel-prev>
      <span class="bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 inline-flex items-center justify-center w-8 h-8 rounded-full group-focus:outline-none group-focus:ring-4 group-focus:ring-white sm:w-10 sm:h-10">
        <svg aria-hidden="true" class="w-5 h-5 dark:text-gray-800 text-white sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        <span class="sr-only">Previous</span>
      </span>
    </button>
    <button type="button" class="group absolute z-30 right-0 top-0 flex items-center justify-center px-4 h-full focus:outline-none cursor-pointer" data-carousel-next>
      <span class="bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70 inline-flex items-center justify-center w-8 h-8 rounded-full group-focus:outline-none group-focus:ring-4 group-focus:ring-white sm:w-10 sm:h-10">
        <svg aria-hidden="true" class="w-5 h-5 dark:text-gray-800 text-white sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        <span class="sr-only">Next</span>
      </span>
    </button>
  </div>
</template>
<script>
export default {
  props: {
    items: Object
  }
}
</script>
