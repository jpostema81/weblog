import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        categories: []
    },
    mutations: {
        setCategories(state, categories) {
            state.categories = categories;
        }
    },
    actions: {
        fetchCategories(context) {
            axios
                .get('/categories')
                .then(categories => {
                    context.commit('setCategories', categories)
                });
        }            
    }
})