<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<template>
    <div class="field">
        <multiselect :value="selectedCategories" :options="categories" @input="updateSelectedCategories" placeholder="Filter posts by category" label="name" 
            track-by="id" :multiple="true" :taggable="false"></multiselect>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            Multiselect
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
            setSelectedCategories: function(selectedCategories) {
                this.$store.commit('MessageStore/setSelectedCategories', selectedCategories);
                this.$store.dispatch('MessageStore/fetchMessages');
            }
        },
        computed: {
            ...mapState('MessageStore', {
                selectedCategories: state => state.selectedCategories,
            }),
            ...mapState('CategoryStore', {
                categories: state => state.categories,
            })
        },
    }
</script>
