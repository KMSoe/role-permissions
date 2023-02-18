<template>
  <div>
    <Head title="Game Shop" />
    
  </div>
</template>
<script>
import { Head } from '@inertiajs/inertia-vue3'
import Layout from '@/Layouts/SiteLayout.vue'

export default {
  components: {
    Head,
  },
  layout: Layout,
  props: {
    banners: Object,
    popular_products: Object,
    categories: Object,
    payment_methods: Object,
  },
  data() {
    return {}
  },
}
</script>
