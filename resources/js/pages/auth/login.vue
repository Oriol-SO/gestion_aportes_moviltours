<template>
  <v-container fluid class="fill-height main" >
    <v-flex>
      <v-card
        class="mx-auto my-auto h-100  py-6"
        rounded="lg"
        elevation="2"
        width="380"
      >
       

        <v-card-title class="d-block text-center">
          <v-img
          src="/img/logomovil.png"
          :aspect-ratio="10/4"
          contain
          ></v-img>
          Iniciar sesión
        </v-card-title>
        <v-card-text>
          <v-form
            ref="form"
            @submit.prevent="login"
            @keydown="form.onKeydown($event)"
          >
            <v-text-field
              dense
              v-model="form.email"
              label="Correo"
              type="text"
              outlined
              prepend-inner-icon="mdi-account-outline"
              required
              autofocus
              :error="form.errors.has('email')"
            ></v-text-field>

            <v-text-field
              dense
              v-model="form.password"
              label="Contraseña"
              outlined
              prepend-inner-icon="mdi-lock-outline"
              required
              :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
              :type="show1 ? 'text' : 'password'"
              :error="form.errors.has('password')"
              @click:append="show1 = !show1"
            ></v-text-field>

            <v-flex class="d-flex align-center justify-space-between flex-wrap">
              <v-checkbox v-model="remember" label="Recordarme"></v-checkbox>
              <router-link :to="{ name: 'password.request' }"
                >¿Has olvidado tu contraseña?</router-link
              >
            </v-flex>

            <v-btn
              :loading="form.busy"
              color="#2b4496"
              class="mr-4"
              type="submit"
              dark
              block
            >
              Ingresar
            </v-btn>

            <v-btn
              dark
              class="mr-4 mt-2"
              type="submit"
              block
              color="#f07937"
              to="/register"
            >
              REGISTRATE
            </v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-container>
</template>

<script>
import Form from "vform";
import Cookies from "js-cookie";
import LoginWithGithub from "~/components/LoginWithGithub";

export default {
  components: {
    LoginWithGithub,
  },

  layout: "basic",

  middleware: "guest",

  metaInfo() {
    return { title: this.$t("login") };
  },

  data: () => ({
    appName: window.config.appName,
    form: new Form({
      email: "",
      password: "",
    }),
    remember: false,
    show1: false,
  }),

  methods: {
    validate() {
      this.$refs.form.validate();
    },
    async login() {
      this.validate();
      // Submit the form.
      const { data } = await this.form.post("/api/login");

      // Save the token.
      this.$store.dispatch("auth/saveToken", {
        token: data.token,
        remember: this.remember,
      });

      // Fetch the user.
      await this.$store.dispatch("auth/fetchUser");

      // Redirect home.
      this.redirect();
    },

    redirect() {
      const intendedUrl = Cookies.get("intended_url");

      if (intendedUrl) {
        Cookies.remove("intended_url");
        this.$router.push({ path: intendedUrl });
      } else {
        const firstRoute = this.$store.getters["auth/firstRoute"];

        this.$router.push({name: firstRoute});
       // this.$router.push({ name: "home" });
        //this.$router.push(firstRoute);
      }
    },
  },
};
</script>
<style scoped>
.main {
  background-image:linear-gradient(rgba(60, 39, 28, 0.9), rgba(0, 0, 0, 0.4)), url('/img/fondomovil.jpg') !important;
  background-size: cover !important;
  background-repeat: no-repeat !important;
}

.img {
  height: 7.5rem;
  width: 7.5rem;
  padding: 0.5rem;
}
</style>