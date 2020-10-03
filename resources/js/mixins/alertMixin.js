import Alert from '../components/Alert'
import Vue from 'vue'

const alertMixin = {
	methods: {
  	new_alert (data) {
			console.log(data)
			var ComponentClass = Vue.extend(Alert)
			var instance = new ComponentClass({
				propsData: { 'alert': data }
			})
			instance.$mount() // pass nothing
			document.querySelector('#app').appendChild(instance.$el)
		}
	},
}

export default alertMixin
