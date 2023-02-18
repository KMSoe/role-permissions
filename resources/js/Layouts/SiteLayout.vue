<template>
  <div>
    <Navbar />
    <div class="mx-auto pt-32 px-4 w-full md:px-10">
      <flash-messages />
      <slot />
      <Footer />
    </div>
  </div>
</template>
<script>
import FlashMessages from '@/Shared/FlashMessages'
import Navbar from '@/Components/Navbars/SiteNavbar.vue'
import Footer from '@/Components/Footers/SiteFooter.vue'

export default {
  components: {
    FlashMessages,
    Navbar,
    Footer
  },
}
</script>