/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Swal = require('sweetalert2');

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);


import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// import Swal from 'sweetalert2';

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('employee-index', require('./components/Employee/Index.vue').default);
Vue.component('employee-create', require('./components/Employee/Create.vue').default);
Vue.component('department-index', require('./components/Department/Index.vue').default);
Vue.component('department-create', require('./components/Department/Create.vue').default);

// CommonJS
// const Swal = require('sweetalert2')


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
