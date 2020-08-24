import dayjs from "dayjs";
import LocalizedFormat from 'dayjs/plugin/localizedFormat';
import VueToast from "vue-toast-notification";
import {routes} from "./routes";
import VueRouter from "vue-router";
import Vuex from "vuex";
import VModal from 'vue-js-modal'
import notification from "./vuex-modules/notification";
import VueTreeList from 'vue-tree-list';
import requirement from "./vuex-modules/requirement";
import user from "./vuex-modules/user";
import vSelect from 'vue-select'
import ProjectIndex from "./views/projects/ProjectIndex";

require('./bootstrap');

window.Vue = require('vue');

[VueRouter, dayjs, Vuex, VueToast, VueTreeList, VModal].forEach((x) => Vue.use(x));

Vue.component('vue-select', vSelect);

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
dayjs.extend(LocalizedFormat);

Vue.component('project-index', require('./views/projects/ProjectIndex').default);

// const router = new VueRouter({
//     mode: 'history',
//     routes,
//     linkActiveClass: 'active', // apply active class when url matches the route
//     linkExactActiveClass: 'active'
// })

const store = new Vuex.Store({
    modules: {
        notification: notification,
        requirement: requirement,
        user: user
    }
});

Vue.filter('formatDateTime', function (value) {
    let dateTime = dayjs(value);
    return dateTime.format('LLL');
});

Vue.filter('titleCase', function (value) {
    return _.startCase(_.toLower(value));
})

// filters
Vue.filter('limitWords', function (value) {
    if (!value) return '';
    value = value.toString();

    if (value.length >= 60) {
        return value.substring(0, 60) + '...';
    }
    return value;
});

Vue.directive('click-outside', {

    bind: function (el, binding, vNode) {
        // Provided expression must evaluate to a function.
        if (typeof binding.value !== 'function') {
            const compName = vNode.context.name
            let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
            if (compName) {
                warn += `Found in component '${compName}'`
            }

            console.warn(warn)
        }
        // Define Handler and cache it on the element
        const bubble = binding.modifiers.bubble
        const handler = (e) => {
            if (bubble || (!el.contains(e.target) && el !== e.target)) {
                binding.value(e)
            }
        }
        el.__vueClickOutside__ = handler

        // add Event Listeners
        document.addEventListener('click', handler)
    },

    unbind: function (el, binding) {
        // Remove Event Listeners
        document.removeEventListener('click', el.__vueClickOutside__)
        el.__vueClickOutside__ = null

    }

});

Vue.component('default-transition', {
    template: '\  <transition\n' +
        'enter-active-class="transition ease-out duration-100"\n' +
        'enter-class="opacity-0 scale-95 transform"\n' +
        'enter-to-class="opacity-100 scale-100 transform"\n' +
        'leave-active-class="transition ease-in duration-75"\n' +
        'leave-class="opacity-100 scale-100 transform"\n' +
        'leave-to-class="opacity-0 scale-95 transform"\n' +
        '>\
        \<slot></slot>\
        </transition>',
});


const app = new Vue({
    el: '#app',
    store
    // router
});
