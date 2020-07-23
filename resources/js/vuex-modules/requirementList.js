// initial state
const state = () => ({
    currentRequirement: {
        id : null,
        description : "",
        assigned : {},
        comments : []
    }
});

// getters
const getters = {
    currentRequirement: (state) => {
        return state.currentRequirement;
    }
};

// mutations
const mutations = {
    setRequirement: (state, payload) => {
        state.currentRequirement = payload;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations
};
