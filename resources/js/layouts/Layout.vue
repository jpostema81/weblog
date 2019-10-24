<style>

</style>

<template>
    <div id="app-layout">
        <navigation-component></navigation-component>

        <div v-if="alert.message" :class="`alert ${ alert.type } alert-dismissible fade show`">
            {{ alert.message }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <router-view></router-view>

        <footer-component></footer-component>
    </div>
</template>

<script>
    import NavigationComponent from '../components/NavigationComponent';
    import FooterComponent from '../layouts/Footer'
    import { mapState, mapActions } from 'vuex';

    export default 
    {
        components: {
            NavigationComponent,
            FooterComponent,
        },
        computed: {
        ...mapState('AlertStore', {
                alert: state => state
            })
        },
        methods: {
            ...mapActions('AlertStore', {
                clearAlert: 'alertClear' 
            })
        },
        watch: {
            '$route' (to, from) {
                // clear alert on location change
                this.clearAlert();
            }
        }
    }
</script>