const resource = 'comments'

window.axios = require('axios');

axios.interceptors.response.use(
    res => res,
    err => {
        if (err.response.status === 401) {
            // refresh page if 401 unauthenticated
            location.replace('/login');
        }
        throw err;
    }
);

export default {
    find(id) {
        return axios.get(`/api/${resource}/${id}`)
    },
    delete(id) {
        return axios.delete(`/api/${resource}/${id}`);
    }
}
