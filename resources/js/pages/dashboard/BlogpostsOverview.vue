<template>
    <div>
        <b-form-input :value="keyword" size="sm" class="mr-sm-2 mt-sm-2" placeholder="Search" @input="updateKeyword"></b-form-input>

        <b-container class="mt-2">
            <b-row>
                <b-col class="pl-0">
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
                    ></b-pagination>
                </b-col>
                <b-col class="text-right"><b-button variant="primary" to="/dashboard/blogposts/create">Write new message</b-button></b-col>
            </b-row>
        </b-container>

        <b-table striped hover :items="messages" :fields="fields">
            <template v-slot:cell(actions)="row">
                <b-button size="sm" @click="editMessage(row.item, row.index, $event.target)" class="mr-1">
                    Edit
                </b-button>

                <b-button size="sm" @click="deleteMessage(row.item, row.index, $event.target)" class="mr-1">
                    Delete
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
    import { mapState, mapGetters } from 'vuex';

    export default 
    {
        data() {
            return {
                currentPage: 1,
                perPage: 10,
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
            this.$store.dispatch('DashboardMessageStore/fetchMessages');
        },
        methods: {        
            updateKeyword: function(keyword) {
                this.$store.commit('DashboardMessageStore/setKeyword', keyword);
                this.$store.dispatch('DashboardMessageStore/fetchMessages');
            },
            filterMessages(event) {
                console.log(event.target.value);
            },
            editMessage(item, index, target) {
                this.$router.push(`/dashboard/blogposts/${item.id}/edit`);
            },
            deleteMessage(item, index, target) {
                this.$store.dispatch('DashboardMessageStore/deleteMessage', item).then(() => {
                    // this.$store.dispatch('DashboardMessageStore/fetchMessages');
                    // this.currentPage = 1;
                });
            },
            loadPage(pageNumber)
            {
                this.$store.dispatch('DashboardMessageStore/fetchMessages', pageNumber);
            },
        },
        computed: {
            ...mapState('DashboardMessageStore', {
                keyword: state => state.filter.keyWord,
            }),
            ...mapGetters({
                messages: 'DashboardMessageStore/messages',
                meta: 'DashboardMessageStore/meta',
                user: 'AuthenticationStore/user',
            }),
        }
    }
</script>