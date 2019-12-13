<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<template>
    <div class="field">
        <multiselect v-bind:value="value" :options="categories" 
        @input="updateSelectedCategories"
        :placeholder="placeholder" 
        label="name" track-by="id" :multiple="true" :taggable="false"></multiselect>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import Multiselect from 'vue-multiselect';

    export default {
        props: ['value', 'placeholder'],
        components: {
            Multiselect
        },
        mounted() {
            this.$store.dispatch('CategoryStore/fetchCategories').then(response => {}, error => {
                console.error("Vue(X) error: Got nothing from server")
            });
        },
        methods: {
            updateSelectedCategories: function(val) {
                this.$emit('input', val);
            }
        },
        computed: {
            ...mapState('CategoryStore', {
                categories: state => state.categories,
            }),
        },
    }
</script>
