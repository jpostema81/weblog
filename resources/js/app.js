/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./interceptors');


import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import store from './store/store';     // by default, load index.js in the imported directory
import router from './router/index';
import Multiselect from 'vue-multiselect';

Vue.use(BootstrapVue);
Vue.component('Multiselect', Multiselect);


// wait until DOM is loaded before loading vue root element
window.onload = function () 
{
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
}

// onderstaande code repeterend?

window.deteleMessage = function(messageId) {
    if(confirm('Are you sure?')) {
        $.ajax({
            url: '/admin/messages/' + messageId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                if(result.status === '0') {
                    alert(result.message);
                } else {
                    location.reload();
                }
            },
            error: function(result) {
                alert('There was an error');
            }
        })
    }
}

window.deteleCategory = function(categoryId) {
    if(confirm('Are you sure?')) {
        $.ajax({
            url: '/admin/categories/' + categoryId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                if(result.status === '0') {
                    alert(result.message);
                } else {
                    location.reload();
                }
            },
            error: function(result) {
                alert('There was an error');
            }
        })
    }
}

window.deteleRole = function(roleId) {
    if(confirm('Are you sure?')) {
        $.ajax({
            url: '/admin/roles/' + roleId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                if(result.status === '0') {
                    alert(result.message);
                } else {
                    location.reload();
                }
            },
            error: function(result) {
                alert('There was an error');
            }
        })
    }
}

window.detelePermission = function(permissionId) {
    if(confirm('Are you sure?')) {
        $.ajax({
            url: '/admin/permissions/' + permissionId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                if(result.status === '0') {
                    alert(result.message);
                } else {
                    location.reload();
                }
            },
            error: function(result) {
                alert('There was an error');
            }
        })
    }
}

window.deteleUser = function(userId) {
    if(confirm('Are you sure?')) {
        $.ajax({
            url: '/admin/users/' + userId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                if(result.status === '0') {
                    alert(result.message);
                } else {
                    location.reload();
                }
            },
            error: function(result) {
                alert('There was an error');
            }
        })
    }
}
