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
    import CategoryFilter from '../components/frontend/home_page/CategoryFilter';
    import MessagesList from '../components/frontend/home_page/MessagesList';
    import Pager from '../components/frontend/home_page/Pager';


    export default 
    {
        components: {
            CategoryFilter,
            MessagesList,
            Pager,
        },
    }
</script>