// Bootstrap
require('./bootstrap');
import 'bootstrap-css-only/css/bootstrap.min.css';
import 'mdbvue/lib/css/mdb.min.css';
import '../css/app.css';

window.Vue = require('vue');

// Vue, mainapp + router
import Vue from 'vue';
import App from './views/App';
import router from './router';
import store from './store';

// Mixins
import alertMixin from './mixins/alertMixin';
import assetMixin from './mixins/assetMixin';

// Waves
import Waves from 'vue-waves-effect';
import 'vue-waves-effect/dist/vueWavesEffect.css';
Vue.use(Waves);

// Mixins
Vue.mixin(alertMixin);
Vue.mixin(assetMixin);

/*-----------------------------------------------------------

  Components

-----------------------------------------------------------*/
/*-----------------------------------------------------------
  Navigation
-----------------------------------------------------------*/
// Navbar
Vue.component('navbar', require('./components/Navbar.vue').default);

/*-----------------------------------------------------------
  Forms
-----------------------------------------------------------*/
// Input
Vue.component('v-input', require('./components/forms/Input.vue').default);

/*-----------------------------------------------------------
  Charts
-----------------------------------------------------------*/
// Line
Vue.component('line-chart', require('./components/charts/LineChart.vue').default);
// Scatter
Vue.component('scatter-chart', require('./components/charts/ScatterChart.vue').default);
// Data Table
Vue.component('data-table', require('./components/Table.vue').default);

/*-----------------------------------------------------------
  User dashboard
-----------------------------------------------------------*/
// Dashboard navigation
Vue.component('dashboard-navigation', require('./components/dashboard/navigation/Navigation.vue').default);
// Title
Vue.component('dashboard-title', require('./components/dashboard/Title.vue').default);
// Subtite
Vue.component('dashboard-subtitle', require('./components/dashboard/SubTitle.vue').default);


/*-----------------------------------------------------------
  Loading status
-----------------------------------------------------------*/
// Spinner
Vue.component('spinner', require('./components/loading/Spinner.vue').default);
// Loading Overlay
Vue.component('loading-overlay', require('./components/loading/Overlay.vue').default);
// Loading Overlay
Vue.component('loading-dots', require('./components/loading/Dots.vue').default);

/*-----------------------------------------------------------

  Vue instance

  -----------------------------------------------------------*/
new Vue({
  el: '#app',
  components: { App },
  router,
  store
}).$mount('#app')
