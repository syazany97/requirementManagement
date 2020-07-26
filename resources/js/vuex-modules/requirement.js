// initial state
import moduleRepository from "../repositories/moduleRepository";
import requirementStatusRepository from "../repositories/requirementStatusRepository";
import requirementPriorities from "../repositories/requirementPriorities";

const state = () => ({
    currentRequirement: {
        id : null,
        description : "",
        assigned : {},
        comments : []
    },
    requirementList : [],
    statuses : [],
    priorities : []
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
    },
    priorities : (state) => {
        return state.priorities
    }
};

// mutations
const mutations = {
    setRequirement: (state, payload) => {
        state.currentRequirement = payload;
    },
    setRequirementList: (state, payload) => {
        Vue.set(state, 'requirementList', payload);
    },
    setRequirementStatuses: (state, payload) => {
        Vue.set(state, 'statuses', payload);
    },
    setPriorities : (state, payload) => {
        Vue.set(state, 'priorities', payload);
    }
};

const actions = {
    async setRequirementList(state, payload) {
        const response = await moduleRepository.all(payload.project_id);
        console.log('response modules', response.data);
        state.commit('setRequirementList', response.data.data);
    },
    async setRequirementStatuses(state, payload) {
        const response = await requirementStatusRepository.all();
        // console.log('statuses', response.data);
        state.commit('setRequirementStatuses', response.data);
    },
    async setPriorities(state, payload) {
        const response = await requirementPriorities.all();
        // console.log('priorities', response.data);
        state.commit('setPriorities', response.data);
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
