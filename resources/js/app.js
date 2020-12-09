// Bootstrap
require('./bootstrap');
import 'bootstrap-css-only/css/bootstrap.min.css';
import 'mdbvue/lib/css/mdb.min.css';
import '../css/app.css';
import '../css/fonts.css';

window.Vue = require('vue');


// Vue, mainapp + router
import Vue from 'vue';
import App from './views/App';
import router from './router';
import store from './store';


/**
 * Mixins
 */
import formValidationMixin from './mixins/formValidationMixin';
import errorHandlingMixin from './mixins/errorHandlingMixin';
import permissionsMixin from './mixins/permissionsMixin';
import formatsMixin from './mixins/formatsMixin';
import alertMixin from './mixins/alertMixin';
import assetMixin from './mixins/assetMixin';
Vue.mixin(formValidationMixin);
Vue.mixin(errorHandlingMixin);
Vue.mixin(permissionsMixin);
Vue.mixin(formatsMixin);
Vue.mixin(alertMixin);
Vue.mixin(assetMixin);


/**
 * Progressbar
 */
import VueProgressBar from 'vue-progressbar'

const options = {
  color: '#ccedd7',
  failedColor: '#1d252d',
  thickness: '3px',
  transition: {
    speed: '1s',
    opacity: '1',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.use(VueProgressBar, options)

// Vue moment para fechas
import moment from 'moment'
Vue.use(require('vue-moment'));
// Date filters
Vue.filter('formatDate', function (value) {
  if (value) {
    moment.locale('es')
    return moment(String(value)).format('L')
  }
})
Vue.filter('formatDateFull', function (value) {
  if (value) {
    moment.locale('es')
    return moment(String(value)).format('LL')
  }
})
Vue.filter('formatDateForm', function (value) {
  if (value) {
    moment.locale('en')
    return moment().subtract(10, 'days').calendar() // 05/23/2020
  }
})

/**----------------------------------
 * 
 * Componentes
 * 
 ----------------------------------*/
/**
 * Botones
 */
// Layout de tarjeta de dashboard
Vue.component('dasbboard-card', require('./layouts/DashboardCard.vue').default);


/**
 * Navegación
 */
// Navbar
Vue.component('navbar', require('./components/Navbar.vue').default);


/**
 * Botones
 */
// Backlink
Vue.component('backlink', require('./components/buttons/BackLink.vue').default);
Vue.component('back-link', require('./components/buttons/BackLink.vue').default);
Vue.component('back-arrow', require('./components/buttons/BackArrow.vue').default);
// Botón de guardado
Vue.component('save-button', require('./components/buttons/Save.vue').default);


/**
 * Formularios
 */
// Input
Vue.component('v-input', require('./components/forms/Input.vue').default);
// Input
Vue.component('v-input-select', require('./components/forms/Select.vue').default);
// Input
Vue.component('v-textarea', require('./components/forms/Textarea.vue').default);
// Search Input
Vue.component('search-input', require('./components/forms/SearchInput.vue').default);
// Input
Vue.component('switcher', require('./components/forms/Switcher.vue').default);


/**
 * Gráficos
 */
// Line
Vue.component('line-chart', require('./components/charts/LineChart.vue').default);
// Scatter
Vue.component('scatter-chart', require('./components/charts/ScatterChart.vue').default);


/**
 * Dashboard de usuario
 */
// Dashboard navigation
Vue.component('dashboard-navigation', require('./components/dashboard/navigation/Navigation.vue').default);
// Title
Vue.component('dashboard-title', require('./components/dashboard/Title.vue').default);
// Subtite
Vue.component('dashboard-subtitle', require('./components/dashboard/SubTitle.vue').default);
// Subtite
Vue.component('info-data', require('./components/dashboard/InfoData.vue').default);


/**
 * Estados de carga
 */
// Spinner
Vue.component('spinner', require('./components/loading/Spinner.vue').default);
// Loading Overlay
Vue.component('loading-overlay', require('./components/loading/Overlay.vue').default);
// Loading Overlay
Vue.component('loading-dots', require('./components/loading/Dots.vue').default);


// Tabla de datos
Vue.component('data-table', require('./components/DataTable.vue').default);


/**
 * Tablas
 */
// Listado de medicos
Vue.component('medics-short-table', require('./components/dashboard/medics/shortTable/Index.vue').default);
// Listado de pacientes 
Vue.component('patients-short-table', require('./components/dashboard/patients/shortTable/Index.vue').default);


/**
 * Instancia de VUE
 * 
 */
new Vue({
  el: '#app',
  components: { App },
  router,
  store
}).$mount('#app')
