<template>
  <v-card :title="$t('your_info')" class="ma-5 pa-3">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <v-row>
        <v-col
        cols="12"
        md="6"
        >
          <v-text-field
          label="Nombre"
          outlined
          required
          v-model="form.name"
          ></v-text-field>
        </v-col>
        <v-col
        cols="12"
        md="6"
        >
          <v-text-field
          label="DNI"
          outlined
          required
          v-model="form.dni"
          ></v-text-field>
        </v-col>
        <v-col
        cols="12"
        md="6"
        >
          <v-text-field
          label="Telefono"
          outlined
          required
          v-model="form.telefono"
          ></v-text-field>
        </v-col>
        <v-col
        cols="12"
        md="6"
        >
          <v-text-field
          label="Correo electronico"
          outlined
          required
          type="email"
          v-model="form.email"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row class="pa-3">
        <v-btn
        color="primary"
        type="submit"
        :loading="loader"
        >
          ACTUALIZAR
        </v-btn>
      </v-row>
    </form>
    <mensaje :msg="msg" v-if="msg"/>
  </v-card>
</template>

<script>
import Form from "vform";
import { mapGetters } from "vuex";

export default {
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("settings") };
  },

  data: () => ({
    form: new Form({
      name: "",
      email: "",
      dni:'',
      telefono:'',
    }),
    loader:false,
    msg:'',
  }),

  computed: mapGetters({
    user: "auth/user",
  }),

  created() {
    // Fill the form with user data.
    this.form.keys().forEach((key) => {
      this.form[key] = this.user[key];
    });
  },

  methods: {
    async update() {
      this.loader=true;
      this.msg='';
      this.form.patch("/api/settings/profile").then(response=>{
        this.msg='Actualizado';
        this.$store.dispatch("auth/updateUser", { user: data });
        this.loader=false;
      }).catch(error=>{
        this.loader=false;
      });
    },
  },
};
</script>
