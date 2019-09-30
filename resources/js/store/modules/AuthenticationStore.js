import { AUTH_REQUEST, AUTH_SUCCESS, AUTH_ERROR, AUTH_LOGOUT, SET_USER, USER_REQUEST } from '../mutation_types';

export const AuthenticationStore = 
{
    namespaced: true,
    state: 
    {
        token: localStorage.getItem('user-token') || '',
        status: '',
        user: '',
    },
    mutations: 
    {
        [AUTH_REQUEST]: (state) => 
        {
            state.status = 'loading';
        },
        [AUTH_SUCCESS]: (state, token) => 
        {
            state.status = 'success';
            state.token = token;
        },
        [AUTH_ERROR]: (state) => 
        {
            state.status = 'error';
        },
        [AUTH_LOGOUT]: (state) => 
        {
            state.status = '';
            state.token = '';
            state.user = '';
        },
        [USER_REQUEST]: (state, user) => 
        {
            state.user = user;
        },
    },
    actions: 
    {
        // get user by token (token from login or local storage)
        [USER_REQUEST]: ({commit, dispatch, state}) => 
        {
            return new Promise((resolve, reject) => 
            {
                axios({ url: '/api/get_user_by_token', data: {token: state.token}, method: 'POST' })
                    .then(resp => 
                        {
                            commit(USER_REQUEST);
                            resolve(resp.data);
                        })
                    .catch(err => 
                        {
                            commit(AUTH_ERROR, err);
                            reject(err);
                        });
            });
        },
        [AUTH_REQUEST]: ({commit, dispatch}, user) => 
        {
            // The Promise used for router redirect in login
            return new Promise((resolve, reject) => 
            { 
                commit(AUTH_REQUEST);
                // Good practice: pass the login credentials in the request body, not in the URL. 
                // The reason behind it is that servers might log URLs, so you don’t have to worry 
                // about credential leaks through logs.
                axios({ url: '/api/login', data: user, method: 'POST' })
                    .then(resp => 
                        {
                            const token = resp.data.access_token;
                            // store the token in localstorage
                            localStorage.setItem('user-token', token);  
                            // set authorization token in default headers
                            axios.defaults.headers.common['Authorization'] = token;
                            commit(AUTH_SUCCESS, token);
                            // token received, get user
                            dispatch(USER_REQUEST);
                            resolve(resp);
                        })
                .catch(err => 
                    {
                        commit(AUTH_ERROR, err);
                        // if the request fails, remove any possible user token if possible
                        localStorage.removeItem('user-token');  
                        reject(err);
                    });
            });
        },
        [AUTH_LOGOUT]: ({commit, dispatch}) => 
        {
            return new Promise((resolve, reject) => 
            {
                commit(AUTH_LOGOUT);
                // clear your user's token from localstorage
                localStorage.removeItem('user-token');
                // unset authorization token in default headers
                delete axios.defaults.headers.common['Authorization'];
                // set authorization token in default headers
                resolve();
            });
        }   
    },
    getters: 
    {
        isAuthenticated: (state) => 
        {
            return !!state.token;
        },
        authStatus: (state) => 
        {
            return state.status;
        }
    }
}