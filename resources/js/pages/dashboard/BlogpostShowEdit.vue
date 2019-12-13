<style>

</style>

<template>
    <div v-if="this.message">
        <h3 class="my-4">{{ title }}</h3>

        <form @submit.prevent="handleSubmit">
            <category-filter v-model="message.categories" placeholder="add categories"></category-filter>

            <div class="form-group my-2">
                <input type="text" v-model="message.title" placeholder="Enter a title" required name="first_name" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('title') }" />
                <div v-if="submitted && errors.hasOwnProperty('title')" class="invalid-feedback">{{ errors.title.join(' ') }}</div>
            </div>

            <b-form-textarea
                id="textarea"
                v-model="message.content"
                placeholder="Write your message here..."
                rows="3"
                max-rows="6"
            ></b-form-textarea>

            <div class="form-group mt-3">
                <b-button type="submit" variant="primary" :disabled="status.updating">{{ submitButtonText }}</b-button>
                <img v-show="status === 'updating'" src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
            </div>
        </form>
    </div>
</template>

<script>
    import { mapState, mapGetters } from 'vuex';
    import CategoryFilter from '../../components/CategoryFilter';

    export default 
    {
        data() {
            return {
                blogPostId: this.$route.params.blogPostId,
                submitted: false,
                message: null,
            }
        },
        components: 
        {
            CategoryFilter,
        },
        created() {
            if(!!this.blogPostId)
            {
                this.$store.dispatch('MessageStore/fetchMessageById', this.blogPostId).then(() => {
                    this.message = {...this.$store.getters['MessageStore/message']};
                });
            }
        },
        methods: {        
            // updateKeyword: function(keyword) {
            //     this.$store.commit('MessageStore/setKeyword', keyword);
            //     this.$store.dispatch('MessageStore/fetchMessages');
            // },
            handleSubmit(e) 
            {
                this.submitted = true;
                //this.register(this.user);
            },
            updateSelectedCategories: function(selectedCategory) {
                //this.$store.commit('MessageStore/setSelectedCategories', selectedCategory);
                //this.$store.dispatch('MessageStore/fetchMessages');
            }
        },
        computed: {
            title() {
                return !!this.blogPostId ? 'Edit message' : 'Write a new message';
            },
            ...mapState('MessageStore', {
                status: state => state.status,
                errors: state => state.errors,
            }),
            submitButtonText() {
                return (!!this.blogPostId) ? 'Update' : 'Save';
            },
            // ...mapGetters({
            //     messages: 'MessageStore/messages',
            //     user: 'AuthenticationStore/user',
            // }),
        }
    }
</script>