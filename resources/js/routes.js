import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//import AuthenticationComponent from './frontend/AuthenticationComponent.vue';

export const router = new VueRouter({
	routes: [
		{   
			path: '/',
            redirect: { name: 'home' },
            component: Vue.component('Layout', require( './layouts/Layout.vue').default),
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
                    path: 'login',
                    name: 'login',
                    component: Vue.component('Login', require( './pages/Login.vue').default)
                },
                {
                    path: 'register',
                    name: 'register',
                    component: Vue.component('Register', require( './pages/Register.vue').default)
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

router.beforeEach((to, from, next) => 
{
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['/', '/login', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('user');
  
    if (authRequired && !loggedIn) {
    //   return next('/login');
    }
  
    next();
});