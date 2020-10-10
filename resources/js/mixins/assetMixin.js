const production = true;

const assetMixin = {
	data () {
		return {
			dev_path: 'http://127.0.0.1:8000/',
			prod_path: 'http://www.glossar.site/public', // Cambiar ruta cuando se haga el deploy
		}
	},
	methods: {
  	asset_path () { 
			if (production) {
				return this.prod_path;
			}
			else {
				return this.dev_path;
			}
		}
	},
}

export default assetMixin
