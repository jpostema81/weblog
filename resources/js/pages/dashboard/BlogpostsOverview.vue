<style>

</style>

<template>
    <div>
        <b-form-input :value="keyword" size="sm" class="mr-sm-2 mt-sm-2" placeholder="Search" @input="updateKeyword"></b-form-input>

        <pager class="mt-2"></pager>

        <b-table striped hover :items="messages" :fields="fields">
            <template v-slot:cell(actions)="row">
                <b-button size="sm" @click="editMessage(row.item, row.index, $event.target)" class="mr-1">
                    Edit
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
    import Pager from '../../components/frontend/home_page/Pager';
    import { mapState, mapGetters } from 'vuex';


    export default 
    {
        components: 
        {
            Pager,
        },
        data() {
            return {
                fields: [
                    { 
                        key: 'title',
                        sortable: true,
                        label: 'Title',
                    }, 
                    { 
                        key: 'author.full_name',
                        sortable: true,
                        label: 'Author',
                    },
                    { 
                        key: 'categories',
                        sortable: true,
                        label: 'Categories',
                        formatter: (value) => {
                            return value.map(a => a.name).join(', ');
                        },
                    },
                    {   
                        key: 'created_at',
                        sortable: true,
                        label: 'Creation date',
                        formatter: (value) => {
                            return moment(value).format('YYYY-MM-DD')
                        },
                    },
                    { 
                        key: 'actions', 
                        label: 'Actions', 
                    }
                ],
            }
        },
        mounted() {
            // pre-fetch categories from store
            this.$store.commit('MessageStore/setUserId', this.user.id);
            this.$store.dispatch('MessageStore/fetchMessages');
        },
        methods: {        
            updateKeyword: function(keyword) {
                this.$store.commit('MessageStore/setKeyword', keyword);
                this.$store.dispatch('MessageStore/fetchMessages');
            },
            filterMessages(event) {
                console.log(event.target.value);
            },
            editMessage(item, index, target) {
                this.$router.push(`/dashboard/blogposts/${item.id}/edit`);
            }
        },
        computed: {
            ...mapState('MessageStore', {
                keyword: state => state.filter.keyWord,
            }),
            ...mapGetters({
                messages: 'MessageStore/messages',
                user: 'AuthenticationStore/user',
            }),
        }
    }
</script>