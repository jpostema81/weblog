<style>
    #container-layout {
        padding-left: 350px;
    }
    
    #container-layout.collapsed {
        padding-left: 50px;
    }
</style>

<template>
    <div id="container-layout" :class="[{'collapsed' : collapsed}]">
        <navigation-component></navigation-component>

        <div class="px-2">
            <router-view />
        </div>

        <sidebar-menu
            :menu="menu"
            :collapsed="collapsed"
            :show-one-child="true"
            @toggle-collapse="onToggleCollapse"
        />

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
                collapsed: false,
                menu: [
                    {
                        header: true,
                        title: 'Dashboard Navigation',
                        hiddenOnCollapse: true
                    },
                    {
                        href: '/',
                        title: 'View Weblog',
                        icon: 'fa fa-user'
                    },
                    {
                        href: '/dashboard',
                        title: 'Dashboard',
                        icon: 'fa fa-user'
                    },
                    {
                        href: '/dashboard/blogposts',
                        title: 'My BlogPosts',
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
        methods: {
            onToggleCollapse(collapsed) {
                this.collapsed = collapsed
            },
        },
    }
</script>