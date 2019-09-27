<template>
    <div>
        <b-modal id="loginModal" title="Log in">
            <form class="login" @submit.prevent="login">
                <p>
                    <label>Email address</label>
                    <input required v-model="email" type="text" placeholder="(Your email address)"/>
                </p>

                <p>
                    <label>Password</label>
                    <input required v-model="password" type="password" placeholder="(Your password)"/>
                </p>

                <hr/>

                <button type="submit">Login</button>
            </form>
        </b-modal>
    </div>
</template>

<script>
    export default 
    {
        data() {
            return {
                email: '',
                password: ''
            }
        },
        mounted()
        {
            // if there is an old token from a previous login, restore it (set axios default headers with token)
            // so API calls are authenticated again
            const token = localStorage.getItem('user-token');

            if(token) 
            {
                // first validate if local token is still valid
                this.$store.dispatch('AuthenticationStore/AUTH_CHECK_TOKEN_VALID').then(function(data) 
                {
                    if(data.status === '1') 
                    {
                        this.$store.commit('AuthenticationStore/SET_USER', data.user);
                        axios.defaults.headers.common['Authorization'] = token;
                    }
                    else 
                    {
                        // token is invalid, delete token from store
                        this.$store.dispatch('AuthenticationStore/AUTH_LOGOUT');
                    }
                });
            }
        },
        methods: 
        {
            login() 
            {
                const { email, password } = this;

                this.$store.dispatch('AuthenticationStore/AUTH_REQUEST', { email, password }).then(() => 
                {
                    this.$router.push('/home');
                });
            },
            logout() 
            {
                // evt. ook DELETE request toevoegen om user token session te deleten bij uitloggen
                this.$store.dispatch('AuthenticationStore/AUTH_LOGOUT')
                    .then(() => 
                        {
                            this.$router.push('/home');
                        });
            }
        }
    }
</script>