
window.axios = require('axios');

const resource = 'requirements';

export default {
    all(moduleId) {
        return axios.get(`/api/modules/${moduleId}/${resource}`);
    },
    store(moduleId, payload) {
        return axios.post(`/api/modules/${moduleId}/${resource}`, payload);
    },
    update(id, payload) {
        return axios.patch(`/api/requirements/${id}`, payload);
    },
    find(requirementId) {
        return axios.get(`/api/${resource}/${requirementId}`);
    },
    updateParentId(id, payload) {
        return axios.patch(`/api/${resource}/${id}/update-parent-id`, payload);
    }
}
