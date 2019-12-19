<style></style>

<template>
    <div>
        <b-navbar toggleable="lg" type="dark" variant="primary" id="navigationBar">
            <b-navbar-brand href="#">{{ title }}</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav-item to="/home">Home</b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                <b-nav-item v-if="!userLoggedIn" to="/login">
                    Login
                </b-nav-item>
                <b-nav-item v-if="!userLoggedIn" to="/register">Register</b-nav-item>

                <b-nav-item-dropdown v-if="userLoggedIn" right>
                    <!-- Using 'button-content' slot -->
                    <template v-slot:button-content>
                        <em>{{ user.first_name + ' ' + user.last_name }}</em>
                    </template>
                    
                    <b-dropdown-item to="/dashboard">Dashboard</b-dropdown-item>
                    <b-dropdown-item to="/dashboard/profile">Profile</b-dropdown-item>
                    <b-dropdown-item @click="logout">Log Out</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
    import { mapMutations, mapGetters } from 'vuex';

    export default 
    {
        data() {
            return {
                title: 'Jeroens Weblog',
            }
        },
        methods: 
        {
            ...mapMutations('AuthenticationStore', {
                logout: 'logout' 
            }),
        },
        computed: {
            ...mapGetters({
                userLoggedIn: 'AuthenticationStore/isAuthenticated',
                user: 'AuthenticationStore/user',
            }),
        }
    }
</script>