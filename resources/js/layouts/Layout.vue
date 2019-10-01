<style>

</style>

<template>
    <div id="app-layout">
      <navigation-component></navigation-component>

      <div v-if="alert.message" :class="`alert ${ alert.type }`">{{ alert.message }}</div>

      <router-view></router-view>
    </div>
</template>

<script>
    import NavigationComponent from '../components/NavigationComponent.vue';
    import { mapState, mapActions } from 'vuex';

    export default 
    {
        components: {
            NavigationComponent
        },
        computed: {
        ...mapState('AlertStore', {
                alert: state => state
            })
        },
        methods: {
            ...mapActions('AlertStore', {
                clearAlert: 'ALERT_CLEAR' 
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