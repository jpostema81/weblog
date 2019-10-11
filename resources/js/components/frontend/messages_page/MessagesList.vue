<template>
    <div>
        <div class="card article" v-for="(message, messageKey) in messages" v-bind:key="message.id">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-center">
                        <p class="card-title title is-4">
                            <a v-bind:href="'/messages/' + message.id">{{ message.title }}</a>
                        </p>
<<<<<<< HEAD
                        <div class="tags has-addons level-item">
                            <span class="tag is-rounded is-info">@ {{ message.user.first_name }} {{ message.user.last_name }}</span>
=======
                        
                        <div>
                            <!-- <span class="badge badge-pill badge-default">@ {{ message.user }}</span> -->
>>>>>>> 66253cbcfc1c83845c37d83445d3100285946d0c

                            <span v-for="(category, categoryKey) in message.categories" v-bind:key="category.id" class="tag is-black">
                                {{ category.name }}<span v-if="categoryKey != message.categories.length - 1">,</span>
                            </span>

                            <span class="tag is-rounded">{{ moment(message.created_at) }}</span>
                        </div>
                        
                    </div>
                </div>
                <div class="card-text">
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
            this.$store.dispatch('MessageStore/fetchMessages');
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
            // mix the getters into computed with object spread operator
            ...mapGetters({
                messages: 'MessageStore/messages'
            })
        }
    }
</script>
