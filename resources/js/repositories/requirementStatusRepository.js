
window.axios = require('axios');

export default {
    all() {
        return axios.get('requirement-statuses');
    }
}
