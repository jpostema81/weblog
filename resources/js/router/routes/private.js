const routes = [
    {
        path: 'home',
        name: 'home',
        component: Vue.component('Home', require( '../../pages/Home.vue').default)
        // children: [
            // {
            //     path: 'new',
            //     name: 'newcafe',
            //     component: Vue.component( 'NewCafe', require( './pages/NewCafe.vue' ) ),
            //     beforeEnter: requireAuth,
            //     meta: {
            //         permission: 'user'
            //     }
            // },
            // {
            //     path: ':slug',
            //     name: 'cafe',
            //     component: Vue.component( 'Cafe', require( './pages/Cafe.vue' ) )
            // },
            // {
            //     path: 'cities/:slug',
            //     name: 'city',
            //     component: Vue.component( 'City', require( './pages/City.vue' ))
            // }
        // ]
    },
    {
        path: 'login',
        name: 'login',
        component: Vue.component('Login', require( '../../pages/Login.vue').default)
    },
    {
        path: 'register',
        name: 'register',
        component: Vue.component('Register', require( '../../pages/Register.vue').default)
    }
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