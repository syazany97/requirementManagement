import {store} from "../app";

window.axios = require('axios');

axios.interceptors.response.use(
    res => {
        return res;
    },
    err => {
        if (err.response.status === 422) {
            store.commit('error/errors', err.response.data.errors)
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
