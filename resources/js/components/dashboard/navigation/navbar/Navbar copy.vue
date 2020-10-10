<template>
  <mdb-navbar color="white" light class="navbar dashboard-navbar shadow-none py-3 py-lg-1">
    <router-link to="/dashboard" class="navbar-brand">
      <span class="w-600">{{navbar_title}}</span>
			<span class="w-300">Dashboard</span>
    </router-link>
    <mdb-navbar-toggler>
			<form class="search-form mx-auto my-3">
				<div class="input-group">
					<input type="text" class="form-control" v-model="input_search" placeholder="Buscar en el panel" aria-label="Buscar" aria-describedby="search-addon">
					<div class="input-group-append">
						<span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
					</div>
				</div>
			</form>
			<mdb-navbar-nav right>
				<span class="web-hide">
					<mdb-nav-item to="/dashboard"><i class="fad fa-tachometer-fast mr-3 black-alpha-40"></i>Panel</mdb-nav-item>
	        <mdb-nav-item to="/logout"><i class="fad fa-sign-out mr-3 black-alpha-40"></i>Cerrar sesión</mdb-nav-item>
				</span>
				<mdb-dropdown tag="li" class="nav-item mobile-hide">
          <mdb-dropdown-toggle tag="a" navLink class="btn btn-dropdown" slot="toggle" waves-fixed>Cuenta</mdb-dropdown-toggle>
          <mdb-dropdown-menu>
						<mdb-dropdown-item to="/dashboard"><i class="fad fa-tachometer-fast mr-3 black-alpha-40"></i>Panel</mdb-dropdown-item>
            <mdb-dropdown-item to="/logout"><i class="fad fa-sign-out mr-3 black-alpha-40"></i>Cerrar sesión</mdb-dropdown-item>
          </mdb-dropdown-menu>
        </mdb-dropdown>
      </mdb-navbar-nav>
    </mdb-navbar-toggler>
  </mdb-navbar>
</template>

<script>
  import { mdbNavbar, mdbNavbarBrand, mdbNavbarToggler, mdbNavbarNav, mdbNavItem, mdbDropdown, mdbDropdownMenu, mdbDropdownToggle, mdbInput, mdbDropdownItem, mdbBtn } from 'mdbvue';
  export default {
    name: 'Navbar',
    components: {
      mdbNavbar,
      mdbNavbarBrand,
      mdbNavbarToggler,
      mdbNavbarNav,
      mdbNavItem,
      mdbDropdown,
      mdbDropdownMenu,
      mdbDropdownToggle,
      mdbDropdownItem,
			mdbInput,
			mdbBtn
		},
		props: {
			navbar_title: {
				type: String,
				default: 'COVID',
			}
		},
		data () {
			return {
				input_search: '',
			}
		}
  }
</script>

<style>
.dashboard-navbar,
.dashboard-navbar * {
	transition: 0s all !important;
}
</style>

<style scoped>
.navbar {
	z-index: 1080 !important;
}

@media (min-width: 1200px) {
	.navbar {
		padding-right: 120px;
	}
}

.navbar-brand {
	color: var(--primary);
}
.navbar-brand:hover {
	color: var(--primary);
	opacity: 0.7;
}
.navbar-brand:active {
	opacity: 0.9;
}

/* Searchbar */
.search-form {
	background: var(--black-alpha-03);
	border-radius: 8px;
	border: 0 none;
	padding: 10px;
}
@media (min-width: 992px) {
	.search-form {
		width: 50%;
	}
}
@media (max-width: 992px) {
	.search-form {
		width: 100%;
	}
}


.search-form input {
	width: 100%;
	height: 100%;
}

.search-form input,
.search-form input:focus {
	color: var(--white-a);
}

.search-form input:focus,
.search-form * {
	box-shadow: none;
	background: none;
	border: 0 none;
	outline: none ;
}

/* Buttons */
.btn-register {
	background: var(--primary) !important;
	color: #fff !important;
}
.btn-login {
	background: var(--primary-light) !important;
	border: 1px solid var(--primary) !important;
	color: var(--primary) !important;
}
.btn-dropdown {
	background: var(--black-alpha-06);
	box-shadow: none !important;
}
</style>