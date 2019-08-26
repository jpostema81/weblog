<template>
    <div class="field">
        <span v-for="(category, key) in categories" v-bind:key="category.id">
            <input class="is-checkradio" :id="'category_'+key" type="checkbox" name="categoryFilter[]" checked="checked" :value="category.id"
                @change="filterMessages" v-model="checkedCategories">
            <label :for="'category_'+key">{{ category.name }}</label>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data () {
            return {
                checkedCategories: [] 
            }
        },
        mounted() {
            // pre-fetch categories from store
            this.$store.dispatch('fetchCategories').then(response => {
                // after all categories are fetched, check all category checkboxes (default to: show all messages for all categories)
                this.checkedCategories = this.categories.map(value => value.id);
            }, error => {
                console.error("Vue(X) error: Got nothing from server")
            });
        },
        methods: {
            filterMessages(event) {
                console.log(event.target.value);
                // update filter in store
                this.$store.commit('setSelectedCategories', this.checkedCategories);
                // update messages
                this.$store.dispatch('fetchMessages');
            },
            // ...mapActions({
            //     filterMessages: 'fetchMessages' // map `this.add()` to `this.$store.dispatch('increment')`
            // })
        },
        computed: {
            // mix the getters into computed with object spread operator
            ...mapGetters([
                'categories'    // map `this.categories` to `this.$store.getters.categories`
            ])
        }
    }
</script>
