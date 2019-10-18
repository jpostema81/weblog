import Vue from 'vue';

const routes = [
    {
        path: '/profile',
        name: 'profile',
        component: Vue.component('Profile', require( '../../pages/Profile.vue').default)
    },
    // {
    // 	path: 'cafes/:slug/edit',
    // 	name: 'editcafe',
    // 	component: Vue.component( 'EditCafe', require( '../../pages/EditCafe.vue' ) ),
    // 	beforeEnter: requireAuth,
    // 	meta: {
    // 		permission: 'user'
    // 	}
    // },
];

export default routes.map(route => 
{
    const meta = 
    {
        public: false,
    }

    return { ...route, meta }
});