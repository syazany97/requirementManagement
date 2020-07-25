
window.axios = require('axios');

export default {
    all() {
        return axios.get('/api/requirement-priorities');
    }
}
