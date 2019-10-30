<style>

</style>

<template>
    <div class="blogpost-comments-tree card-text mt-2" :style="indent">

        <p v-if="content">
            <strong v-if="author">{{ author.full_name }}</strong>
            <br>
            {{ content }}
            <br>
            <!-- <small><a>Reply</a> · {{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small> -->
        </p>

        <comment-component v-for="comment in comments" :depth="depth + 1" :comments="comment.comments" :author="comment.author" :content="comment.content" v-bind:key="comment.id">
            
        </comment-component>
    </div>
</template>

<script>
    import CommentComponent from './CommentComponent';

    export default 
    {
        props: [ 'comments', 'content', 'author', 'depth' ],
        name: 'comment-component',
        components: 
        {
            CommentComponent,
        },
        computed: 
        {
            indent() 
            {
                return { transform: `translate(${this.depth * 20}px)` }
            }
        }
    }
</script>