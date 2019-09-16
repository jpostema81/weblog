export const CategoryStore = {
    namespaced: true,
    state: {
        messages: [],
        categories: [],
        selectedCategories: [],
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
        fetchCategories({state, commit, rootState}) {
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/categories')
                    .then(categories => {
                        commit('setCategories', categories.data);
                        //context.commit('setSelectedCategories', categories.data);
                        resolve();
                    }, error => {
                        reject();
                    });
            });
        },
        fetchMessages({state, commit, rootState}) {
            return new Promise((resolve, reject) => {
                let url = '';

                if(state.selectedCategories.length > 0) {
                    url = '/api/messages?categories='+state.selectedCategories.join(',');
                } else {
                    url = '/api/messages';
                }

                axios
                    .get(url)
                    .then(messages => {
                        commit('setMessages', messages.data)
                        resolve();
                    }, error => {
                        reject();
                    })
            });   
        }
    },
    getters: {
        messages: (state, commit, rootState) => {
            return state.messages;
        },
        categories:  (state, commit, rootState) => {
            return state.categories;
        }
    }
}