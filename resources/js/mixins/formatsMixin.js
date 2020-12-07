/**
 * Mixin
 */
const formatsMixin = {
	methods: {
  	formatDni (value) {
			return (value/1).toFixed(0).replace('.').toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
		}
	},
}

export default formatsMixin
