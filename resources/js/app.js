/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import dayjs from "dayjs";
import VueToast from "vue-toast-notification";
import {routes} from "./routes";
import VueRouter from "vue-router";
import Vuex from "vuex";
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import notification from "./vuex-modules/notification";

require('./bootstrap');

window.Vue = require('vue');

[VueRouter, dayjs, Vuex, VueToast, Vuetify].forEach((x) => Vue.use(x));

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active', // apply active class when url matches the route
    linkExactActiveClass: 'active'
})

const store = new Vuex.Store({
    modules: {
        notification: notification
    }
});


const app = new Vue({
    el: '#app',
    store,
    vuetify: new Vuetify(),
    router
});
