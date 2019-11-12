<template>
    <div class="container-fluid">
        <sidebar-menu :menu="menu" />

        <navigation-component></navigation-component>

        <router-view></router-view>

        <footer-component></footer-component>
    </div>
</template>

<script>
    import NavigationComponent from '../components/NavigationComponent';
    import FooterComponent from '../layouts/Footer';
    import { SidebarMenu } from 'vue-sidebar-menu';

    export default 
    {
        data() {
            return {
                menu: [
                    {
                        header: true,
                        title: 'Main Navigation',
                        hiddenOnCollapse: true
                    },
                    {
                        href: '/dashboard',
                        title: 'Dashboard',
                        icon: 'fa fa-user'
                    },
                    {
                        href: '/dashboard/blogposts',
                        title: 'BlogPosts',
                        icon: 'fa fa-chart-area',
                        child: [
                            {
                                href: '/charts/sublink',
                                title: 'Sub Link'
                            }
                        ]
                    }
                ]
            }
        },
        components: 
        {
            NavigationComponent,
            FooterComponent,
            SidebarMenu,
        },
    }
</script>