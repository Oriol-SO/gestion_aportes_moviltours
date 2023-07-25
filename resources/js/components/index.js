import Vue from 'vue'
import Child from './Child.vue'
import { HasError, AlertError, AlertSuccess } from 'vform/components/bootstrap5'


import mensaje from '~/components/mensaje.vue';
// Components that are registered globaly.
[
  Child,
  HasError,
  AlertError,
  AlertSuccess,
  mensaje

].forEach(Component => {
  Vue.component(Component.name, Component)
})
