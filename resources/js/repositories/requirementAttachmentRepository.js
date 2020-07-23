const resource = 'requirements'

window.axios = require('axios');

export default {
    all(requirementId) {
        return axios.get(`/api/requirements/${requirementId}/attachments`);
    },
    store(requirementId, payload) {
        return axios.post(`/api/${resource}/${requirementId}/attachments`, payload)
    },
    delete(id) {
        return axios.delete(`/api/comments/${id}`);
    }
}
