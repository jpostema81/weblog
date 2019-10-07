<style>

</style>

<template>
    <div>
        <category-filter></category-filter>

        <pager class="mt-2"></pager>

        <messages-list></messages-list>
    </div>
</template>

<script>
    import CategoryFilter from '../components/frontend/messages_page/CategoryFilter';
    import MessagesList from '../components/frontend/messages_page/MessagesList';
    import Pager from '../components/frontend/messages_page/Pager';


    export default 
    {
        components: {
            CategoryFilter,
            MessagesList,
            Pager,
        },
        created() {
            // if there is an old token from a previous login, restore it (set axios default headers with token)
            // so API calls are authenticated again
            const token = localStorage.getItem('user-token');

            if(token)
            {
                // first validate if local token is still valid
                this.$store.dispatch('AuthenticationStore/AUTHENTICATE_BY_TOKEN').then(data =>
                {
                    if(data.status === '1') 
                    {
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