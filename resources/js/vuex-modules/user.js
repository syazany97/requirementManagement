// initial state
import moduleRepository from "../repositories/moduleRepository";
import userRepository from "../repositories/userRepository";
const state = () => ({
    users : []
});

// getters
const getters = {
    users: (state) => {
        return state.users;
    }
};

// mutations
const mutations = {
    setUsers: (state, payload) => {
        state.users = payload;
    },
};

const actions = {
    async setUsers(state, payload) {
        const response = await userRepository.all();
        console.log(response.data);
        state.commit('setUsers', response.data.data);
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
