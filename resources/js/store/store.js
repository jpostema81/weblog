import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        messages: [],
        categories: [],
        selectedCategories: []
    },
    mutations: {
        setMessages(state, messages) {
            state.messages = messages;
        },
        setCategories(state, categories) {
            state.categories = categories;
        },
        setSelectedCategories(state, selectedCategories) {
            state.selectedCategories = selectedCategories;
        }
    },
    actions: {
        fetchCategories(context) {
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/categories')
                    .then(categories => {
                        context.commit('setCategories', categories.data);
                        context.commit('setSelectedCategories', categories.data);
                        resolve();
                    }, error => {
                        reject();
                    });
            });
        },
        fetchMessages(context) {
            return new Promise((resolve, reject) => {
                let url = '';

                if(this.state.selectedCategories.length > 0) {
                    url = '/api/messages?categories='+this.state.selectedCategories.join(',');
                } else {
                    url = '/api/messages';
                }

                axios
                    .get(url)
                    .then(messages => {
                        context.commit('setMessages', messages.data)
                        resolve();
                    }, error => {
                        reject();
                    })
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