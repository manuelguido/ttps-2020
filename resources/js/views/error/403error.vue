<template>
  <div
    class="container d-flex flex-column justify-content-center vertical-align-center"
  >
    <h1 class="display-1 black-alpha-10 w-600">Error 403</h1>
    <h1 class="h1 black-alpha-50 mb-5">
      No tienes permiso para realizar esta acción.
    </h1>
    <span class="btn btn-primary mx-0" @click="redirect"
      ><i class="fad fa-chevron-left mr-3"></i>Volver</span
    >
  </div>
</template>

<script>
export default {
  name: "Error403Page",
  title: "Error 403",
  methods: {
    /**
     * Redirecciona al dashboard
     */
    redirect() {
      this.$router.push({ name: 'Dashboard' });
    },
  },
};
</script>

<style scoped>
.container {
  min-height: 100vh;
  padding-top: 120px;
  padding-bottom: 120px;
}
.error {
  color: var(--black-alpha-10);
  font-weight: 600;
}
</style>
