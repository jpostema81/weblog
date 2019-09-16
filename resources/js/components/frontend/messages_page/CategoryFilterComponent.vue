<template>
    <div class="field">
        <span v-for="(category, key) in categories" v-bind:key="category.id">
            <input class="is-checkradio" :id="'category_'+key" type="checkbox" name="categoryFilter[]" checked="checked" :value="category.id"
                @change="filterMessages" v-model="checkedCategories">
            <label :for="'category_'+key">{{ category.name }}</label>
        </span>

        <a class="button" @click="toggleSelectAllCategories">{{ selectAllCategories ? 'Clear' : 'Select all' }}</a>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data () {
            return {
                checkedCategories: [],
                selectAllCategories: false
            }
        },
        mounted() {
            // pre-fetch categories from store
            this.$store.dispatch('CategoryStore/fetchCategories').then(response => {
                // after all categories are fetched, check all category checkboxes (default to: show all messages for all categories)
            }, error => {
                console.error("Vue(X) error: Got nothing from server")
            });
        },
        methods: {
            filterMessages() {
                // update filter in store
                this.$store.commit('CategoryStore/setSelectedCategories', this.checkedCategories);
                // update messages
                this.$store.dispatch('MessageStore/fetchMessages');
            },
            toggleSelectAllCategories() {
                this.selectAllCategories = !this.selectAllCategories;

                if(this.selectAllCategories) {
                    this.checkedCategories = this.categories.map(value => value.id);
                } else {
                    this.checkedCategories = [];  
                }

                this.filterMessages();
            }
            // ...mapActions({
            //     filterMessages: 'fetchMessages' // map `this.add()` to `this.$store.dispatch('increment')`
            // })
        },
        computed: {
            // mix the getters into computed with object spread operator
            ...mapGetters({
                categories: 'CategoryStore/categories'    // map `this.categories` to `this.$store.getters.categories`
            })
        }
    }
</script>
