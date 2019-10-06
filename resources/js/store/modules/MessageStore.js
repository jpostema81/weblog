export const MessageStore = {
    namespaced: true,
    state: 
    {
        messages: []
    },
    mutations: 
    {
        setMessages(state, messages) 
        {
            state.messages = messages;
        }
    },
    actions: 
    {
        fetchMessages({state, commit, rootState, rootGetters}) 
        {
            return new Promise((resolve, reject) => {
                let url = '';

                if(rootGetters['CategoryStore/getSelectedCategoryIds'].length > 0) 
                {
                    url = '/api/messages?categories='+rootGetters['CategoryStore/getSelectedCategoryIds'].join(',');
                } 
                else 
                {
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
    getters: 
    {
        messages: (state, commit, rootState) => {
            return state.messages;
        }
    }
}