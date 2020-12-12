/**
 * Mixin
 */
const errorHandlingMixin = {
	methods: {
		errorHandler(errorStatus) {
			switch (errorStatus) {
				case 401:
					this.handle401();
					break;
				case 403:
					this.handle403();
					break;
				case 404:
					this.handle404();
					break;
			}
		},
		handle401() {
			console.log('Error de autenticación.')
			this.$router.push({ path: '/logout' });
		},
		handle403() {
			this.$router.push({ path: '/403' });
		},
		handle404() {
			this.$router.push({ path: '/404' });
		}
	},
}

export default errorHandlingMixin
