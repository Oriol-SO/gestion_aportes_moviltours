<template>
  <v-app id="inspire" class=" fondobasic">
    <v-main >
      <child />
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "BasicLayout",
};
</script>

<style lang="scss">
.basic-layout {
  color: #636b6f;
  height: 100vh;
  font-weight: 100;
  position: relative;

  .links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.1rem;
    text-decoration: none;
    text-transform: uppercase;
  }
}

.fondobasic{
  background-image:linear-gradient(rgba(60, 39, 28, 0.9), rgba(0, 0, 0, 0.4)), url('/img/fondomovil.jpg') !important;
  background-size: cover !important;
  background-repeat: no-repeat !important;
  
}
</style>
