// initial state
import moduleRepository from "../repositories/moduleRepository";
import requirementStatusRepository from "../repositories/requirementStatusRepository";
import requirementPriorities from "../repositories/requirementPriorities";
import requirementRepository from "../repositories/requirementRepository";

const state = () => ({
    currentRequirement: {
        id: null,
        description: "",
        assigned: {},
        comments: []
    },
    requirementList: [],
    statuses: [],
    priorities: []
});

// getters
const getters = {
    currentRequirement: (state) => {
        return state.currentRequirement;
    },
    requirementList: (state) => {
        return state.requirementList;
    },
    statuses: (state) => {
        return state.statuses
    },
    priorities: (state) => {
        return state.priorities
    }
};

// mutations
const mutations = {
    setRequirement: (state, payload) => {
        state.currentRequirement = payload;
        // Vue.set(state, 'currentRequirement', payload);
    },
    setRequirementList: (state, payload) => {
        Vue.set(state, 'requirementList', payload);
    },
    setRequirementStatuses: (state, payload) => {
        Vue.set(state, 'statuses', payload);
    },
    setPriorities: (state, payload) => {
        Vue.set(state, 'priorities', payload);
    }
};

const actions = {
    async setRequirementList(state, payload) {
        const response = await moduleRepository.all(payload.project_id);
        console.log('data', response.data.data);
        state.commit('setRequirementList', response.data.data);
    },
    async setRequirementStatuses(state, payload) {
        const response = await requirementStatusRepository.all();
        state.commit('setRequirementStatuses', response.data);
    },
    async setPriorities(state, payload) {
        const response = await requirementPriorities.all();
        state.commit('setPriorities', response.data);
    },
    async setRequirement(state, requirementId) {
        const response = await requirementRepository.find(requirementId);
        state.commit('setRequirement', response.data.data);
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
