const resource = 'users'

window.axios = require('axios');

export default {
    all(userId) {
        return axios.get(`/api/users`);
    },
    find(id) {
        return axios.get(`/api/users/${id}`)
    }
}
