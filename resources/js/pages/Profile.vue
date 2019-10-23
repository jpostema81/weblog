<template>
    <div>
        <h3>Profile</h3>

        <h5>Contact Information</h5>

        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" :value="user.first_name" required name="firstName" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('firstName') }" />
                <div v-if="submitted && errors.hasOwnProperty('firstName')" class="invalid-feedback">{{ errors.firstName.join(' ') }}</div>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" :value="user.last_name" required name="lastName" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('lastName') }" />
                <div v-if="submitted && errors.hasOwnProperty('lastName')" class="invalid-feedback">{{ errors.lastName.join(' ') }}</div>
            </div>

            <div class="form-group">
                <label for="username">Emailaddress</label>
                <input type="text" :value="user.email" required name="email" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('email') }" />
                <div v-if="submitted && errors.hasOwnProperty('email')" class="invalid-feedback">{{ errors.email.join(' ') }}</div>
            </div>


            <div class="form-group">
                <label for="passwordReset" class="mr-3">New password</label>
                <button type="submit" class="btn btn-primary" :disabled="status.registering" id="passwordReset" @click="displayPasswordFields = !displayPasswordFields">Reset your password</button>

                <span v-if="displayPasswordFields">
                    <div class="form-group mt-3">
                        <label for="password">Password confirmation</label>
                        <input type="password" id="password" value="" required title="Please use at least 6 characters" name="password" class="form-control" 
                        :class="{ 'is-invalid': submitted && errors.hasOwnProperty('password') }" />
                        <div v-if="submitted && errors.hasOwnProperty('password')" class="invalid-feedback">{{ errors.password.join(' ') }}</div>

                        <label for="password_confirmation">Password</label>
                        <input type="password" id="password_confirmation" value="" required title="Please use at least 6 characters" name="password_confirmation" class="form-control" 
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
            }
        },
        computed: {
            ...mapState('AuthenticationStore', {
                status: state => state.status,
                errors: state => state.errors,
            }),
            ...mapGetters({
                user: 'AuthenticationStore/user',
            }),
        },
        methods: 
        {
            ...mapActions('AuthenticationStore', {
                //logout: 'LOGOUT' 
            }),
            handleSubmit() 
            {
                this.submitted = true;
                const { email, password } = this;

                this.$store.dispatch('AuthenticationStore/LOGIN', { email, password }).then(() => 
                {
                    this.$router.push('/home');
                });
            },
        }
    }
</script>