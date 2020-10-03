const resource = 'projects'

window.axios = require('axios');

export default {
    store(payload) {
        return axios.post(`/api/${resource}`, payload)
    },
    find(id) {
        return axios.get(`/api/${resource}/${id}`)
    },
    getProjectStatuses() {
        return axios.get('/api/project-statuses');
    },
    delete(id) {
        return axios.delete(`/api/${resource}/${id}`);
    }
}
