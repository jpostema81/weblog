<template>
    <div>
        <div class="flex mt-3">
            <h2 class="mx-1">BlogPosts</h2>
            <b-button class="mx-1 h-75" variant="outline-primary" to="/dashboard/blogposts/create">Write new message</b-button>
        </div>

        <b-form inline>
            <b-form-input :value="keyword" size="sm" placeholder="Search" @input="updateKeyword"></b-form-input>

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
                class="mt-3 mx-1"
            ></b-pagination>
            <b-form-select class="mx-1" v-model="bulkAction.selected" :options="bulkAction.options"></b-form-select>
            <b-button class="mx-1" variant="outline-primary" type="button" @click="applyBulkAction">Apply</b-button>
        </b-form>

        <b-table striped hover :items="messages" :fields="fields">
            <template v-slot:head(select)="data">
                <b-form-checkbox
                    id="checkboxSelectAll"
                    v-model="selectAll"
                    name="checkboxSelectAll"
                    @change="toggleSelectAll"
                ></b-form-checkbox>
            </template>

            <template v-slot:cell(select)="row">
                <b-form-checkbox
                    :id="'checkbox-'+row.item.id"
                    v-model="selectedItems[row.item.id]"
                    :name="'checkbox-'+row.item.id"
                    @change="selectAll=false"
                ></b-form-checkbox>
            </template>

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
                selectedItems: {},
                selectAll: false,
                fields: [
                    { 
                        key: 'select', 
                        label: '', 
                    },
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
                bulkAction: {
                    selected: null,
                    options: [
                        { value: null, text: 'Bulk Actions' },
                        { value: 'delete', text: 'Move to Trash Bin' },
                        { value: 'edit', text: 'Edit', disabled: true },
                    ]
                }
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
                this.$store.dispatch('DashboardMessageStore/deleteMessage', item.id).then(() => {
                    this.$store.dispatch('DashboardMessageStore/fetchMessages');
                    this.currentPage = 1;
                });
            },
            loadPage(pageNumber)
            {
                this.$store.dispatch('DashboardMessageStore/fetchMessages', pageNumber);
                this.selectAll = false;

                this.messages.forEach(element => {
                    this.selectedItems = {};
                });
            },
            toggleSelectAll()
            {
                this.selectAll = !this.selectAll;

                this.messages.forEach(element => {
                    this.selectedItems[element.id] = this.selectAll;
                });
            },
            toggleBusy() 
            {
                this.isBusy = !this.isBusy;
            },
            applyBulkAction() 
            {
                switch(this.bulkAction.selected)
                {
                    case 'delete':
                    {
                        Object.filter = (obj, predicate) => Object.fromEntries(Object.entries(obj).filter(predicate));
                        let filteredMessages = Object.keys(Object.filter(this.selectedItems, ([id, selected]) => selected === true)); 

                        this.$store.dispatch('DashboardMessageStore/deleteMessages', filteredMessages).then(() => {
                            this.$store.dispatch('DashboardMessageStore/fetchMessages');
                            this.currentPage = 1;
                            this.selectedItems = {};
                        });
                        
                    }
                    case 'edit':
                    {

                        
                    }
                }
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