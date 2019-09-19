import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default new VueRouter({
	routes: [
		{   
			path: '/',
            redirect: { name: 'home' },
            component: Vue.component('Layout', require( './pages/Layout.vue').default),
            children: [
                {
                    path: 'home',
                    name: 'home',
                    component: Vue.component('Home', require( './pages/Home.vue').default)
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
                    path: 'about',
                    name: 'about',
                    component: Vue.component('About', require( './pages/About.vue').default)
                }
                // {
                // 	path: 'cafes/:slug/edit',
                // 	name: 'editcafe',
                // 	component: Vue.component( 'EditCafe', require( './pages/EditCafe.vue' ) ),
                // 	beforeEnter: requireAuth,
                // 	meta: {
                // 		permission: 'user'
                // 	}
                // },
            ]
        
        }
    ]
});