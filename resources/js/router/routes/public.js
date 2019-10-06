import Vue from 'vue';

const routes = [
    {
        path: 'home',
        name: 'home',
        component: Vue.component('Home', require( '../../pages/Home.vue').default)
    },
    {
        path: 'login',
        name: 'login',
        component: Vue.component('Login', require( '../../pages/Login.vue').default)
    },
    {
        path: 'profile',
        name: 'profile',
        component: Vue.component('Profile', require( '../../pages/Profile.vue').default)
    },
    {
        path: 'register',
        name: 'register',
        component: Vue.component('Register', require( '../../pages/Register.vue').default)
    }
];

export default routes.map(route => 
{
    const meta = 
    {
        public: true,
    }

    return { ...route, meta }
});