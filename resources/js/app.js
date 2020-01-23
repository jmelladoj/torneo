/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.swal = require('sweetalert2');
window.Evento = new Vue ();

//Componentes
import Vuelidate from 'vuelidate'
import BootstrapVue from 'bootstrap-vue'
import Vuex from 'vuex'
import VueToast from 'vue-toast-notification'
import VueRouter from 'vue-router'
import VueCurrencyFilter from 'vue-currency-filter'
import { rutInputDirective } from 'vue-dni'

Vue.directive('rut', rutInputDirective)

//Estilos
import 'vue-toast-notification/dist/index.css'

//Utilidades
import store from './store/index.js'
import router from './routes.js'

Vue.use(VueToast)
Vue.use(Vuelidate)
Vue.use(BootstrapVue)
Vue.use(Vuex)
Vue.use(VueRouter)

Vue.use(VueCurrencyFilter,{
    symbol : '$',
    thousandsSeparator: '.',
    fractionCount: 0,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
})

Vue.directive('rut', rutInputDirective)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Componentes generales
Vue.component('titulo-pagina', require('./components/general/titulo.vue').default);

//Pagina
Vue.component('iniciar-sesion', require('./components/login.vue').default);
Vue.component('categorias-inscripcion', require('./components/pagina/categorias.vue').default);

//Intranet
Vue.component('home', require('./components/home.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
var EventBus = new Vue;

const app = new Vue({
    el: '#app',
    store,
    router
});
