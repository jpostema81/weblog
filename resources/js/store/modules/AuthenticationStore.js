import { AUTH_REQUEST, AUTH_SUCCESS, AUTH_ERROR, LOGOUT, SET_USER, AUTHENTICATE_BY_TOKEN,
     AUTHENTICATE_BY_USER_CREDENTIALS, REGISTER, REGISTER_REQUEST, REGISTER_SUCCESS, REGISTER_FAILURE,
     ALERT_ERROR, ALERT_CLEAR, ALERT_SUCCESS } from '../mutation_types';

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
        // authentication state
        [AUTH_REQUEST]: (state) => 
        {
            state.authStatus = 'loading';
        },
        [AUTH_SUCCESS]: (state, token) => 
        {
            state.authStatus = 'success';
            state.token = token;
        },
        [AUTH_ERROR]: (state) => 
        {
            state.authStatus = 'error';
        },

        [LOGOUT]: (state) => 
        {
            state.authStatus = '';
            state.token = '';
            state.user = '';
        },
        [SET_USER]: (state, user) => 
        {
            state.user = user;
        },

        // registration state
        [REGISTER_REQUEST]: (state, user)  =>
        {
            state.registerStatus = 'registering';
        },
        [REGISTER_SUCCESS]: (state, user) =>
        {
            state.registerStatus = 'success';
        },
        [REGISTER_FAILURE]: (state, error) => 
        {
            state.registerStatus = 'error';
        }
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
                    const user = resp.data.user;
                    commit(AUTH_SUCCESS, state.token);
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
        [REGISTER]: ({commit, dispatch, context}, user) => 
        {
            commit(REGISTER_REQUEST, user);

            return new Promise((resolve, reject) => 
            { 
                axios({ url: '/api/register', data: user, method: 'POST' }).then(resp => 
                {
                    commit(REGISTER_SUCCESS, user);
                    router.push('/login');

                    // setTimeout(() => {
                    //     // display success message after route change completes
                    //     dispatch('alert/success', 'Registration successful');
                    // })

                    resolve(resp);
                })
                .catch(err => 
                {
                    const errors = Object.values(JSON.parse(err.response.data)).join(' ');

                    commit(REGISTER_FAILURE, err);
                    dispatch('AlertStore/' + ALERT_ERROR, errors, { root: true });
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