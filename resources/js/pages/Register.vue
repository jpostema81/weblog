<template>
    <div>
        <h2>Register</h2>

        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" v-model="user.first_name" required name="first_name" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('first_name') }" />
                <div v-if="submitted && errors.hasOwnProperty('first_name')" class="invalid-feedback">{{ errors.first_name.join(' ') }}</div>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" v-model="user.last_name" required name="last_name" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('last_name') }" />
                <div v-if="submitted && errors.hasOwnProperty('last_name')" class="invalid-feedback">{{ errors.last_name.join(' ') }}</div>
            </div>

            <div class="form-group">
                <label for="username">Emailaddress</label>
                <input type="text" v-model="user.email" required name="email" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('email') }" />
                <div v-if="submitted && errors.hasOwnProperty('email')" class="invalid-feedback">{{ errors.email.join(' ') }}</div>
            </div>

            <div class="form-group">
                <label htmlFor="password">Password</label>
                <input type="password" v-model="user.password" required title="Please use at least 6 characters" name="password" class="form-control" 
                :class="{ 'is-invalid': submitted && errors.hasOwnProperty('password') }" />
                <div v-if="submitted && errors.hasOwnProperty('password')" class="invalid-feedback">{{ errors.password.join(' ') }}</div>
            </div>

            <div class="form-group">
                <label htmlFor="password">Password confirmation</label>
                <input type="password" v-model="user.password_confirmation" required title="Please use at least 6 characters" name="password_confirmation" class="form-control" 
                :class="{ 'is-invalid': submitted && errors.hasOwnProperty('password') }" />
                <div v-if="submitted && errors.hasOwnProperty('password')" class="invalid-feedback">{{ errors.password.join(' ') }}</div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" :disabled="status.registering">Register</button>
                <img v-show="status === 'registering'" src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
                <router-link to="/login" class="btn btn-link">Cancel</router-link>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex';


    export default 
    {
        data() 
        {
            return {
                user: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    username: '',
                    password: '',
                    password_confirmation: '',
                },
                submitted: false,
            }
        },
        computed:
        {
            ...mapState('AuthenticationStore', {
                status: state => state.status,
                errors: state => state.errors
            })
        },
        methods: 
        {
            ...mapActions('AuthenticationStore', {
                register: 'register'
            }),
            handleSubmit(e) 
            {
                this.submitted = true;
                this.register(this.user);
            }
        }
    };
</script>