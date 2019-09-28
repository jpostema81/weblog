<style></style>

<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="primary" id="navigationBar">
            <b-navbar-brand href="#">{{ title }}</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav v-for="item in items" v-bind:key="item.id">
                    <b-nav-item :to="item.path">{{ item.name }}</b-nav-item>
                </b-nav>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                <b-nav-form>
                    <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
                    <b-button size="sm" class="my-2 my-sm-0" type="submit" @click.prevent="doTest">Search</b-button>
                </b-nav-form>

                <!-- <b-nav-item-dropdown text="Lang" right>
                    <b-dropdown-item href="#">EN</b-dropdown-item>
                    <b-dropdown-item href="#">ES</b-dropdown-item>
                    <b-dropdown-item href="#">RU</b-dropdown-item>
                    <b-dropdown-item href="#">FA</b-dropdown-item>
                </b-nav-item-dropdown> -->

                <b-nav-item v-if="!userLoggedIn" to="/login">
                    Login
                </b-nav-item>

                <b-nav-item-dropdown v-if="userLoggedIn" right>
                    <!-- Using 'button-content' slot -->
                    <template v-slot:button-content>
                        <em>Logout</em>
                    </template>
                    
                    <b-dropdown-item href="#">Profile</b-dropdown-item>
                    <b-dropdown-item href="#">Log Out</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
    export default 
    {
        data() {
            return {
                title: 'Jeroens Weblog',
                items: []
            }
        },
        created() {
            // 2 levels deep nested routing:
            // level #1: master layout component
            // level #2: page components
            this.$router.options.routes.forEach(route => {
                route.children.forEach(pageRoute => {
                    this.items.push({
                        name: pageRoute.name, 
                        path: pageRoute.path
                    });
                })
            })
        },
        methods: {
            doTest() {
                axios({ url: '/api/user', method: 'GET' }).then(resp => { console.log(resp); })
            },
        },
        computed: {
            userLoggedIn() {
                return this.$store.getters['AuthenticationStore/isAuthenticated'] === true;
            }
        }
    }
</script>