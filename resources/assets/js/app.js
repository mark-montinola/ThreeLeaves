
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

// import Element from "./element";
// window.Element = Element;

import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

// import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })

let routes = [
    {
        path: '/dashboard', 
        component: require('./components/Dashboard.vue'),
        props: true, 
        meta: {
            breadcrumbs: {},
        },
    },
    { 
        path: '/module', 
        name: 'module', 
        component: require('./components/MainMenu.vue'), 
        children: [
            { 
                path: '/module/:module_name', 
                name: 'module_name', 
                component: require('./components/MainMenu.vue'), 
                children: [
                    { 
                        path: '/module/:module_name/:category_name', 
                        name: 'category_name', 
                        component: require('./components/MainMenu.vue'), 
                    },
                ]
            },
        ]
    },
    { path: '/module/:module_name/:category_name/:form_name', name: 'form_name', component: require('./components/FormManager.vue') },
    /**
     * Custom Objects
     */
    // { path: '/module/:module_name/:category_name/Item/:method?', name: 'item_add', component: require('./components/Item.vue') },
    // { path: '/module/:module_name/:category_name/Item/:method?/:id?', name: 'item_edit', component: require('./components/Item.vue') },
    
    /**
     * Common Objects
     */
    
    { path: '/module/:module_name/:category_name/:form_name/:method?', name: 'form_add', component: require('./components/Form.vue') },
    { path: '/module/:module_name/:category_name/:form_name/:method?/:id?', name: 'form_edit', component: require('./components/Form.vue') },
    { path: '/profile', component: require('./components/Profile.vue')},
    { path: '*', component: require('./components/NotFound.vue') },
]

const router = new VueRouter({
    routes, // short for `routes: routes`
    linkActiveClass: "active",
    linkExactActiveClass: "active",
})


import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect);

import Datepicker from 'vuejs-datepicker';
Vue.component('datepicker', Datepicker);

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate', function(created){
    return moment(created).format('MMMM Do YYYY');
});

import VueStringFilter from 'vue-string-filter'
Vue.use(VueStringFilter);

import JsonEditor from 'vue-json-edit'
Vue.use(JsonEditor);

window.Fire =  new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue')
);

Vue.component(
    'SidebarMenu',
    require('./components/SidebarMenu.vue')
)

Vue.component(
    'ContentHeader',
    require('./components/ContentHeader.vue')
)

Vue.component(
    'vue-swiper',
    require('./components/Swiper.vue')
)

Vue.component(
    'vue-services',
    require('./components/Services.vue')
)

Vue.component(
    'vue-flavors',
    require('./components/Flavors.vue')
)

import Vuex from 'vuex'
Vue.use(Vuex)

const store = new Vuex.Store({  
    state: {
        breadcrumbs: {}
    },  
    mutations: {
        setRoute (state, payload) {
            state.breadcrumbs = payload.route;
        }
    },
    actions: {}, 
    getters: {},
});

const app = new Vue({
    el: '#app',
    store,
    router,
    data: {
        search: ''
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),

        printme() {
            window.print();
        }
    }
});
