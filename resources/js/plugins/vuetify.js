// src/plugins/vuetify.js

import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import es from 'vuetify/lib/locale/es'

Vue.use(Vuetify)
Vue.component('my-component', {
    methods: {
      changeLocale () {
        this.$vuetify.lang.current = 'es'
      },
    },
  })
const opts = {
    lang:{
        locales:{es },
        current: 'es',
    },
}

export default new Vuetify(opts)