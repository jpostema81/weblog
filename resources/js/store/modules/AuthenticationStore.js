import { AUTH_REQUEST, AUTH_SUCCESS, AUTH_ERROR, LOGOUT, SET_USER, AUTHENTICATE_BY_TOKEN,
     AUTHENTICATE_BY_USER_CREDENTIALS, REGISTER } from '../mutation_types';

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

        [LOGOUT]: (state) => 
        {
            state.status = '';
            state.token = '';
            state.user = '';
        },
        [SET_USER]: (state, user) => 
        {
            state.user = user;
        },
    },
    actions: 
    {
        // authenticate by JWT token (token from login or local storage)
        [AUTHENTICATE_BY_TOKEN]: ({commit, state}) => 
        {
            return new Promise((resolve, reject) => 
            {
                axios({ url: '/api/get_user_by_token', data: {token: state.token}, method: 'POST' }).then(resp => 
                {
                    const user = resp.user;
                    commit(AUTH_SUCCESS, token);
                    commit(SET_USER, user);
                    resolve(resp.data);
                })
                .catch(err => 
                {
                    commit(AUTH_ERROR, err);
                    reject(err);
                });
            });
        },
        // authenticate by user login (email & password)
        [AUTHENTICATE_BY_USER_CREDENTIALS]: ({commit}, user) => 
        {
            return new Promise((resolve, reject) => 
            { 
                commit(AUTH_REQUEST);

                console.log('before login request');

                axios({ url: '/api/login', data: user, method: 'POST' }).then(resp => 
                {
                    const token = resp.data.access_token;
                    const user = resp.data.user;

                    // store the token in localstorage
                    localStorage.setItem('user-token', token);  
                    // set authorization token in default headers
                    axios.defaults.headers.common['Authorization'] = token;
                    commit(AUTH_SUCCESS, token);
                    // token received, set user
                    commit(SET_USER, user);

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
        // logout a user
        [LOGOUT]: ({commit}) => 
        {
            return new Promise((resolve, reject) => 
            {
                commit(LOGOUT);
                // clear your user's token from localstorage
                localStorage.removeItem('user-token');
                // unset authorization token in default headers
                delete axios.defaults.headers.common['Authorization'];
                // set authorization token in default headers
                resolve();
            });
        },
        // register a new user
        [REGISTER]: ({commit, dispatch}, user) => 
        {
            return new Promise((resolve, reject) => 
            { 
                commit(AUTH_REGISTER);

                axios({ url: '/api/register', data: user, method: 'POST' }).then(resp => 
                    {
                        const token = resp.data.access_token;
                        // store the token in localstorage
                        localStorage.setItem('user-token', token);  
                        // set authorization token in default headers
                        axios.defaults.headers.common['Authorization'] = token;
                        commit(AUTH_SUCCESS, token);
                        // token received, get user
                        commit(SET_USER);
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
        },
        user: (state) =>
        {
            return state.user;
        }
    }
}