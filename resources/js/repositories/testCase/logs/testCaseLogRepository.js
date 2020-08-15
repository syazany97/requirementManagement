const resource = 'test-cases'

window.axios = require('axios');

export default {
    all(id) {
        return axios.get(`/api/${resource}/${id}/logs`)
    }
}
