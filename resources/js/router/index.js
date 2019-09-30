import Vue from 'vue';
import VueRouter from 'vue-router';


Vue.use(VueRouter);

const router = new VueRouter({
	routes: [
		{   
			path: '/',
            redirect: { name: 'home' },
            component: Vue.component('Layout', require( '../layouts/Layout.vue').default),
            children: require('../router/routes/public').default
        }
    ]
});

router.beforeEach((to, from, next) => 
{
    // redirect to login page if not logged in and trying to access a restricted page
    const authRequired = !to.matched.some(record => record.meta.public);
    const loggedIn = localStorage.getItem('user');
  
    if (authRequired && !loggedIn) {
        return next('/login');
    }
  
    next();
});

export default router;