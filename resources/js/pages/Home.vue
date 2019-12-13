<style>

</style>

<template>
    <div>
        <category-filter v-model="value" placeholder="Filter posts by category"></category-filter>

        <b-form-input :value="keyword" size="sm" class="mr-sm-2 mt-sm-2" placeholder="Search" @input="updateKeyword"></b-form-input>

        <pager class="mt-2"></pager>

        <messages-list></messages-list>
    </div>
</template>

<script>
    import CategoryFilter from '../components/CategoryFilter';
    import MessagesList from '../components/frontend/home_page/MessagesList';
    import Pager from '../components/frontend/home_page/Pager';
    import { mapState } from 'vuex';


    export default 
    {
        data() {
            return {
                value: null,
            }
        },
        components: 
        {
            CategoryFilter,
            MessagesList,
            Pager,
        },
        methods: {        
            updateKeyword: function(keyword) {
                this.$store.commit('MessageStore/setKeyword', keyword);
                this.$store.dispatch('MessageStore/fetchMessages');
            },
        },
        computed: {
            ...mapState('MessageStore', {
                keyword: state => state.filter.keyWord,
            }),
        },
        watch: {
            value: function(val) {
                this.$store.commit('MessageStore/setSelectedCategories', val);
                this.$store.dispatch('MessageStore/fetchMessages');
            },
        }
    }
</script>