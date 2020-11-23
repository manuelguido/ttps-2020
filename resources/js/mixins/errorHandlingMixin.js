/**
 * Mixin
 */
const errorHandlingMixin = {
	methods: {
		errorHandler(errorStatus) {
			if (errorStatus == 401) {
				this.handle401();
			}
		},
  	handle401 () {
			this.$router.push({ path: '/logout' });
		}
	},
}

export default errorHandlingMixin
