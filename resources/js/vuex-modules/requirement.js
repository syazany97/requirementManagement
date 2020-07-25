// initial state
import moduleRepository from "../repositories/moduleRepository";

const state = () => ({
    currentRequirement: {
        id : null,
        description : "",
        assigned : {},
        comments : []
    },
    requirementList : [],
    statuses : []
});

// getters
const getters = {
    currentRequirement: (state) => {
        return state.currentRequirement;
    },
    requirementList : (state) => {
        return state.requirementList;
    },
    statuses : (state) => {
        return state.statuses
    }
};

// mutations
const mutations = {
    setRequirement: (state, payload) => {
        state.currentRequirement = payload;
    },
    setRequirementList: (state, payload) => {
        Vue.set(state, 'requirementList', payload);
    }
};

const actions = {
    async setRequirementList(state, payload) {
        const response = await moduleRepository.all(payload.project_id);
        state.commit('setRequirementList', response.data.data);
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
