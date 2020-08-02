const resource = 'requirements'

window.axios = require('axios');

export default {
    all(requirementId) {
        return axios.get(`/api/requirements/${requirementId}/test-cases`);
    },
    store(requirementId, payload) {
        return axios.post(`/api/${resource}/${requirementId}/test-cases`, payload)
    },
    find(id) {
        return axios.get(`/api/test-cases/${id}`)
    },
    delete(id) {
        return axios.delete(`/api/test-cases/${id}`);
    }
}
