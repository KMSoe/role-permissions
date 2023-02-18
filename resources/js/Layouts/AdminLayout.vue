<template>
  <div>
    <sidebar />
    <div class="bg-blueGray-100 md:ml-64">
      <!-- <admin-navbar /> -->
      <div class="mx-auto pt-32 px-4 w-full md:px-10">
        <flash-messages />
        <slot />
        <footer-admin />
      </div>
    </div>
  </div>
</template>
<script>
import AdminNavbar from '@/Components/Navbars/AdminNavbar.vue'
import Sidebar from '@/Components/Sidebar/Sidebar.vue'
import FooterAdmin from '@/Components/Footers/FooterAdmin.vue'
import FlashMessages from '@/Shared/FlashMessages'

export default {
  name: 'admin-layout',
  components: {
    AdminNavbar,
    Sidebar,
    FooterAdmin,
    FlashMessages,
  },
}
</script>
