/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import store from './store/store';     // by default, load index.js in the imported directory

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import CategoryFilterComponent from './components/CategoryFilterComponent'

 // wait until DOM is loaded before loading vue root element
window.onload = function () {
    const app = new Vue({
        el: '#app',
        store: store,
        data: {
            showNav: false
        },
        components: {
            CategoryFilterComponent,
        },
    });
}

window.deteleMessage = function(messageId) {
    if(confirm('Are you sure?')) {
        $.ajax({
            url: '/admin/messages/' + messageId,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                location.reload();
            },
            error: function(result) {
                alert('There was an error');
            }
        })
    }
}
