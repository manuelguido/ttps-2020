// Bootstrap
require('./bootstrap');
import 'bootstrap-css-only/css/bootstrap.min.css';
import 'mdbvue/lib/css/mdb.min.css';
import '../ccs/app.css'

window.Vue = require('vue');

// Vue, mainapp + router
import Vue from 'vue';
import App from './views/App';
import router from './router';
import store from './store';

// Waves
import Waves from 'vue-waves-effect';
import 'vue-waves-effect/dist/vueWavesEffect.css';
Vue.use(Waves);

/*-----------------------------------------------------------
  Vue instance
  -----------------------------------------------------------*/
new Vue({
  el: '#app',
  components: { App },
  router,
  store
}).$mount('#app')