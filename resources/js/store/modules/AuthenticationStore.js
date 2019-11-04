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
        LOGIN_REQUEST: (state) => 
        {
            state.status = 'loading';
            state.errors = {};
        },
        LOGIN_SUCCESS: (state, user) => 
        {
            state.status = 'success';
            state.errors = {};
            state.user = user;
        },
        LOGIN_ERROR: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        },

        LOGOUT: (state) => 
        {
            state.status = '';
            state.user = '';
        },
        SET_USER: (state, user) => 
        {
            state.user = user;
        },

        // registration state
        REGISTER_REQUEST: (state)  =>
        {
            state.status = 'registering';
            state.errors = {};
        },
        REGISTER_SUCCESS: (state) =>
        {
            state.status = 'success';
            state.errors = {};
        },
        REGISTER_ERROR: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        },

        // user update state
        USER_UPDATE_REQUEST: (state)  =>
        {
            state.status = 'updating';
            state.errors = {};
        },
        USER_UPDATE_SUCCESS: (state, user) =>
        {
            state.status = 'success';
            state.errors = {};
            state.user = user;
        },
        USER_UPDATE_ERROR: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        }
    },
    actions: 
    {
        // authenticate by JWT token (token from login or local storage)
        authenticateByToken: ({commit, state, dispatch}) => 
        {
            return new Promise((resolve, reject) => 
            {
                axios({ url: '/api/get_user_by_token', method: 'POST' }).then(resp => 
                {
                    const user = resp.data;
                    commit('LOGIN_SUCCESS', user);
                    resolve(resp);
                })
                .catch(err => 
                {
                    commit('LOGIN_ERROR', err);
                    dispatch('logout');
                    reject(err);
                });
            });
        },
        // authenticate by user login (email & password)
        login: ({commit, dispatch}, user) => 
        {
            return new Promise((resolve, reject) => 
            { 
                commit('LOGIN_REQUEST');

                axios({ url: '/api/login', data: user, method: 'POST' }).then(resp => 
                {
                    const token = resp.data.access_token;
                    const user = resp.data.user;

                    // store the token in localstorage
                    localStorage.setItem('user-token', token);
                    // token received, set user
                    commit('LOGIN_SUCCESS', user);

                    resolve(resp);
                })
                .catch(error => 
                {
                    dispatch('AlertStore/alertError', error.response.data.error, { root: true });
                    commit('LOGIN_ERROR', error.response.data);
                    
                    // if the request fails, remove any possible user token if possible
                    localStorage.removeItem('user-token');
                    reject(error);
                });
            });
        },
        // logout a user
        logout: ({commit, dispatch}) => 
        {
            return new Promise((resolve, reject) => 
            {
                commit('LOGOUT');
                
                axios({ url: '/api/logout', method: 'POST' }).then(resp => 
                {
                    // clear your user's token from localstorage
                    localStorage.removeItem('user-token');
                    dispatch('AlertStore/alertSucces', 'You are logged out now!', { root: true });
                    resolve(resp);
                })
                .catch(error => 
                {
                    dispatch('AlertStore/alertError', 'Something went wrong during logging out', { root: true });
                    // clear your user's token from localstorage
                    localStorage.removeItem('user-token');
                    //commit(LOGOUT_ERROR, error.response.data);
                    reject(error);
                });

                
            });
        },
        // register a new user
        register: function({commit, dispatch, context}, user) {
            commit('REGISTER_REQUEST');

            return new Promise((resolve, reject) => { 
                axios({ url: '/api/register', data: user, method: 'POST' }).then(resp => 
                {
                    commit('REGISTER_SUCCESS');
                    router.push('/login');

                    setTimeout(() => {
                        // display success message after route change completes
                        dispatch('AlertStorealertSuccess', 'Registration successful', { root: true });
                    })

                    resolve(resp);
                })
                .catch(error => 
                {
                    dispatch('AlertStore/alertError', 'Something went wrong', { root: true });

                    if (error.response) 
                    {
                        /*
                         * The request was made and the server responded with a
                         * status code that falls out of the range of 2xx
                         */
                        console.log(error.response.data);
                        commit('REGISTER_ERROR', error.response.data);
     
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
        updateUser: function({commit, dispatch, context}, user) {
            commit('USER_UPDATE_REQUEST');

            return new Promise((resolve, reject) => { 
                axios({ url: '/api/admin/users/' + user.id, data: user, method: 'PATCH' }).then(resp => 
                {
                    commit('USER_UPDATE_SUCCESS', user);
                    
                    setTimeout(() => {
                        // display success message after route change completes
                        dispatch('AlertStore/alertSucces', 'Profile update successful', { root: true });
                    })

                    resolve(resp);
                })
                .catch(error => 
                {
                    dispatch('AlertStore/alertError', 'Something went wrong while updating your profile data', { root: true });

                    if (error.response) 
                    {
                        /*
                         * The request was made and the server responded with a
                         * status code that falls out of the range of 2xx
                         */
                        console.log(error.response.data);
                        commit('USER_UPDATE_ERROR', error.response.data.errors);
     
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