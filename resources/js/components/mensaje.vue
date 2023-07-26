<template>
    <div class="text-center">
   
      <v-snackbar
        v-model="snackbar"
        :vertical="vertical"
        top
        :color="color"
        dark 
      >
        {{ msg }}
  
        <template v-slot:action="{ attrs }">
          <v-btn
            text
            v-bind="attrs"
            @click="snackbar = false"
          >
            ACEPTAR
          </v-btn>
        </template>
      </v-snackbar>
    </div>
  </template>

<script>
export default {
  name:'mensaje',
  props:{
    msg:{default:''},
    color:{default:'green '}
  },
  data: () => ({
    snackbar: true,
    vertical: true,
  }),
}
</script>