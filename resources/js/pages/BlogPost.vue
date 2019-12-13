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

                <comment-component :depth="0" :comment="message" :enableReply="isAuthenticated"></comment-component>

                <b-button variant="primary" @click="$router.go(-1)">Back</b-button>
            </div>  
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';
    import CommentComponent from '../components/frontend/blogpost_page/CommentComponent';

    export default 
    {
        data() {
            return {
                blogPostId: this.$route.params.blogPostId,
            }
        },
        components: {
            CommentComponent,
        },
        mounted() {
            this.$store.dispatch('MessageStore/fetchMessageById', this.blogPostId);
        }, 
        computed: {
            ...mapGetters({
                message: 'MessageStore/message',
                isAuthenticated: 'AuthenticationStore/isAuthenticated',
            }),
        },
        methods: {
            moment: function (date) {
                return moment(date, 'YYYY-MM-DD HH:mm:ss').fromNow();
            }
        },
    }
</script>