<template>
  <div class="row justify-content-center">
    <div class="col-md-3 mb-3">
      <v-card :title="$t('settings')" class="pa-5 ma-3">

        <v-row v-for="tab in tabs" :key="tab.route" class="ma-3">
            <router-link
              :to="{ name: tab.route }"
              class="nav-link"
              active-class="active"
            >
              <fa :icon="tab.icon" fixed-width />
              {{ tab.name }}
            </router-link>
        </v-row>
      </v-card>
    </div>

    <div class="col-md-7">
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  middleware: "auth",

  computed: {
    tabs() {
      return [
        {
          icon: "user",
          name: this.$t("profile"),
          route: "settings.profile",
        },
        {
          icon: "lock",
          name: this.$t("password"),
          route: "settings.password",
        },
      ];
    },
  },
};
</script>

<style>
.settings-card .card-body {
  padding: 0;
}
</style>
