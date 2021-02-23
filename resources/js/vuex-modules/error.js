import {store} from "../app";

window.axios = require('axios');

axios.interceptors.response.use(
    res => {
        return res;
    },
    err => {
        if (err.response.status === 422 || err.response.status === 400) {
            store.commit('error/errors', err.response.data.errors)
        }

        if (err.response.status === 403) {
            location.replace('/');
        }

        if (err.response.status === 401) {
            location.replace('/login');
        }

        throw err;
    }
);

const state = () => ({
    errors: {},
});

// getters
const getters = {
    errors: (state) => {
        return state.errors;
    }
};

// mutations
const mutations = {
    errors: (state, payload) => {
        state.errors = payload;
    },
    setEmptyErrors: (state) => {
        state.errors = {};
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations
};
