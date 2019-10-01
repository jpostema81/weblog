import Vue from 'vue';
import Vuex from 'vuex';

// import VueX modules
import { CategoryStore } from './modules/CategoryStore.js';
import { MessageStore } from './modules/MessageStore.js';
import { AuthenticationStore } from './modules/AuthenticationStore';
import { AlertStore } from './modules/AlertStore';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        CategoryStore,
        MessageStore,
        AuthenticationStore,
        AlertStore,
    }
})