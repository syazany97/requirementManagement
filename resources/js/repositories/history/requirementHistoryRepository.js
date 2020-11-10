const resource = 'requirements'

window.axios = require('axios');

export default {
    all(requirementId) {
        return axios.get(`/api/requirements/${requirementId}/histories`);
    }
}
