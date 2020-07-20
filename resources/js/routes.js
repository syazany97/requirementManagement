window.axios = require('axios');
export const routes = [
    {
        path: '/projects',
        name: 'project.index',
        component: require('./views/projects/Index.vue').default
    },
    {
        path: '/projects/:project',
        name: 'project.show',
        component: require('./views/projects/Show.vue').default
    }
];
