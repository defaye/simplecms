<template>
    <div>
        <form method="POST" action="/admin/login" @submit.prevent="submit">

            <b-form-group
                horizontal
                :label-cols="4"
                breakpoint="lg"
                label="E-Mail Address"
                label-for="email"
            >
                <b-form-input
                    :disabled="processing"
                    :formatter="v => v ? v.toLowerCase() : v"
                    :required="true"
                    :state="errors.has('email') ? false : null"
                    autofocus
                    id="email"
                    tabindex="1"
                    type="email"
                    v-model.trim="form.email"
                >
                </b-form-input>
                <b-form-invalid-feedback v-if="errors.has('email')">
                    {{ errors.get('email').join(' ').trim() }}
                </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group
                horizontal
                :label-cols="4"
                breakpoint="lg"
                label="Password"
                label-for="password"
            >
                <b-form-input
                    :disabled="processing"
                    :required="true"
                    :state="errors.has('password') ? false : null"
                    id="password"
                    tabindex="1"
                    type="password"
                    v-model="form.password"
                >
                </b-form-input>
                <b-form-invalid-feedback v-if="errors.has('password')">
                    {{ errors.get('password').join(' ').trim() }}
                </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group
                horizontal
                :label-cols="4"
                breakpoint="lg"
            >
                <b-form-checkbox id="remember"
                    v-model="form.remember"
                    :value="true"
                    :unchecked-value="false"
                >
                    Remember Me
                </b-form-checkbox>
            </b-form-group>

            <b-form-group
                horizontal
                :label-cols="4"
                breakpoint="lg"
            >
                <b-button variant="primary" type="submit">Login</b-button>

                <a class="btn btn-link" href="/admin/password/reset">
                    Forgot Your Password?
                </a>
            </b-form-group>

        </form>
    </div>
</template>
<script>
    'use strict'
    import {
        BButton,
        BFormCheckbox,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
    } from 'bootstrap-vue'
    import ErrorsAndProcessing from '~/js/mixins/ErrorsAndProcessing'

    export default {
        mixins: [
            ErrorsAndProcessing
        ],
        components: {
            BButton,
            BFormCheckbox,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback
        },
        data() {
            return {
                form: {
                    email: undefined,
                    password: undefined,
                    remember: false
                }
            }
        },
        methods: {
            submit() {
                if (this.processing) {
                    return
                }
                this.processing = true
                axios.post('/admin/login', this.form)
                    .then(response => {
                        window.location.href = '/admin'
                    })
                    .catch(error => {
                        this.errors = error.response.data
                        console.error(error.response.data)
                    })
                    .then(() => {
                        this.processing = false
                    })
            }
        }
    }
</script>
