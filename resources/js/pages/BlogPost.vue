<style>

</style>

<template>
    <div>
        <div class="card article" v-if="message">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-center">
                        <h5 class="card-title">
                            {{ message.title }}
                        </h5>
                        <div class="tags has-addons level-item">
                            <span class="tag is-rounded is-info">@ {{ message.author.full_name }}</span> |

                            <span v-for="(category, categoryKey) in message.categories" v-bind:key="category.id" class="tag is-black">
                                {{ category.name }}<span v-if="categoryKey != message.categories.length - 1">,</span>
                            </span> |

                            <span class="tag is-rounded">{{ moment(message.created_at) }}</span>
                        </div>
                        
                    </div>
                </div>
                <div class="card-text mt-2">
                    {{ message.content }}
                    <div v-if="message.image">
                        <img v-bind:src="'/storage/' + message.image">
                    </div>
                </div>

                <comment-component :depth="0" :comments="message.comments" :enableReply="false"></comment-component>

                <b-button variant="primary" @click="$router.go(-1)">Back</b-button>
            </div>  
        </div>

        <!-- {!! Form::open(['method' => 'DELETE', 'route' => ['messages.destroy', $message->id] ]) !!}
            @can('Edit Post')
                <a href="{{ route('messages.edit', $message->id) }}" class="btn btn-info" role="button">Edit</a>
            @endcan
            @can('Delete Post') 
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            @endcan
        {!! Form::close() !!} -->


        

        


        <!-- @auth
        {{ Form::model($message, ['route' => ['comments.store', $message->id], 'method' => 'POST']) }}
        <article class="media">
            <figure class="media-left">
                <p class="image is-64x64">
                <img src="https://bulma.io/images/placeholders/128x128.png">
                </p>
            </figure>
            <div class="media-content">
                <div class="field">
                <p class="control">
                    {{ Form::textarea('comment', null, array('class' => 'textarea', 'rows' => '4', 'placeholder' => 'Add a comment...')) }}
                </p>
                </div>
                <div class="field">
                <p class="control">
                    {{ Form::submit("Post comment", array('class' => 'button')) }}
                </p>
                </div>
            </div>
        </article>
        {{ Form::close() }}
        @endauth -->

        

    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import CommentComponent from '../components/frontend/blogpost_page/CommentComponent';

    export default 
    {
        data() {
            return {
                blogPostID: this.$route.params.blogPostID,
            }
        },
        components: {
            CommentComponent,
        },
        mounted() {
            this.$store.dispatch('MessageStore/fetchMessageById', this.blogPostID);
        }, 
        computed: {
            ...mapGetters({
                message: 'MessageStore/message',
            }),
        },
        methods: {
            moment: function (date) {
                return moment(date, 'YYYY-MM-DD HH:mm:ss').fromNow();
            }
        },
    }
</script>