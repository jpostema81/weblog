<template>
    <div>
        <b-button v-b-modal.modal-1>Login / Logout</b-button>

        <b-modal id="modal-1" title="Log in">
            <form class="login" @submit.prevent="login">
                <!-- <h1>Sign in</h1> -->

                <label>User name</label>
                <input required v-model="username" type="text" placeholder="(Your username)"/>

                <label>Password</label>
                <input required v-model="password" type="password" placeholder="(Your password)"/>

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
                username: '',
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
                axios.defaults.headers.common['Authorization'] = token;
            }
        },
        methods: 
        {
            login: function() 
            {
                const { username, password } = this;

                this.$store.dispatch(AUTH_REQUEST, { username, password }).then(() => 
                {
                    this.$router.push('/home');
                });
            },
            logout: function() 
            {
                // evt. ook DELETE request toevoegen om user token session te deleten bij uitloggen
                this.$store.dispatch(AUTH_LOGOUT)
                    .then(() => 
                        {
                            this.$router.push('/home');
                        });
            }
        }
    }
</script>