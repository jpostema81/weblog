import { AUTH_REQUEST, AUTH_SUCCESS, AUTH_ERROR, LOGOUT, SET_USER, AUTHENTICATE_BY_TOKEN,
     LOGIN, REGISTER, REGISTER_REQUEST, REGISTER_SUCCESS, REGISTER_ERROR,
     ALERT_ERROR, ALERT_CLEAR, ALERT_SUCCESS } from '../mutation_types';

import router from '../../router/index';

export const AuthenticationStore = 
{
    namespaced: true,
    state: 
    {
        status: '',
        errors: {},
        user: '',
    },
    mutations: 
    {
        // authentication state
        [AUTH_REQUEST]: (state) => 
        {
            state.status = 'loading';
            state.errors = {};
        },
        [AUTH_SUCCESS]: (state) => 
        {
            state.status = 'success';
            state.errors = {};
        },
        [AUTH_ERROR]: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        },

        [LOGOUT]: (state) => 
        {
            state.status = '';
            state.user = '';
        },
        [SET_USER]: (state, user) => 
        {
            state.user = user;
        },

        // registration state
        [REGISTER_REQUEST]: (state, user)  =>
        {
            state.status = 'registering';
            state.errors = {};
        },
        [REGISTER_SUCCESS]: (state, user) =>
        {
            state.status = 'success';
            state.errors = {};
        },
        [REGISTER_ERROR]: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        }
    },
    actions: 
    {
        // authenticate by JWT token (token from login or local storage)
        [AUTHENTICATE_BY_TOKEN]: ({commit, state}) => 
        {
            return new Promise((resolve, reject) => 
            {
                axios({ url: '/api/get_user_by_token', method: 'POST' }).then(resp => 
                {
                    const user = resp.data;
                    commit(AUTH_SUCCESS);
                    commit(SET_USER, user);
                    resolve(resp);
                })
                .catch(err => 
                {
                    commit(AUTH_ERROR, err);
                    reject(err);
                });
            });
        },
        // authenticate by user login (email & password)
        [LOGIN]: ({commit, dispatch}, user) => 
        {
            return new Promise((resolve, reject) => 
            { 
                commit(AUTH_REQUEST);

                axios({ url: '/api/login', data: user, method: 'POST' }).then(resp => 
                {
                    const token = resp.data.access_token;
                    const user = resp.data.user;

                    // store the token in localstorage
                    localStorage.setItem('user-token', token);
                    commit(AUTH_SUCCESS);
                    // token received, set user
                    commit(SET_USER, user);

                    resolve(resp);
                })
                .catch(error => 
                {
                    dispatch('AlertStore/' + ALERT_ERROR, 'Something went wrong', { root: true });
                    commit(AUTH_ERROR, error.response.data);
                    
                    // if the request fails, remove any possible user token if possible
                    localStorage.removeItem('user-token');
                    reject(error);
                });
            });
        },
        // logout a user
        [LOGOUT]: ({commit, dispatch}) => 
        {
            return new Promise((resolve, reject) => 
            {
                commit(LOGOUT);
                
                axios({ url: '/api/logout', method: 'POST' }).then(resp => 
                {
                    // clear your user's token from localstorage
                    localStorage.removeItem('user-token');
                    dispatch('AlertStore/' + ALERT_ERROR, 'You are logged out now!', { root: true });
                    resolve(resp);
                })
                .catch(error => 
                {
                    dispatch('AlertStore/' + ALERT_ERROR, 'Something went wrong during logging out', { root: true });
                    // clear your user's token from localstorage
                    localStorage.removeItem('user-token');
                    //commit(LOGOUT_ERROR, error.response.data);
                    reject(error);
                });

                
            });
        },
        // register a new user
        [REGISTER]: function({commit, dispatch, context}, user) {
            commit(REGISTER_REQUEST, user);

            return new Promise((resolve, reject) => { 
                axios({ url: '/api/register', data: user, method: 'POST' }).then(resp => 
                {
                    commit(REGISTER_SUCCESS, user);
                    router.push('/login');

                    setTimeout(() => {
                        // display success message after route change completes
                        dispatch('AlertStore/' + ALERT_SUCCESS, 'Registration successful', { root: true });
                    })

                    resolve(resp);
                })
                .catch(error => 
                {
                    dispatch('AlertStore/' + ALERT_ERROR, 'Something went wrong', { root: true });

                    if (error.response) 
                    {
                        /*
                         * The request was made and the server responded with a
                         * status code that falls out of the range of 2xx
                         */
                        console.log(error.response.data);
                        commit(REGISTER_ERROR, error.response.data);
     
                    } 
                    else if (error.request) 
                    {
                        /*
                         * The request was made but no response was received, `error.request`
                         * is an instance of XMLHttpRequest in the browser and an instance
                         * of http.ClientRequest in Node.js
                         */
                        console.log(error.request);
                    } 
                    else 
                    {
                        // Something happened in setting up the request and triggered an Error
                        console.log('Error', error.message);
                    }

                    //const errors = Object.values(err.response.data).join(' ');
                    reject(error);
                });
            });
        },
    },
    getters: 
    {
        isAuthenticated: (state) => 
        {
            return !!state.user;
        },
        authStatus: (state) => 
        {
            return state.authStatus;
        },
        registerStatus: (state) => 
        {
            return state.registerStatus;
        },
        user: (state) =>
        {
            return state.user;
        }
    }
}