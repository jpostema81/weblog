import router from '../../router/index';
import MessageBus from './../../messageBus';

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
        authRequest: (state) => 
        {
            state.status = 'loading';
            state.errors = {};
        },
        authSuccess: (state, user) => 
        {
            state.status = 'success';
            state.errors = {};
            state.user = user;
        },
        authError: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        },

        logout: (state) => 
        {
            // no server side logout to keep tokens stateless. Just remove tokens from client
            localStorage.removeItem('user-token');
            MessageBus.$emit('message', {message: 'You are logged out now!', variant: 'success'});
            
            state.status = '';
            state.user = '';

            router.push('/');
        },
        setUser: (state, user) => 
        {
            state.user = user;
        },

        // registration state
        registerRequest: (state)  =>
        {
            state.status = 'registering';
            state.errors = {};
        },
        registerSuccess: (state) =>
        {
            state.status = 'success';
            state.errors = {};
        },
        registerError: (state, errors) => 
        {
            state.status = 'error';
            state.errors = errors;
        },

        // user update state
        userUpdateRequest: (state)  =>
        {
            state.status = 'updating';
            state.errors = {};
        },
        userUpdateSuccess: (state, user) =>
        {
            state.status = 'success';
            state.errors = {};
            state.user = user;
        },
        userUpdateError: (state, errors) => 
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
            console.log('AuthenticationStore/authenticateByToken');
            
            commit('authRequest');

            return new Promise((resolve, reject) => 
            {
                axios({ url: '/api/get_user_by_token', method: 'POST' }).then(resp => 
                {
                    const user = resp.data;
                    commit('authSuccess', user);
                    resolve(resp);
                })
                .catch(err => 
                {
                    commit('authError', err);
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
                commit('authRequest');

                axios({ url: '/api/login', data: user, method: 'POST' }).then(resp => 
                {
                    const token = resp.data.access_token;
                    const user = resp.data.user;

                    // store the token in localstorage
                    localStorage.setItem('user-token', token);
                    // token received, set user
                    commit('authSuccess', user);
                    MessageBus.$emit('message', {message: 'Welcome back ' + user.full_name + ', you are logged in now' , variant: 'success'});
                    resolve(resp);
                })
                .catch(error => 
                {
                    MessageBus.$emit('message', {message: error.response.data.error, variant: 'danger'});
                    commit('authError', error.response.data.errors);
                    
                    // if the request fails, remove any possible user token if possible
                    localStorage.removeItem('user-token');
                    reject(error);
                });
            });
        },
        // register a new user
        register: function({commit, dispatch, context}, user) {
            commit('registerRequest');

            return new Promise((resolve, reject) => { 
                axios({ url: '/api/register', data: user, method: 'POST' }).then(resp => 
                {
                    commit('registerSuccess');
                    router.push('/login');

                    setTimeout(() => {
                        // display success message after route change completes
                        MessageBus.$emit('message', {message: 'Registration successful', variant: 'success'});
                    })

                    resolve(resp);
                })
                .catch(error => 
                {
                    MessageBus.$emit('message', {message: 'Something went wrong', variant: 'danger'});
                    commit('registerError', error.response.data.errors);
                    reject(error);
                });
            });
        },
        updateUser: function({commit, dispatch, context}, user) {
            commit('userUpdateRequest');

            return new Promise((resolve, reject) => { 
                axios({ url: '/api/admin/users/' + user.id, data: user, method: 'PATCH' }).then(resp => 
                {
                    commit('userUpdateSuccess', user);
                    
                    setTimeout(() => {
                        // display success message after route change completes
                        MessageBus.$emit('message', {message: 'Profile update successful', variant: 'success'});
                    });

                    resolve(resp);
                })
                .catch(error => 
                {
                    MessageBus.$emit('message', {message: 'Something went wrong while updating your profile data', variant: 'danger'});
                    commit('userUpdateError', error.response.data.errors);
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
        user: (state) =>
        {
            return state.user;
        },
        status: (state) =>
        {
            return state.status;
        }
    }
}