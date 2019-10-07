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
        fetchMessages({state, commit, rootState, rootGetters}, pageNumber = 1) 
        {
            return new Promise((resolve, reject) => {
                let url = '/api/messages';
                let data = { pageNumber: pageNumber };

                if(rootGetters['CategoryStore/getSelectedCategoryIds'].length > 0) 
                {
                    data.categories = rootGetters['CategoryStore/getSelectedCategoryIds'].join(',');
                }

                axios({
                    method: 'get',
                    url: url,
                    params: data,
                  }).then(messages => {
                    commit('setMessages', messages.data.data)
                    resolve();
                }, error => {
                    reject();
                });
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