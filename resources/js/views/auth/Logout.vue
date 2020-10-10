<template>
  <div class="container-fluid py-5 text-center">
    <h1 class="h6 black-c mt-5 mb-4">Saliendo del sistema</h1>
    <spinner></spinner>
  </div>
</template>

<script>
export default {
  created() {
    localStorage.clear(); // Deletes all local storage
    this.$store.dispatch("destroyToken");
    window.location.href = '/'
    // this.$router.push({ path: '/' });
  }
};
</script>
