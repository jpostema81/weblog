import { strictEqual } from "assert";

export const MessageStore = {
    namespaced: true,
    state: 
    {
        messages: [],
        meta: [],
        filter: 
        {
            // selectedCategories: [],
            keyWord: ''
        }
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
        },
        setKeyword(state, keyword)
        {
            state.filter.keyWord = keyword;
        },
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
                    resolve();
                }).catch(function (error) {
                    reject(error);
                });
            });   
        },
        fetchMessagesByKeyword({commit, rootState}, keyword) 
        {
            return new Promise((resolve, reject) => {
                let url = '/api/messages/';

                axios({
                    method: 'get',
                    url: url,
                    params: { keyword: keyword },
                }).then(messages => {
                    commit('setMessages', messages.data.data);
                    commit('setMeta', messages.data.meta);
                    resolve();
                }).catch(function (error) {
                    reject(error);
                });
            });   
        },
        fetchAllMessages({commit, state, rootState, rootGetters}, pageNumber = 1) 
        {
            return new Promise((resolve, reject) => {
                let url = '/api/messages';
                let data = { page: pageNumber };

                // include filters
                // uitzoeken: is het netjes dat de filters verspreid zijn over meerdere VueX modules? (selectedCategories, keyWord)
                if(rootState.CategoryStore.selectedCategories.length) 
                {
                    data.categories = rootGetters['CategoryStore/getSelectedCategoryIds'];
                }

                if(state.filter.keyWord.length)
                {
                    data.keyword = state.filter.keyWord;
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
        addComment({commit, state, rootState, rootGetters}, payload) 
        {
            return new Promise((resolve, reject) => {
                let url = '/api/admin/comments';
                let data = payload;

                axios({
                    method: 'post',
                    url: url,
                    params: data,
                }).then(messages => {
                    // set parent of newly inserted comment as active message at BlogPost.vue page
                    commit('setMessages', [messages.data]);
                    resolve();
                }).catch(function (error) {
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