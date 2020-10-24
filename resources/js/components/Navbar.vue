<template>
  <mdb-navbar color="white" light class="navbar shadow-none py-3 py-lg-2 py-xl-3">
    <router-link to="/" class="navbar-brand">
			<span><i class="fad fa-star-of-life primary mr-2"></i></span>
      <span class="primary w-600">SeCo</span>
    </router-link>
    <mdb-navbar-toggler>
			<mdb-navbar-nav right>
        <router-link class="shadow-none btn btn-login my-0" to="/login" v-waves>Iniciar sesion</router-link>
      </mdb-navbar-nav>
    </mdb-navbar-toggler>
  </mdb-navbar>
</template>

<script>
  import { mdbNavbar, mdbNavbarBrand, mdbNavbarToggler, mdbNavbarNav } from 'mdbvue';
  export default {
    name: 'NavBar',
    components: {
      mdbNavbar,
      mdbNavbarBrand,
      mdbNavbarToggler,
      mdbNavbarNav,
		}
  }
</script>

<style scoped>
.navbar {
  border-bottom: 1px solid #eee;
}
@media (min-width: 1200px) {
	.navbar {
		padding-left: 120px;
		padding-right: 120px;
	}
}
.btn-login {
	background: var(--primary-light) !important;
	border: 1px solid var(--primary) !important;
	color: var(--primary) !important;
}
</style>