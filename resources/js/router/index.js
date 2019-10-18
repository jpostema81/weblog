import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store/store';  

Vue.use(VueRouter);

const publicRoutes = require('../router/routes/public').default;
const privateRoutes = require('../router/routes/private').default;


const router = new VueRouter({
	routes: [
		{   
			path: '/',
            redirect: { name: 'home' },
            component: Vue.component('Layout', require( '../layouts/Layout.vue').default),
            children: [...publicRoutes, ...privateRoutes],
        }
    ]
});

router.beforeEach((to, from, next) => 
{
    // redirect to login page if not logged in and trying to access a restricted page
    const authRequired = !to.matched.some(record => record.meta.public);
    const loggedIn = store.getters['AuthenticationStore/isAuthenticated'];
  
    if(authRequired && !loggedIn) 
    {
        return next('/login');
    }
  
    next();
});


export default router;