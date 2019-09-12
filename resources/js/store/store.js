import Vue from 'vue';
import Vuex from 'vuex';
import { CategoryStore } from './modules/CategoryStore.js';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        CategoryStore
    }
})