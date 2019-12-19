import MessageBus from './../../../messageBus';

export const DashboardMessageStore = {
    namespaced: true,
    state: 
    {
        messages: [],
        meta: [],
        filter: 
        {
            selectedCategories: [],
            keyWord: '',
        },
        status: '',
        errors: {},
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

        // filter mutations
        setKeyword(state, keyword)
        {
            state.filter.keyWord = keyword;
        },
        setSelectedCategories(state, selectedCategories) {
            state.filter.selectedCategories = selectedCategories;
        },
        resetFilters(state)
        {
            state.filter.selectedCategories = [];
            state.filter.keyWord = '';
        },

        // addMessage mutations
        addMessageRequest: (state)  =>
        {
            state.status = 'updating';
            state.errors = {};
        },
        addMessageSuccess: (state) =>
        {
            state.status = 'success';
            state.errors = {};
        },
        addMessageError: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        },

        // removeMessage mutations
        removeMessageRequest: (state)  =>
        {
            state.status = 'updating';
            state.errors = {};
        },
        removeMessageSuccess: (state) =>
        {
            state.status = 'success';
            state.errors = {};
        },
        removeMessageError: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        },

        // removeMessage mutations
        updateMessageRequest: (state)  =>
        {
            state.status = 'updating';
            state.errors = {};
        },
        updateMessageSuccess: (state) =>
        {
            state.status = 'success';
            state.errors = {};
        },
        updateMessageError: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        },
    },
    actions: 
    {
        // ook via filter implementeren?
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
        fetchMessages({commit, state, rootState, rootGetters}, pageNumber = 1) 
        {
            return new Promise((resolve, reject) => {
                let url = '/api/admin/messages';
                let data = { page: pageNumber };

                // include filters
                if(state.filter.selectedCategories.length) 
                {
                    data.categories = state.filter.selectedCategories.map(a => a.id).join();
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
        addMessage({commit, state, rootState, rootGetters}, { id, title, content, categories }) 
        {
            commit('addMessageRequest');

            return new Promise((resolve, reject) => {
                let url = '/api/admin/messages';
                let data = { id, title, content };
                
                if(categories.length > 0)
                {
                    data.categories = categories.map(a => a.id).join();
                }

                axios({
                    method: 'post',
                    url: url,
                    data,
                }).then(messages => {
                    commit('addMessageSuccess');
                    MessageBus.$emit('message', {message: 'Message created', variant: 'success'});
                    resolve(messages.data);
                }).catch(function (error) {
                    commit('addMessageError', error.response.data.errors);
                    MessageBus.$emit('message', {message: 'Something went wrong', variant: 'danger'});
                    reject(error);
                });
            });   
        },
        updateMessage({commit, state, rootState, rootGetters}, { id, title, content, categories }) 
        {
            commit('updateMessageRequest');

            return new Promise((resolve, reject) => {
                let url = `/api/admin/messages/${id}`;
                let data = { id, title, content, categories: categories.map(a => a.id).join() };

                axios({
                    method: 'put',
                    url: url,
                    data
                }).then(messages => {
                    commit('updateMessageSuccess');
                    MessageBus.$emit('message', {message: 'Message updated', variant: 'success'});
                    resolve(messages.data);
                }).catch(function (error) {
                    commit('updateMessageError', error.response.data.errors);
                    MessageBus.$emit('message', {message: 'Something went wrong', variant: 'danger'});
                    reject(error);
                });
            });   
        },
        deleteMessage({commit, state, rootState, rootGetters}, messageId) 
        {
            commit('removeMessageRequest');

            return new Promise((resolve, reject) => {
                let url = `/api/admin/messages/${messageId}`;

                axios({
                    method: 'delete',
                    url: url,
                }).then(messages => {
                    commit('removeMessageSuccess');
                    MessageBus.$emit('message', {message: 'Message deleted', variant: 'success'});
                    resolve();
                }).catch(function (error) {
                    commit('removeMessageError', error);
                    MessageBus.$emit('message', {message: 'Something went wrong', variant: 'danger'});
                    reject(error);
                });
            });   
        },
        deleteMessages({dispatch, commit, state, rootState, rootGetters}, messages) 
        {
            messages.forEach(messageId => {
                dispatch('deleteMessage' , messageId);
            });
        }
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