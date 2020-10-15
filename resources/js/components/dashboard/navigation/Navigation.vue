<template>
  <div>
  	<!-- Navigation bar -->
    <navbar v-if="navbar" :routes=routes></navbar>
		<!-- /.Navigation bar -->

		<!-- Sidebar -->
		<sidebar v-if="sidebar" :routes=routes></sidebar>
		<!-- /.Sidebar -->
  </div>
</template>

<script>
import sidebar from './sidebar/Sidebar' 
import navbar from './navbar/Navbar'

export default {
  components: {
		'sidebar': sidebar,
		'navbar': navbar
  },
  props: {
    navbar: {
      type: Boolean,
      default: true,
    },
    sidebar: {
      type: Boolean,
      default: false,
    }
  },
	data () {
		return {
			routes: JSON.parse(localStorage.getItem('routes')),
		}
	}
}
</script>
