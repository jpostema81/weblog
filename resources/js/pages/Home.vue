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
            // dispatch data from store
        }
    }
</script>