import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        messages: [],
        categories: []
    },
    mutations: {
        setMessages(state, messages) {
            state.messages = messages;
        },
        setCategories(state, categories) {
            state.categories = categories;
        }
    },
    actions: {
        fetchCategories(context) {
            axios
                .get('/categories')
                .then(categories => {
                    context.commit('setCategories', categories.data)
                });
        },
        fetchMessages(context) {
            axios
                .get('/api/messages')
                .then(messages => {
                    context.commit('setMessages', messages.data)
                });
        }         
    },
    getters: {
        messages: state => {
            return state.messages;
        },
        categories: state => {
            return state.categories;
        }
    }
})