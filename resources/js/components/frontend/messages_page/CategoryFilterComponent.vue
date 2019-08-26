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
                console.log("Got some data, now lets show something in this component")
            }, error => {
                console.error("Got nothing from server. Prompt user to check internet connection and try again")
            });
        },
        methods: {
            filterMessages(event) {
                console.log(event.target.value);
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
