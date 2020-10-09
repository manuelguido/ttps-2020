<template>
  <div class="container-fluid h-100">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-6">
        <h1 class="error">Error 404</h1>
        <h1 class="h1 black-alpha-50 mb-5">Up's, parece que esta página no existe</h1>
        <span class="btn btn-primary mx-0" @click="$router.go(-1)"><i class="fad fa-chevron-left mr-3"></i>Volver</span>
        <!-- <router-link class="h3 mx-0" to='/'>Ir al inicio</router-link> -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
	name: 'error404Page',
	title: 'Error 404',
}
</script>

<style scoped>
.container-fluid {
  min-height: 100vh;
  padding-top: 120px;
  padding-bottom: 120px;
}
.error {
  color: var(--black-alpha-10);
  font-weight: 600;
}
</style>
