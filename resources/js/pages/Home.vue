<style>

</style>

<template>
    <div>
        <category-filter v-model="value" placeholder="Filter posts by category"></category-filter>

        <b-form-input :value="keyword" size="sm" class="mr-sm-2 mt-sm-2" placeholder="Search" @input="updateKeyword"></b-form-input>

        <b-pagination
            v-model="currentPage"
            :total-rows="meta.total"
            :per-page="meta.per_page"
            aria-controls="my-table"
            first-text="First"
            prev-text="Prev"
            next-text="Next"
            last-text="Last"
            @change="loadPage"
            class="mt-2"
        ></b-pagination>

        <messages-list :messages="messages"></messages-list>
    </div>
</template>

<script>
    import CategoryFilter from '../components/CategoryFilter';
    import MessagesList from '../components/frontend/home_page/MessagesList';
    import { mapState, mapGetters } from 'vuex';


    export default 
    {
        data() {
            return {
                value: null,
                currentPage: 1,
                perPage: 10,
            }
        },
        mounted() {
            this.$store.dispatch('MessageStore/fetchMessages');
        },
        components: 
        {
            CategoryFilter,
            MessagesList,
        },
        methods: {        
            updateKeyword: function(keyword) 
            {
                this.$store.commit('MessageStore/setKeyword', keyword);
                this.$store.dispatch('MessageStore/fetchMessages');
            },
            loadPage(pageNumber)
            {
                this.$store.dispatch('MessageStore/fetchMessages', pageNumber);
            },
        },
        computed: {
            ...mapState('MessageStore', {
                keyword: state => state.filter.keyWord,
            }),
            ...mapGetters({
                messages: 'MessageStore/messages',
                meta: 'MessageStore/meta'
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