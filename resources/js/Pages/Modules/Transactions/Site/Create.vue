<template>
  <div>
    <Head title="Transfer Balance" />
    <!-- <section>
      <div class="container mx-auto">
        <div class="flex flex-col space-y-8">
          <CardStep :step="1" title="လက်ခံသူ">
            <div v-if="form.receiver_id">
              <div class="py-3 cursor-pointer sm:py-4">
                <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                    <img class="w-8 h-8 rounded-full" :src="receiver.photo" :alt="receiver.name" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-gray-900 dark:text-white text-sm font-medium truncate">{{ receiver.name }}</p>
                    <p class="dark:text-gray-400 text-gray-500 text-sm truncate">{{ receiver.email }}</p>
                  </div>
                </div>
              </div>
            </div>
            <div v-else>
              <form @submit.prevent="searchUser" class="flex items-end pb-8 pr-6 w-full space-x-2 lg:w-1/2">
                <text-input v-model="searchForm.search" :error="searchForm.errors.search" class="" label="Name or Email or Phone" placeholder="Search by name or email or phone" />
                <loading-button :loading="form.processing" class="btn-indigo" type="submit">Search</loading-button>
              </form>

              <div class="w-full max-w-md dark:bg-gray-800 bg-white border border-gray-200 dark:border-gray-700 rounded-lg shadow">
                <div class="flow-root" v-if="users.length">
                  <ul role="list" class="divide-gray-200 dark:divide-gray-700 divide-y">
                    <li class="py-3 cursor-pointer sm:py-4" v-for="user in users" :key="user.id" @click.prevent="selectReceiver(user)">
                      <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                          <img class="w-8 h-8 rounded-full" :src="user.photo" :alt="user.name" />
                        </div>
                        <div class="flex-1 min-w-0">
                          <p class="text-gray-900 dark:text-white text-sm font-medium truncate">{{ user.name }}</p>
                          <p class="dark:text-gray-400 text-gray-500 text-sm truncate">{{ user.email }}</p>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="my-4">
              <input type="checkbox" id="phone_needed" class="mr-3" v-model="phone_needed" />
              <label for="phone_needed">Need SMS Notification to receiver?</label>
            </div>
            <text-input v-if="phone_needed" v-model="form.user_phone" :error="form.errors.user_phone" class="pb-8 pr-6 w-full lg:w-1/2" label="ဖုန်းနံပါတ်ကိုထည့်သွင်းပါ။" />
          </CardStep>
          <CardStep :step="2" title="Amount">
            <text-input v-model="form.amount" :error="form.errors.amount" class="pb-8 pr-6 w-full lg:w-1/2" label="Enter Transfer Amount" />
          </CardStep>
          <CardStep :step="3" title="ဆက်သွယ်ရန်">
            <div class="flex flex-col">
              <p class="mb-4 font-thin">မှတ်ချက်။ ။ဝယ်ယူမှုလုပ်ငန်းစဉ်မှတ်တမ်း ရရှိလိုလျင် Gmailလိပ်စာ ထည့်ပေးပါ။</p>
              <form @submit.prevent="submit">
                <text-input v-model="form.user_email" :error="form.errors.user_email" class="pb-8 pr-6 w-full lg:w-1/2" label="" />

                <text-area-input v-model="form.note" :error="form.errors.note" class="pb-8 pr-6 w-full lg:w-1/2" label="Note" />
                <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
                  <loading-button :loading="form.processing" class="btn-indigo" type="submit">Submit</loading-button>
                </div>
              </form>
            </div>
          </CardStep>
        </div>
      </div>
    </section> -->
  </div>
</template>
<script>
import Layout from '@/Layouts/SiteLayout.vue'
import { Head, InertiaLink } from '@inertiajs/inertia-vue3'
// import PaymentMethodCard from '../../PaymentMethods/Components/PaymentMethodCard.vue'
// import CardStep from '../../../../Components/Cards/CardStep.vue'
import TextInput from '@/Shared/TextInput'
import TextAreaInput from '@/Shared/TextareaInput'
import LoadingButton from '@/Shared/LoadingButton'
import FileInput from '@/Shared/FileInput'
import { router } from '@inertiajs/vue3'

export default {
  components: {
    Head,
    TextInput,
    TextAreaInput,
    FileInput,
    LoadingButton,
  },
  layout: Layout,
  props: {
    auth: Object,
    filters: Object,
    users: Object,
  },
  data() {
    return {
      phone_needed: false,
      searchForm: this.$inertia.form({
        search: this.filters.search,
      }),
      receiver: {
        id: '',
        name: '',
        email: '',
        phone: '',
        photo: '',
      },
      form: this.$inertia.form({
        receiver_id: '',
        amount: '',
        note: '',
        user_email: this.auth.user.email,
      }),
    }
  },

  methods: {
    submit() {
      this.form.post(this.route('transactions.store'))
    },
    selectReceiver(user) {
      this.form.receiver_id = user.id
      this.receiver.id = user.id
      this.receiver.name = user.name
      this.receiver.email = user.email
      this.receiver.phone = user.phone
      this.receiver.photo = user.photo

      this.searchForm.reset()
    },
    searchUser() {
      this.$inertia.get(
        this.route('transactions.create'),
        { search: this.searchForm.search },
        {
          preserveState: true,
          replace: true,
        },
      )
    },
  },
}
</script>
