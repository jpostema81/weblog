<style>

</style>

<template>
    <div>
       
    </div>
</template>

<script>
    import { mapState, mapGetters } from 'vuex';


    export default 
    {
        components: 
        {

        },
        data() {
            return {
                blogPostID: this.$route.params.blogPostID,
            }
        },
        mounted() {
            // pre-fetch categories from store
            // this.$store.commit('MessageStore/setUserId', this.user.id);
            // this.$store.dispatch('MessageStore/fetchMessages');
        },
        methods: {        
            // updateKeyword: function(keyword) {
            //     this.$store.commit('MessageStore/setKeyword', keyword);
            //     this.$store.dispatch('MessageStore/fetchMessages');
            // },
        },
        computed: {
            // ...mapState('MessageStore', {
            //     keyword: state => state.filter.keyWord,
            // }),
            // ...mapGetters({
            //     messages: 'MessageStore/messages',
            //     user: 'AuthenticationStore/user',
            // }),
        }
    }
</script>