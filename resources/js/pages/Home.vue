<style>

</style>

<template>
    <div>
        <category-filter></category-filter>

        <b-form-input size="sm" class="mr-sm-2 mt-sm-2" placeholder="Search" @input="updateKeyword"></b-form-input>

        <pager class="mt-2"></pager>

        <messages-list></messages-list>
    </div>
</template>

<script>
    import CategoryFilter from '../components/frontend/home_page/CategoryFilter';
    import MessagesList from '../components/frontend/home_page/MessagesList';
    import Pager from '../components/frontend/home_page/Pager';


    export default 
    {
        components: 
        {
            CategoryFilter,
            MessagesList,
            Pager,
        },
        methods: {
            updateKeyword: function(keyword) {
                this.$store.commit('MessageStore/setKeyword', keyword);
                this.$store.dispatch('MessageStore/fetchAllMessages');
            },
        },
    }
</script>