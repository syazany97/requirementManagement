const resource = 'comments'

window.axios = require('axios');

export default {
    find(id) {
        return axios.get(`/api/${resource}/${id}`)
    },
    delete(id) {
        return axios.delete(`/api/${resource}/${id}`);
    }
}
