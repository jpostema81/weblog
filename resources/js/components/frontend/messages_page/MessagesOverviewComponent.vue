<template>
    <div>
        <div class="card article" v-for="(message, key) in messages" v-bind:key="message.id">
            <div class="card-content">
                <div class="media">
                    <div class="media-content has-text-centered">
                        <p class="title is-4">
                            <!-- <a href="{{ route('messages.show', ['message' => $message->id]) }}">{{ $message->title }}</a> -->
                            {{ message.title }}
                        </p>
                        <div class="tags has-addons level-item">
                            <span class="tag is-rounded is-info">@ {{ message.user.name }}</span>

                            <!-- @if (count($message->categories) > 0)
                                <span class="tag is-black">
                                    @foreach ($message->categories as $category)
                                        {{ $loop->last ? $category->name : $category->name . ', ' }}
                                    @endforeach
                                </span>
                            @endif -->

                            <!-- <span class="tag is-rounded">{{ Carbon\Carbon::parse($message->created_at)->format('d-m-Y H:i') }}</span> -->
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
