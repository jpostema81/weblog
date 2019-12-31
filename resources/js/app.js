/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./interceptors');

import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import store from './store/store';
import router from './router/index';
import Multiselect from 'vue-multiselect';
import MessageBus from './messageBus';
import VueSidebarMenu from 'vue-sidebar-menu'

import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'


// wait until DOM is loaded before loading vue root element
window.onload = function () 
{
    Vue.use(BootstrapVue);
    Vue.component('Multiselect', Multiselect);
    Vue.use(VueSidebarMenu)

    const app = new Vue({
        el: '#app',
        store,
        router,
        data: 
        {
            showNav: false
        },
        created() 
        {
            // check if there is a token in localStorage
            if(localStorage.getItem('user-token'))
            {
                // token found, try to get user by token
                this.$store.dispatch('AuthenticationStore/authenticateByToken').then(data => {}).catch(error => 
                {
                    // token is invalid, delete token from localStorage so it doesn't get attached to the request headers by 
                    // the axios interceptor
                    localStorage.removeItem('user-token');
                });
            }
        }
    });

    MessageBus.$app = app;
}