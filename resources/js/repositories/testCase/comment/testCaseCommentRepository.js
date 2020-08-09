const resource = 'test-cases'

window.axios = require('axios');

export default {
    all(requirementId) {
        return axios.get(`/api/${resource}/${requirementId}/comments`);
    },
    store(requirementId, payload) {
        return axios.post(`/api/${resource}/${requirementId}/comments`, payload)
    }
}
