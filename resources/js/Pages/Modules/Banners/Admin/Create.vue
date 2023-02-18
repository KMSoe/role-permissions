<template>
  <div>
    <Head title="Add Banner" />
    <h1 class="mb-8 text-3xl font-bold">
      <InertiaLink class="text-indigo-400 hover:text-indigo-600" :href="route('admin.banners.index')">Banners</InertiaLink>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="submit">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full" label="Title" />
          <text-area-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full" label="Description" />
          <text-input v-model="form.link" :error="form.errors.link" class="pb-8 pr-6 w-full" label="Link" />
          <file-input v-model="form.image" :error="form.errors.image" class="pb-8 pr-6 w-full" label="Banner Image" />
          <div>
            <input type="checkbox" id="show_banner" class="mr-3" v-model="form.status" />
            <label for="show_banner">Show this Banner</label>
          </div>
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Submit</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, InertiaLink } from '@inertiajs/inertia-vue3'
import Layout from '@/Layouts/AdminLayout.vue'
import TextInput from '@/Shared/TextInput'
import TextAreaInput from '@/Shared/TextareaInput'
import LoadingButton from '@/Shared/LoadingButton'
import FileInput from '@/Shared/FileInput'

export default {
  components: {
    Head,
    InertiaLink,
    TextInput,
    TextAreaInput,
    LoadingButton,
    FileInput,
  },
  layout: Layout,
  data() {
    return {
      form: this.$inertia.form({
        title: '',
        description: '',
        image: null,
        link: '',
        status: true
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('admin.banners.store'))
    },
  },
}
</script>
