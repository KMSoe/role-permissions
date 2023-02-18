import { createApp, h } from 'vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { Ziggy } from './ziggy'
import route from 'ziggy-js'
import { createWebHashHistory, createRouter } from 'vue-router'

InertiaProgress.init()

createInertiaApp({
  resolve: (name) => require(`./Pages/${name}`),
  title: (title) => title,
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      // .use(
      //   createRouter({
      //     history: createWebHashHistory(),
      //     routes: [],
      //   }),
      // )
      .mixin({ methods: { route } }) // add it
      .mount(el)
  },
})
