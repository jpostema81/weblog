<template>
    <div>
        <h3>Profile</h3>

        <h5>Contact Information</h5>

        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" :value="user.first_name" @input="updateFirstName" required name="first_name" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('first_name') }" />
                <div v-if="submitted && errors.hasOwnProperty('first_name')" class="invalid-feedback">{{ errors.first_name.join(' ') }}</div>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" :value="user.last_name" @input="updateLastName" required name="last_name" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('last_name') }" />
                <div v-if="submitted && errors.hasOwnProperty('last_name')" class="invalid-feedback">{{ errors.last_name.join(' ') }}</div>
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
                        <input type="password" autocomplete="new-password" id="password" v-model="user.password" required title="Please use at least 6 characters" name="password" class="form-control" 
                        :class="{ 'is-invalid': submitted && errors.hasOwnProperty('password') }" />
                        <div v-if="submitted && errors.hasOwnProperty('password')" class="invalid-feedback">{{ errors.password.join(' ') }}</div>

                        <label for="password_confirmation">New password confirmation</label>
                        <input type="password" autocomplete="new-password" id="password_confirmation" v-model="user.password_confirmation" required title="Please use at least 6 characters" name="password_confirmation" class="form-control" 
                        :class="{ 'is-invalid': submitted && errors.hasOwnProperty('password') }" />
                        <div v-if="submitted && errors.hasOwnProperty('password')" class="invalid-feedback">{{ errors.password.join(' ') }}</div>
                    </div>
                </span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" :disabled="status.updating">Update</button>
                <img v-show="status === 'updating'" src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
                <router-link to="/home" class="btn btn-link">Back</router-link>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapState } from 'vuex';

    export default 
    {
        data() 
        {
            return {
                showPasswordReset: false,
                submitted: false,
                displayPasswordFields: false,
                user: null,
            }
        },
        created() {
            this.user = {...this.$store.state.AuthenticationStore.user};
        },
        computed: {
            ...mapState('AuthenticationStore', {
                status: state => state.status,
                errors: state => state.errors,
            }),
        },
        methods: 
        {
            updateFirstName(e) {
                this.user.first_name = e.target.value;
            },
            updateLastName(e) {
                this.user.last_name = e.target.value;
            },
            updateEmail(e) {
                this.user.email = e.target.value;
            },
            handleSubmit(e) 
            {
                this.submitted = true;

                this.$store.dispatch('AuthenticationStore/updateUser', this.user).then(() => 
                {
                    this.$router.push('/home');
                });
            },
        }
    }
</script>