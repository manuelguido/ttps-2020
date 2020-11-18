<template>
  <mdb-navbar id="dashboard-navbar" light class="dashboard-navbar shadow-sm py-3 py-lg-2 py-xl-3 px-4">

		<!-- Brand -->
    <router-link to="/" class="navbar-brand brand">
			<span><i class="fad fa-star-of-life mr-2"></i></span>
      <span class="w-600">SeCo</span>
			<span>Dashboard</span>
    </router-link>
		<!-- /.Brand -->

		<mdb-navbar-toggler>
			<mdb-navbar-nav right>
				<span class="web-hide">
					<!-- Items -->
    			<items :routes=routes></items>
				</span>
				<!-- Icono de notificaciones -->
				<notification-badge></notification-badge>

				<!-- Dropdown de cuenta -->
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
				<!-- Dropdown de cuenta -->

      </mdb-navbar-nav>
    </mdb-navbar-toggler>
  </mdb-navbar>
</template>

<script>
  import { mdbNavbar, mdbNavbarBrand, mdbNavbarToggler, mdbNavbarNav, mdbNavItem, mdbDropdown, mdbDropdownMenu, mdbDropdownToggle, mdbInput, mdbDropdownItem, mdbBtn } from 'mdbvue';
	import items from './Items'
	import notificationBadge from './NotificationBadge'
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
			items,
			'notification-badge': notificationBadge
		},
		props: {
			routes: Array
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
	transition: 0.1s all !important;
}
</style>

<style scoped>
.dashboard-navbar {
	z-index: 1040 !important;
	background: var(--primary) !important;
}

@media (max-width: 11992px) {
	.dashboard-navbar {
		position: fixed !important;
		width: 100vw;
		box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
	}
}

.brand,
.brand * {
	color: #fff !important;
}

/* Buttons */
.btn-dropdown {
	background: #fff;
	box-shadow: none !important;
	border-radius: 50px !important;
}
</style>