<style>

</style>

<template>
    <div class="blogpost-comments-tree card-text mt-2" :style="indent">

        <p>
            <span v-if="content">
                <strong v-if="author">{{ author.full_name }}</strong>
                <small>{{ moment(date) }}</small>
                <br>
                {{ content }}
                <br>
            </span>

            <b-link @click="toggleDisplayReplyInput">Reply</b-link>
        
            <b-alert v-model="enableReply" variant="info" dismissible>
                Please login or register first in order to leave a comment
            </b-alert>

            <b-form-textarea
                v-if="enableReply"
                id="textarea"
                v-model="reply"
                placeholder="Please put your comment here..."
                rows="3"
                max-rows="6"
            ></b-form-textarea>

            <b-button v-if="enableReply" variant="outline-primary" size="sm" class="mt-2" @click="submitReply">Submit reply</b-button>
        </p>

        <comment-component v-for="comment in comments" :depth="depth + 1" :comments="comment.comments" 
            :author="comment.author" :date="comment.created_at" :content="comment.content" 
            v-bind:key="comment.id" :enableReply="enableReply">
            
        </comment-component>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import CommentComponent from './CommentComponent';

    export default 
    {
        data() {
            return {
                displayReplyInput: false,
                reply: '',
            }
        },
        props: [ 'comments', 'content', 'author', 'date', 'depth', 'enableReply' ],
        name: 'comment-component',
        components: 
        {
            CommentComponent,
        },
        computed: 
        {
            indent() 
            {
                return { 'margin-left': `${this.depth * 20}px` }
            },
            ...mapGetters({
                isAuthenticated: 'AuthenticationStore/isAuthenticated'
            }),    
        },
        methods: {
            moment(date) 
            {
                return moment(date, 'YYYY-MM-DD HH:mm:ss').fromNow();
            },
            toggleDisplayReplyInput() 
            {
                this.displayReplyInput = !this.displayReplyInput;
            },
            submitReply(e)
            {
                // this.$store.dispatch('MessageStore/addComment', this.reply).then(() => 
                // {
                //     //this.$router.push('/home');
                // });
            },
        },
    }
</script>