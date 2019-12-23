<template>
    <div>
        <div class="card article mb-1" v-for="(message, messageKey) in messages" v-bind:key="message.id">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-center">
                        <h5 class="card-title">
                            <router-link :to="{ name: 'blogpostsOverview', params: { blogPostId: message.id }}">{{ message.title }}</router-link>
                            <span v-if="message.comments.length > 0" class="h6 lightgray mx-1">
                                <i class="fas fa-comment mx-1"></i>
                                <anchor-router-link :to="{ name: 'blogpostsOverview', params: { blogPostId: message.id }, hash: '#comments'}">
                                    {{ message.comments.length === 1 ? message.comments.length + ' reaction' : message.comments.length + '  reactions' }}
                                </anchor-router-link>
                            </span>
                        </h5>
                        <div class="tags has-addons level-item">
                            <span class="tag is-rounded is-info">By {{ message.author.full_name }}</span> |

                            <span v-for="(category, categoryKey) in message.categories" v-bind:key="category.id" class="tag is-black">
                                {{ category.name }}<span v-if="categoryKey != message.categories.length - 1">,</span>
                            </span> |

                            <span class="tag is-rounded">{{ moment(message.created_at) }}</span>
                        </div>
                        
                    </div>
                </div>
                <div class="card-text mt-2">
                    {{ message.content.slice(0, 240) }}...
                    <div v-if="message.image">
                        <img v-bind:src="'/storage/' + message.image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AnchorRouterLink from 'vue-anchor-router-link';

    export default {
        props: ['messages'],
        components: {
            AnchorRouterLink
        },
        methods: {
            moment(date) {
                return moment(date, 'YYYY-MM-DD HH:mm:ss').fromNow();
            },
            createCommentText(message) {
                if(message.comments === 1)
                {
                    return message.comments
                } 
                else if(message.comments > 1)
                {

                }
            },
        },
    }
</script>
