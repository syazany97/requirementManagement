const resource = 'modules'

window.axios = require('axios');

export default {
    all(projectId) {
        return axios.get(`/api/projects/${projectId}/${resource}`)
    },
    store(payload, projectId) {
        return axios.post(`/api/projects/${projectId}/${resource}`, payload)
    },
    find(id) {
        return axios.get(`/api/${resource}/${id}`)
    }
}
