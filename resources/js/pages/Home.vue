<style>

</style>

<template>
    <div>
        <category-filter-component></category-filter-component>

        <messages-overview-component></messages-overview-component>
    </div>
</template>

<script>
    import CategoryFilterComponent from '../components/frontend/messages_page/CategoryFilterComponent';
    import MessagesOverviewComponent from '../components/frontend/messages_page/MessagesOverviewComponent';

    export default 
    {
        components: {
            CategoryFilterComponent,
            MessagesOverviewComponent
        },
        created() {
            // if there is an old token from a previous login, restore it (set axios default headers with token)
            // so API calls are authenticated again
            const token = localStorage.getItem('user-token');

            if(token)
            {
                // first validate if local token is still valid
                this.$store.dispatch('AuthenticationStore/USER_REQUEST').then(data =>
                {
                    if(data.status === '1') 
                    {
                        this.$store.commit('AuthenticationStore/USER_REQUEST', data.user);
                        this.$store.commit('AuthenticationStore/AUTH_SUCCESS', token);
                        axios.defaults.headers.common['Authorization'] = token;
                    }
                    else 
                    {
                        // token is invalid, delete token from store
                        this.$store.dispatch('AuthenticationStore/AUTH_LOGOUT');
                    }
                });
            }
        }
    }
</script>