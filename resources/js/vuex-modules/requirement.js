// initial state
import moduleRepository from "../repositories/moduleRepository";
import requirementStatusRepository from "../repositories/requirementStatusRepository";
import requirementPriorities from "../repositories/requirementPriorities";
import requirementRepository from "../repositories/requirementRepository";

const qs = require('qs');

const state = () => ({
    currentRequirement: {
        id: null,
        description: "",
        assigned: {},
        comments: []
    },
    requirementList: [],
    statuses: [],
    priorities: [],
    filteredRequirementList: [],
    tabs: [
        {
            tab: 'Requirement', component: 'requirement-details', props: {}
        },
        {
            tab: 'Test Case', component: 'test-case-details', props: {}
        },
        {
            tab: 'History',
            component: 'requirement-history',
            props: {
                objectId: null,
                historyType: 'requirement'
            }
        }
    ],
    currentTab: 'requirement-details',
    firstLoad: true
});

// getters
const getters = {
    currentRequirement: (state) => {
        return state.currentRequirement;
    },
    requirementList: (state) => {
        return state.requirementList;
    },
    filteredRequirementList: (state) => {
        return state.filteredRequirementList;
    },
    statuses: (state) => {
        return state.statuses
    },
    priorities: (state) => {
        return state.priorities
    },
    tabs: (state) => {
        return state.tabs
    },
    currentTab: (state) => {
        return state.currentTab
    },
    firstLoad: (state) => {
        return state.firstLoad
    },
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
    setPriorities: (state, payload) => {
        Vue.set(state, 'priorities', payload);
    },
    setFilteredRequirementList: (state, payload) => {
        state.filteredRequirementList = _.filter(state.filteredRequirementList, {'name': payload});
    },
    tabs: (state, payload) => {
        state.tabs = payload;
    },
    currentTab: (state, payload) => {
        state.currentTab = payload;
    },
    firstLoad: (state, payload) => {
        state.firstLoad = payload;
    },
};

const actions = {
    async setRequirementList(state, payload) {
        const response = await moduleRepository.all(payload.project_id);
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
    },
    async updateQueryParam(state) {

        let queryString = qs.parse(location.search.split('?')[1]);

        let query = "";

        if (state.state.firstLoad && queryString.hasOwnProperty('tab')) {
            console.log('firstLoad');
            state.commit('currentTab', queryString.tab);
        }

        query += `requirement=${state.state.currentRequirement.id}`;

        query += `&tab=${state.state.currentTab}`;

        state.commit('firstLoad', false);

        history.pushState(
            {},
            "",
            "?" + query
        );

    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
