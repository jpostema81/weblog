<style>

</style>

<template>
    <div id="app-layout">
      <navigation-component />

      <div v-if="alert.message" :class="`alert ${ alert.type }`">{{ alert.message }}</div>

      <router-view />

      <footer-component />
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