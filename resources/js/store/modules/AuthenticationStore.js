import { AUTH_REQUEST, AUTH_SUCCESS, AUTH_ERROR, AUTH_LOGOUT } from '../mutation_types';

export const AuthenticationStore = 
{
    namespaced: true,
    state: 
    {
        token: localStorage.getItem('user-token') || '',
        status: ''
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
        // [AUTH_LOGOUT]: (state) => 
        // {
        //     state.status = '';
        //     state.token = '';
        // }
    },
    actions: 
    {
        [AUTH_REQUEST]: ({commit, dispatch}, user) => 
        {
            // The Promise used for router redirect in login
            return new Promise((resolve, reject) => 
            { 
                commit(AUTH_REQUEST);
                // Good practice: pass the login credentials in the request body, not in the URL. 
                // The reason behind it is that servers might log URLs, so you don’t have to worry 
                // about credential leaks through logs.
                axios({ url: 'login', data: user, method: 'POST' })
                    .then(resp => 
                        {
                            const token = resp.data.token;
                            // store the token in localstorage
                            localStorage.setItem('user-token', token);  
                            // set authorization token in default headers
                            axios.defaults.headers.common['Authorization'] = token;
                            commit(AUTH_SUCCESS, token);
                            // token received, log in user
                            //dispatch(USER_REQUEST); ???
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
            !!state.token;
        },
        authStatus: (state) => 
        {
            state.status;
        }
    }
}