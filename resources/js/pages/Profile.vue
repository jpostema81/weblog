<template>
    <div>
        <h3>Profile</h3>

        <h5>Contact Information</h5>

        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" :value="user.first_name" @input="updateFirstName" required name="firstName" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('firstName') }" />
                <div v-if="submitted && errors.hasOwnProperty('firstName')" class="invalid-feedback">{{ errors.firstName.join(' ') }}</div>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" :value="user.last_name" @input="updateLastName" required name="lastName" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('lastName') }" />
                <div v-if="submitted && errors.hasOwnProperty('lastName')" class="invalid-feedback">{{ errors.lastName.join(' ') }}</div>
            </div>

            <div class="form-group">
                <label for="username">Emailaddress</label>
                <input type="text" :value="user.email" @input="updateEmail" required name="email" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('email') }" />
                <div v-if="submitted && errors.hasOwnProperty('email')" class="invalid-feedback">{{ errors.email.join(' ') }}</div>
            </div>


            <div class="form-group">
                <button type="button" class="btn btn-primary" :disabled="status.registering" id="passwordReset" @click="displayPasswordFields = !displayPasswordFields">Reset your password</button>

                <span v-if="displayPasswordFields">
                    <div class="form-group mt-3">
                        <label for="password">New password</label>
                        <input type="password" autocomplete="new-password" id="password" v-model="updatedUser.password" required title="Please use at least 6 characters" name="password" class="form-control" 
                        :class="{ 'is-invalid': submitted && errors.hasOwnProperty('password') }" />
                        <div v-if="submitted && errors.hasOwnProperty('password')" class="invalid-feedback">{{ errors.password.join(' ') }}</div>

                        <label for="password_confirmation">New password confirmation</label>
                        <input type="password" autocomplete="new-password" id="password_confirmation" v-model="updatedUser.password_confirmation" required title="Please use at least 6 characters" name="password_confirmation" class="form-control" 
                        :class="{ 'is-invalid': submitted && errors.hasOwnProperty('password') }" />
                        <div v-if="submitted && errors.hasOwnProperty('password')" class="invalid-feedback">{{ errors.password.join(' ') }}</div>
                    </div>
                </span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" :disabled="status.registering">Update</button>
                <img v-show="status === 'registering'" src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
                <router-link to="/home" class="btn btn-link">Back</router-link>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapGetters, mapState, mapActions } from 'vuex';

    export default 
    {
        data() 
        {
            return {
                submitted: false,
                displayPasswordFields: false,
                user: this.$store.state.AuthenticationStore.user,
                updatedUser: {...this.$store.state.AuthenticationStore.user},
            }
        },
        computed: {
            ...mapState('AuthenticationStore', {
                status: state => state.status,
                errors: state => state.errors,
            }),
        },
        methods: 
        {
            ...mapActions('AuthenticationStore', {
                //logout: 'logout' 
            }),
            updateFirstName(e) {
                this.updatedUser.first_name = e.target.value;
            },
            updateLastName(e) {
                console.log('updateLastName');
                this.updatedUser.last_name = e.target.value;
            },
            updateEmail(e) {
                console.log('updateEmail');
                this.updatedUser.email = e.target.value;
            },
            handleSubmit(e) 
            {
                this.submitted = true;
                console.log(this.user);

                // this.$store.dispatch('AuthenticationStore/updateUser', { user }).then(() => 
                // {
                //     this.$router.push('/home');
                // });
            },
        }
    }
</script>