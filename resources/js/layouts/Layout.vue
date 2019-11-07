<template>
    <div id="app-layout">
        <navigation-component></navigation-component>

        <router-view></router-view>

        <footer-component></footer-component>
    </div>
</template>

<script>
    import NavigationComponent from '../components/NavigationComponent';
    import FooterComponent from '../layouts/Footer';

    export default 
    {
        components: 
        {
            NavigationComponent,
            FooterComponent,
        },
    }
</script>