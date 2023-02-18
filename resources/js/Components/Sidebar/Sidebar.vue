<template>
  <nav class="relative z-10 flex flex-wrap items-center justify-between px-6 py-4 bg-white shadow-xl md:fixed md:bottom-0 md:left-0 md:top-0 md:block md:flex-row md:flex-nowrap md:w-64 md:overflow-hidden md:overflow-y-auto">
    <div class="flex flex-wrap items-center justify-between mx-auto px-0 w-full md:flex-col md:flex-nowrap md:items-stretch md:min-h-full">
      <!-- Toggler -->
      <button class="px-3 py-1 text-black text-xl leading-none bg-transparent border border-solid border-transparent rounded opacity-50 cursor-pointer md:hidden" type="button" v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')">
        <i class="fas fa-bars"></i>
      </button>
      <!-- Brand -->
      <InertiaLink class="text-blueGray-600 inline-block mr-0 p-4 px-0 text-left whitespace-nowrap text-sm font-bold uppercase md:block md:pb-2" href="/"> Game Shop </InertiaLink>
      <!-- User -->
      <ul class="flex flex-wrap items-center list-none md:hidden">
        <li class="relative inline-block">
          <notification-dropdown />
        </li>
        <li class="relative inline-block">
          <user-dropdown />
        </li>
      </ul>
      <!-- Collapse -->
      <div class="absolute z-40 left-0 right-0 top-0 flex-1 items-center h-auto rounded shadow overflow-x-hidden overflow-y-auto md:relative md:flex md:flex-col md:items-stretch md:mt-4 md:shadow-none md:opacity-100" v-bind:class="collapseShow">
        <!-- Collapse header -->
        <div class="border-blueGray-200 block mb-4 pb-4 border-b border-solid md:hidden md:min-w-full">
          <div class="flex flex-wrap">
            <div class="w-6/12">
              <InertiaLink class="text-blueGray-600 inline-block mr-0 p-4 px-0 text-left whitespace-nowrap text-sm font-bold uppercase md:block md:pb-2" href="/"> Vue Notus </InertiaLink>
            </div>
            <div class="flex justify-end w-6/12">
              <button type="button" class="px-3 py-1 text-black text-xl leading-none bg-transparent border border-solid border-transparent rounded opacity-50 cursor-pointer md:hidden" v-on:click="toggleCollapseShow('hidden')">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        <form class="mb-4 mt-6 md:hidden">
          <div class="mb-3 pt-0">
            <input type="text" placeholder="Search" class="border-blueGray-500 placeholder-blueGray-300 text-blueGray-600 px-3 py-2 w-full h-12 text-base font-normal leading-snug bg-white border border-solid rounded outline-none focus:outline-none shadow-none" />
          </div>
        </form>

        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->

        <!-- Navigation -->

        <ul class="flex flex-col list-none md:flex-col md:min-w-full">
          <li class="items-center">
            <inertia-link :href="route('dashboard')" class="block py-3 text-xs font-bold uppercase">
              <i class="fas fa-tv mr-2 text-sm" :class="[isActive ? 'opacity-75' : 'text-blueGray-300']"></i>
              Dashboard
            </inertia-link>
          </li>

         
          <li class="items-center">
            <Link href="/logout" method="delete" as="button" class="block py-3 text-xs font-bold cursor-pointer uppercase">
              <i class="fas fa-map-marked mr-2 text-sm"></i>
              Logout
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
); }

<script>
import NotificationDropdown from '@/Components/Dropdowns/NotificationDropdown.vue'
import UserDropdown from '@/Components/Dropdowns/UserDropdown.vue'
import { InertiaLink, Link } from '@inertiajs/inertia-vue3'

export default {
  components: {
    NotificationDropdown,
    UserDropdown,
    InertiaLink,
    Link,
  },
  data() {
    return {
      collapseShow: 'hidden',
      isActive: false,
    }
  },
  methods: {
    toggleCollapseShow: function (classes) {
      this.collapseShow = classes
    },
    logout() {
      router.delete('/logout')
    },
  },
}
</script>
