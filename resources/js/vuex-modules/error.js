import {store} from "../app";

window.axios = require('axios');

axios.interceptors.response.use(
    res => res,
    err => {
        console.log({err});
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
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations
};
