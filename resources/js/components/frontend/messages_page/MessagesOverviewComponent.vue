<template>
    <div>
        <div class="card article" v-for="(message, messageKey) in messages" v-bind:key="message.id">
            <div class="card-content">
                <div class="media">
                    <div class="media-content has-text-centered">
                        <p class="title is-4">
                            <a v-bind:href="'/messages/' + message.id">{{ message.title }}</a>
                        </p>
                        <div class="tags has-addons level-item">
                            <span class="tag is-rounded is-info">@ {{ message.user.name }}</span>

                                <span v-for="(category, categoryKey) in message.categories" v-bind:key="category.id" class="tag is-black">
                                    {{ category.name }}<span v-if="categoryKey != message.categories.length - 1">,</span>
                                </span>

                            <span class="tag is-rounded">{{ moment(message.created_at) }}</span>
                        </div>
                    </div>
                </div>
                <div class="content article-body">
                    {{ message.content }}
                </div>
            </div>
        </div>
    </div>
            
    <!-- <span v-for="(category, key) in categories" v-bind:key="category.id">
        <input class="is-checkradio" :id="'category_'+key" type="checkbox" name="categoryFilter[]" checked="checked" :value="category.id" @change="filterMessages">
        <label :for="'category_'+key">{{ category.name }}</label>
    </span> -->
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        mounted() {
            // pre-fetch categories from store
            this.$store.dispatch('fetchMessages');
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
            ...mapGetters([
                'messages'
            ])
        }
    }
</script>
