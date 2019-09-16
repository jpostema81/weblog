export const MessageStore = {
    namespaced: true,
    state: {
        messages: []
    },
    mutations: {
        setMessages(state, messages) {
            state.messages = messages;
        }
    },
    actions: {
        fetchMessages({state, commit, rootState}) {
            return new Promise((resolve, reject) => {
                let url = '';

                if(rootState.CategoryStore.selectedCategories.length > 0) {
                    url = '/api/messages?categories='+rootState.CategoryStore.selectedCategories.join(',');
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
        }
    }
}