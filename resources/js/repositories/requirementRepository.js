
window.axios = require('axios');

const resource = 'requirements';

export default {
    all(moduleId) {
        return axios.get(`/api/modules/${moduleId}/${resource}`);
    },
    store(moduleId, payload) {
        return axios.post(`/api/modules/${moduleId}/${resource}`, payload);
    },
    find(requirementId) {
        return axios.get(`/api/${resource}/${requirementId}`);
    }
}
