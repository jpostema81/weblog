<template>
    <div>
        <div class="field">
            <span v-for="(category, index) in categories">
                <input class="is-checkradio" id="exampleCheckboxDefault" type="checkbox" name="categoryFilter[]" checked="checked">
                <label for="exampleCheckboxDefault">{{ category }}</label>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                categories: []
            }
        },
        mounted() {
            // pre-fetch categories from store
            if (this.categories.length == 0) {
                this.fetchCategories();
            }
        },
        methods: {
            fetchCategories() {
                return this.$store.dispatch('fetchCategories');
            }
        }
    }
</script>
