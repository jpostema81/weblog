<style>

</style>

<template>
    <div id="app-layout">
      <navigation-component></navigation-component>

      <router-view></router-view>
    </div>
</template>

<script>
    import NavigationComponent from '../components/NavigationComponent.vue';

    export default 
    {
        components: {
            NavigationComponent
        },
        created() {
            // dispatch data from store
        }
    }
</script>