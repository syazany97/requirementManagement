window.axios = require('axios');
export const routes = [
    {
      path : '/login',
      name : 'login',
      component: require ('./views/auth/Login.vue').default
    },
    {
        path: '/projects',
        name: 'project.index',
        component: require('./views/projects/Index.vue').default
    },
    {
        path: '/projects/:project',
        name: 'project.show',
        component: require('./views/projects/ShowProject.vue').default
    },
    {
        path: '/requirements/:requirement/test-cases/create',
        name: 'test-case.create',
        component: require('./views/testCase/Create.vue').default
    },
    {
        path: '/test-cases/:testCase/edit',
        name: 'test-case.edit',
        component: require('./views/testCase/Create.vue').default
    },
];
