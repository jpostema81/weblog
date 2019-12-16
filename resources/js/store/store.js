import Vue from 'vue';
import Vuex from 'vuex';

// import VueX modules

// front-end
import { CategoryStore } from './modules/CategoryStore.js';
import { MessageStore } from './modules/MessageStore.js';
import { AuthenticationStore } from './modules/AuthenticationStore';

// dashboard
import { DashboardMessageStore } from './modules/dashboard/DashboardMessageStore';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        CategoryStore,
        MessageStore,
        AuthenticationStore,
        DashboardMessageStore,
    }
})