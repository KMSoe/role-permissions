<template>
    <div>
      <Head title="Banners" />
      <h1 class="mb-8 text-3xl font-bold">Banners</h1>
      <div class="flex items-center justify-between mb-6">
        <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
          <label class="block text-gray-700">Trashed:</label>
          <select v-model="form.trashed" class="form-select mt-1 w-full">
            <option :value="null" />
            <option value="with">With Trashed</option>
            <option value="only">Only Trashed</option>
          </select>
        </search-filter>
        <InertiaLink class="btn-indigo" :href="route('admin.banners.create')">
          <span>Add</span>
        </InertiaLink>
      </div>
    </div>
  </template>
  
  <script>
  import { Head, InertiaLink } from '@inertiajs/inertia-vue3'
  import Layout from '@/Layouts/AdminLayout.vue'
  import pickBy from 'lodash/pickBy'
  import throttle from 'lodash/throttle'
  import mapValues from 'lodash/mapValues'
  import SearchFilter from '@/Shared/SearchFilter'
  
  export default {
    components: {
      Head,
      InertiaLink,
      SearchFilter,
      pickBy
    },
    layout: Layout,
    props: {
      filters: Object,
      contacts: Object,
    },
    data() {
      return {
        form: {
          search: this.filters.search,
          trashed: this.filters.trashed,
        },
      }
    },
    watch: {
      form: {
        deep: true,
        handler: throttle(function () {
          this.$inertia.get(this.route('admin.banners.index'), pickBy(this.form), { preserveState: true })
        }, 150),
      },
    },
    methods: {
      reset() {
        this.form = mapValues(this.form, () => null)
      },
    },
  }
  </script>
  