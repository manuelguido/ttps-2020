<template>
  <mdb-navbar id="dashboard-navbar" color="white" light class="dashboard-navbar shadow-none py-3 py-lg-2 py-xl-3">
    <!-- Brand -->
    <router-link to="/" class="navbar-brand">
      <span class="w-700 primary">SeCo</span>
			<span class="w-400 primary">Dashboard</span>
    </router-link>
		<!-- /.Brand -->
    <mdb-navbar-toggler>
			<!-- <form class="search-form mx-auto my-3 my-lg-1">
				<div class="input-group">
					<input type="text" class="form-control" v-model="input_search" placeholder="Buscar en el panel" aria-label="Buscar" aria-describedby="search-addon">
					<div class="input-group-append">
						<span class="input-group-text" id="search-addon"><i class="fas fa-search"></i></span>
					</div>
				</div>
			</form> -->
			<mdb-navbar-nav right>
				<span class="web-hide">
					<!-- Items -->
    			<items :routes=routes></items>
				</span>
				<mdb-nav-item to="/notifications" class="d-flex align-items-center px-3">
					<i class="fad fa-bell fa-lg"></i>
				</mdb-nav-item>
				<mdb-dropdown tag="li" class="nav-item mobile-hide uns" dropleft>
          <mdb-dropdown-toggle tag="a" navLink class="btn btn-dropdown black-alpha-60" slot="toggle" waves-fixed><i class="fad fa-user-alt black-alpha-50 mx-2"></i></mdb-dropdown-toggle>
          <mdb-dropdown-menu>
						<h6 class="dropdown-header text-left pl-2 black-alpha-60">Cuenta</h6>
						<mdb-dropdown-item to="/profile">Perfil</mdb-dropdown-item>
						<mdb-dropdown-item to="/dashboard">Dashboard</mdb-dropdown-item>
      			<div class="dropdown-divider m-0 p-0"></div>
            <mdb-dropdown-item to="/logout">Cerrar sesión</mdb-dropdown-item>
          </mdb-dropdown-menu>
        </mdb-dropdown>
      </mdb-navbar-nav>
    </mdb-navbar-toggler>
  </mdb-navbar>
</template>

<script>
  import { mdbNavbar, mdbNavbarBrand, mdbNavbarToggler, mdbNavbarNav, mdbNavItem, mdbDropdown, mdbDropdownMenu, mdbDropdownToggle, mdbInput, mdbDropdownItem, mdbBtn } from 'mdbvue';
	import items from './Items'
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
			mdbBtn,
			items
		},
		props: {
			routes: Array
		},
		data () {
			return {
				input_search: '',
			}
		},
		created () {
			this.createListeners();
    },
    mounted () {
			this.handleScroll();
    },
    destroyed () {
			this.removeListeners();
    },
    methods: {
			createListeners() {
				window.addEventListener('scroll', this.handleScroll);
				window.addEventListener('onresize', this.handleScroll);
			},

			removeListeners() {
				window.removeEventListener('scroll', this.handleScroll);
				window.removeEventListener('onresize', this.handleScroll);
			},
			
			// Makes the navbar big
			bigNavbar (nav) {
				nav.classList.add('py-lg-3');
				nav.classList.remove('py-lg-1');
			},

			// Makes the navbar mobile
			mobileNavbar (nav) {
				nav.classList.add('py-lg-1');
				nav.classList.remove('py-lg-3');
			},

			// Makes the navbar small
			smallNavbar (nav) {
				nav.classList.add('py-lg-1');
				nav.classList.remove('py-lg-3');
			},

			// Handles scroll listener
			handleScroll () {
				var nav = document.querySelector('#dashboard-navba2r');
				let desktopScreen = window.innerWidth >= 992;
				// Top page
        if (window.scrollY <= 100 && desktopScreen) {
					this.bigNavbar(nav);
				} else if (!desktopScreen) {
					this.mobileNavbar(nav);
				} else {
					this.mobileNavbar(nav);
				}
			},
		}
  }
</script>

<style>
.dashboard-navbar,
.dashboard-navbar * {
	transition: 0.1s all !important;
}
</style>

<style scoped>
.dashboard-navbar {
	z-index: 1040 !important;
	border-bottom: 1px solid #eee;
}

@media (max-width: 992px) {
	.dashboard-navbar {
		position: fixed !important;
		width: 100vw;
		box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
	}
}

.brand,
.brand * {
	color: var(--primary) !important;
}

/* Searchbar */
/* .search-form {
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
} */

/* Buttons */
.btn-dropdown {
	background: var(--black-alpha-03);
	box-shadow: none !important;
	border-radius: 50px !important;
}
</style>