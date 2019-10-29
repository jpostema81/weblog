<template>
    <div>
        <div class="card article" v-for="(message, messageKey) in messages" v-bind:key="message.id">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-center">
                        <h5 class="card-title">
                            <router-link :to="{ name: 'blogpost', params: { blogPostID: message.id }}">{{ message.title }}</router-link>
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
    import { mapGetters } from 'vuex';

    export default {
        mounted() {
            // pre-fetch categories from store
            this.$store.dispatch('MessageStore/fetchAllMessages');
        },
        methods: {
            filterMessages(event) {
                console.log(event.target.value);
            },
            moment: function (date) {
                return moment(date, 'YYYY-MM-DD HH:mm:ss').fromNow();
            }
        },
        computed: {
            ...mapGetters({
                messages: 'MessageStore/messages'
            })
        }
    }
</script>
