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

require('./bootstrap');

window.Vue = require('vue');

[VueRouter, dayjs, Vuex, VueToast].forEach((x) => Vue.use(x));

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active', // apply active class when url matches the route
    linkExactActiveClass: 'active'
})
const app = new Vue({
    el: '#app',
    router
});
