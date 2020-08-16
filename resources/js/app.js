import dayjs from "dayjs";
import LocalizedFormat from 'dayjs/plugin/localizedFormat';
import VueToast from "vue-toast-notification";
import {routes} from "./routes";
import VueRouter from "vue-router";
import Vuex from "vuex";
// import Vuetify from 'vuetify/lib';
// import Vuetify from "vuetify";
import VModal from 'vue-js-modal'
// import 'vuetify/dist/vuetify.min.css';
import notification from "./vuex-modules/notification";
import VueTreeList from 'vue-tree-list';
import requirement from "./vuex-modules/requirement";
import user from "./vuex-modules/user";
import vSelect from 'vue-select'
require('./bootstrap');

window.Vue = require('vue');

[VueRouter, dayjs, Vuex, VueToast, VueTreeList, VModal].forEach((x) => Vue.use(x));

Vue.component('vue-select', vSelect);

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
dayjs.extend(LocalizedFormat);

const router = new VueRouter({
    mode: 'history',
    routes,
    linkActiveClass: 'active', // apply active class when url matches the route
    linkExactActiveClass: 'active'
})

const store = new Vuex.Store({
    modules: {
        notification: notification,
        requirement : requirement,
        user : user
    }
});

Vue.filter('formatDateTime', function(value) {
    let dateTime = dayjs(value);
    return dateTime.format('LLL');
});

Vue.filter('titleCase', function(value) {
    return _.startCase(_.toLower(value));
})


const app = new Vue({
    el: '#app',
    store,
    router
});
