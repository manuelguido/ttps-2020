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
			user: {
				
			},
			routes: []
		}
	},
	mounted () {
		this.loadRoutes();
	},
	methods: {
		loadRoutes() {
			// Obtener rutas del usuario
			if (localStorage.routes) {
				var routes = localStorage.getItem('routes')
				this.routes = JSON.parse(routes)
			}
			this.getUserRoutes()
		},

		setRoutes(data) {
			this.routes = data;
		},

		getUserRoutes: function () {
      const path = '/api/user/routes'
      const AuthStr = 'Bearer ' + localStorage.getItem('access_token').toString()
      axios.get(path, {
        headers: {
          'Accept': 'application/json',
          'Authorization': AuthStr
        }
      }).then((res) => {
				this.setRoutes(res.data);
      }).catch((error) => {
				// this.getUserRoutes();
				console.log(error);
      })
    },
	}
}
</script>
