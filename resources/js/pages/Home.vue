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
    }
</script>