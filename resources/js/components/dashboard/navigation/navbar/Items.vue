<template>
  <mdb-navbar-toggler>

    <mdb-navbar-nav class=" py-0 my-0 py-lg-0" right>
      <mdb-dropdown tag="li" class="mobile-hide nav-item">
        <mdb-dropdown-toggle tag="a" navLink slot="toggle" class="black-a" waves-fixed>Cuenta</mdb-dropdown-toggle>
        <mdb-dropdown-menu>
          <mdb-dropdown-item to="/logout" class="black-a"><i class="fas fa-sign-out-alt mr-3"></i>Cerrar sesión</mdb-dropdown-item>
        </mdb-dropdown-menu>
      </mdb-dropdown>
    </mdb-navbar-nav>
		
    <mdb-navbar-nav class="web-hide py-3 py-lg-0 text-right">
			<!-- Items -->
      <router-link class="nav-item px-2 py-3"
        v-for="route in routes"
        :key="route.name"
        :to="route.url">
        {{route.name}}
        <span class="icon"><i :class="route.icon" class="ml-auto"></i></span>
      </router-link>
      <!-- /.Items -->

      <!-- Logout -->
      <router-link class="nav-item px-2 py-3" to="/logout">
        Cerrar sesión
        <span class="icon"><i class="fas fa-sign-out-alt mx-auto"></i></span>
      </router-link>
      <!-- /.Logout -->
		</mdb-navbar-nav>

	</mdb-navbar-toggler>
</template>

<script>
import { mdbNavbarToggler, mdbNavbarNav, mdbDropdown, mdbDropdownToggle, mdbDropdownMenu, mdbDropdownItem } from 'mdbvue';
export default {
  name: 'sidenav-items',
  props: {
    routes: Array
  },
  components: {
    mdbNavbarToggler,
    mdbNavbarNav,
    mdbDropdown,
    mdbDropdownToggle,
    mdbDropdownMenu,
    mdbDropdownItem
  }
}
</script>

<style scoped>
.icon {
  display: inline-block;
  width: 34px;
  text-align: center !important;
}

.nav-item {
  color: var(--black);
  font-weight: 400;
}
.nav-item .icon {
  color: var(--black-alpha-20);
}

.nav-item.router-link-active,
.nav-item.router-link-exact-active {
  background: rgba(255, 255, 255, .25);
  color: var(--primary   );
}

</style>
