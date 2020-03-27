/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import ru from 'vuetify/es5/locale/ru';
import '@mdi/font/css/materialdesignicons.css'; // Ensure you are using css-loader
import { plugin as VueStator } from 'vue-stator';
import store from './store';

window.Vue.use(Vuetify);
window.Vue.use(VueRouter);
window.Vue.use(VueStator, {
    state: () => ({
        user: {},
        products: {},
        warehouses: [],
        warehouseId: null,
    })
});

import NotFound from './components/NotFound.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import ExampleComponentEdit from './components/ExampleComponentEdit.vue';
import ImageUploadComponent from './components/ImageUploadComponent.vue';
import OrdersComponent from './components/OrdersComponent.vue';
import OrderComponent from './components/OrderComponent.vue';
import ProductsComponent from './components/ProductsComponent.vue';
import ProfileComponent from './components/ProfileComponent.vue';
import NavbarComponent from './components/NavbarComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import ErrorComponent from './components/ErrorComponent.vue';

Vue.component('navbar-component', NavbarComponent);
Vue.component('login-component', LoginComponent);
Vue.component('error-component', ErrorComponent);

const appPath = '/app';
const routes = [
    { path: appPath + '/', component: ExampleComponent },
    { path: appPath + '/profile', name: 'profile', component: ProfileComponent },
    { path: appPath + '/task/:id', name: 'task', component: ExampleComponentEdit },
    { path: appPath + '/upload/', component: ImageUploadComponent },
    { path: appPath + '/orders/', name: 'orders', component: OrdersComponent },
    { path: appPath + '/order/:number/:date', name: 'order', component: OrderComponent },
    { path: appPath + '/products/', name: 'products', component: ProductsComponent },
    { path: appPath + '/*', component: NotFound },
]

const router = new VueRouter({ mode: 'history', routes });

const vuetify = new Vuetify({
    /*lang: {
        locales: { ru },
        current: 'ru',
    },*/
});

Vue.prototype.$userData = {};

Vue.prototype.$error = function() {
    this.$refs.errorModal.isActive = true;
};

const app = new Vue({ router, vuetify, store }).$mount('#app');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*const app = new Vue({
    el: '#app',
});*/
