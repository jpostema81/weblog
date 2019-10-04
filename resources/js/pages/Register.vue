<template>
    <div>
        <h2>Register</h2>

        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" v-model="user.firstName" required name="firstName" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('firstName') }" />
                <div v-if="submitted && errors.hasOwnProperty('firstName')" class="invalid-feedback">{{ errors.firstName }}</div>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" v-model="user.lastName" required name="lastName" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('lastName') }" />
                <div v-if="submitted && errors.hasOwnProperty('lastName')" class="invalid-feedback">{{ errors.lastName }}</div>
            </div>

            <div class="form-group">
                <label for="username">Emailaddress</label>
                <input type="text" v-model="user.email" required name="email" class="form-control" :class="{ 'is-invalid': submitted && errors.hasOwnProperty('email') }" />
                <div v-if="submitted && errors.hasOwnProperty('email')" class="invalid-feedback">{{ errors.email }}</div>
            </div>

            <div class="form-group">
                <label htmlFor="password">Password</label>
                <input type="password" v-model="user.password" required title="Please use at least 6 characters" name="password" class="form-control" 
                :class="{ 'is-invalid': submitted && errors.hasOwnProperty('password') }" />
                <div v-if="submitted && errors.hasOwnProperty('password')" class="invalid-feedback">{{ errors.password }}</div>
            </div>

            <div class="form-group">
                <label htmlFor="password">Password confirmation</label>
                <input type="password" v-model="user.password_confirmation" required title="Please use at least 6 characters" name="password_confirmation" class="form-control" 
                :class="{ 'is-invalid': submitted && errors.hasOwnProperty('password') }" />
                <div v-if="submitted && errors.hasOwnProperty('password')" class="invalid-feedback">{{ errors.password }}</div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" :disabled="status.registering">Register</button>
                <img v-show="status == 'registering'" src="data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==" />
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
                    firstName: '',
                    lastName: '',
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
            //...mapState('account', ['status'])
        },
        methods: 
        {
            ...mapActions('AuthenticationStore', {
                register: 'REGISTER'
            }),
            //...mapActions('account', ['register']),
            handleSubmit(e) 
            {
                this.submitted = true;
                this.register(this.user);
            }
        }
    };
</script>