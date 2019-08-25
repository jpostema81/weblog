<template>
    <div class="field">
        <span v-for="(category, key) in categories" v-bind:key="category.id">
            <input class="is-checkradio" :id="'category_'+key" type="checkbox" name="categoryFilter[]" checked="checked" :value="category.id" @change="filterMessages">
            <label :for="'category_'+key">{{ category.name }}</label>
        </span>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        mounted() {
            // pre-fetch categories from store
            this.$store.dispatch('fetchCategories');
        },
        methods: {
            filterMessages(event) {
                console.log(event.target.value);
            }
        },
        computed: {
            // mix the getters into computed with object spread operator
            ...mapGetters([
                'categories'
            ])
        }
    }
</script>
