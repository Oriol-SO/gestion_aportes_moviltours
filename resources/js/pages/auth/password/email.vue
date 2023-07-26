<template>
  <div class="row ma-5">
    <div class="col-lg-7 m-auto">
      <v-card :title="$t('reset_password')" class="pa-3">
        <form @submit.prevent="send" @keydown="form.onKeydown($event)">
          <alert-success :form="form" :message="status" />

          <!-- Email -->
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">{{
              $t("email")
            }}</label>
            <div class="col-md-7">
              <v-text-field
                v-model="form.email"
                :class="{ 'is-invalid': form.errors.has('email') }"
                class="form-control"
                type="email"
                name="email"
                required
                outlined
                label="Ingrese el correo registrado"
              ></v-text-field>
              <has-error :form="form" field="email" />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="mb-3 row">
            <div class="col-md-9 ms-md-auto">
              <v-btn :loading="form.busy" type="submit">
                {{ $t("send_password_reset_link") }}
              </v-btn>
            </div>
          </div>
        </form>
        <v-card-actions>
          <v-btn
          text
          class="ml-auto"
          color="primary"
          to="/login"
          >
            Ir a inicio
          </v-btn>
        </v-card-actions>
      </v-card>
    </div>
  </div>
</template>

<script>
import Form from "vform";

export default {
  layout: "basic",
  middleware: "guest",

  metaInfo() {
    return { title: this.$t("reset_password") };
  },

  data: () => ({
    status: "",
    form: new Form({
      email: "",
    }),
  }),

  methods: {
    async send() {
      const { data } = await this.form.post("/api/password/email");

      this.status = data.status;

      this.form.reset();
    },
  },
};
</script>
