import Vue from 'vue';

const routes = [
    {
        path: '/dashboard/profile',
        name: 'profile',
        component: Vue.component('Profile', require( '../../pages/dashboard/Profile.vue').default)
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Vue.component('Dashboard', require( '../../pages/dashboard/Dashboard.vue').default)
    },
    {
        path: '/dashboard/blogposts',
        name: 'dashboardBlogpostsOverview',
        component: Vue.component('BlogpostsOverview', require( '../../pages/dashboard/BlogpostsOverview.vue').default)
    },
    {
        path: '/dashboard/blogposts/:blogPostId/edit',
        name: 'blogpostEdit',
        component: Vue.component('blogpostNewEdit', require( '../../pages/dashboard/blogpostNewEdit.vue').default)
    },
    {
        path: '/dashboard/blogposts/create',
        name: 'blogpostNew',
        component: Vue.component('blogpostNewEdit', require( '../../pages/dashboard/blogpostNewEdit.vue').default)
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