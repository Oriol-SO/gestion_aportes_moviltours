<template>
  <v-card :title="$t('your_password')" class="ma-5 pa-3">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('password_updated')" />

      <!-- Password -->
      <div class="mb-3 row">
        <div class="col-md-7">
          <v-text-field
            v-model="form.password"
            :class="{ 'is-invalid': form.errors.has('password') }"
            class="form-control"
            type="password"
            required
            outlined
            label="Contraseña"
            name="password"
          ></v-text-field>
          <has-error :form="form" field="password" />
        </div>
      </div>

      <!-- Password Confirmation -->
      <div class="mb-3 row">
        <div class="col-md-7">
          <v-text-field
            v-model="form.password_confirmation"
            :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
            class="form-control"
            type="password"
            required
            name="password_confirmation"
            outlined
            label="Confirmar contraseña"
          ></v-text-field>
          <has-error :form="form" field="password_confirmation" />
        </div>
      </div>

      <!-- Submit Button -->
      <div class="mb-3 row">
        <div class="col-md-9 ms-md-auto">
          <v-btn :loading="form.busy" type="success">
            {{ $t("update") }}
          </v-btn>
        </div>
      </div>
    </form>
  </v-card>
</template>

<script>
import Form from "vform";

export default {
  scrollToTop: false,

  metaInfo() {
    return { title: this.$t("settings") };
  },

  data: () => ({
    form: new Form({
      password: "",
      password_confirmation: "",
    }),
  }),

  methods: {
    async update() {
      await this.form.patch("/api/settings/password");

      this.form.reset();
    },
  },
};
</script>
