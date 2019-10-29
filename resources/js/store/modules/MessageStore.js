export const MessageStore = {
    namespaced: true,
    state: 
    {
        messages: [],
        meta: [],
    },
    mutations: 
    {
        setMessages(state, messages) 
        {
            state.messages = messages;
        },
        setMeta(state, meta) 
        {
            state.meta = meta;
        }
    },
    actions: 
    {
        fetchMessageById({state, commit, rootState, rootGetters}, messageId) 
        {
            return new Promise((resolve, reject) => {
                let url = '/api/messages/' + messageId;

                axios({
                    method: 'get',
                    url: url,
                }).then(messages => {
                    commit('setMessages', [messages.data.data]);
                    commit('setMeta', messages.data.meta);
                    resolve();
                }).catch(function (error) {
                    reject(error);
                });
            });   
        },
        fetchAllMessages({state, commit, rootState, rootGetters}, pageNumber = 1) 
        {
            return new Promise((resolve, reject) => {
                let url = '/api/messages';
                let data = { page: pageNumber };

                if(rootGetters['CategoryStore/getSelectedCategoryIds'].length > 0) 
                {
                    data.categories = rootGetters['CategoryStore/getSelectedCategoryIds'].join(',');
                }

                axios({
                    method: 'get',
                    url: url,
                    params: data,
                }).then(messages => {
                    commit('setMessages', messages.data.data);
                    commit('setMeta', messages.data.meta);
                    resolve();
                }).catch(function (error) {
                    reject(error);
                });
            });   
        },
        getMessageById({state, commit}, id) {
            return new Promise((resolve, reject) => {
                let url = 'api/messages/' + id;

                axios.get(url).then(message => {
                    console.log(message);
                    commit('setMessages', [message.data.data]);
                    resolve();
                }).catch(function (error) {
                    console.log(error);
                    reject(error);
                });
            });   
        },
    },
    getters: 
    {
        messages: (state, commit, rootState) => {
            return state.messages;
        },
        message: (state, commit, rootState) => {
            return state.messages[0];
        },
        meta: (state, commit, rootState) => {
            return state.meta;
        }
    }
}