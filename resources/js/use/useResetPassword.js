import {computed, reactive} from "vue";
import {useAPI} from "@/use/useAPI.js";
import gql from 'graphql-tag';
import {useRoute} from "vue-router";
import {useRedirect} from "@/use/useRedirect.js";
import {useClientValidation} from "@/use/useClientValidation.js";
import {email, helpers, minLength, required, sameAs} from "@vuelidate/validators";
import {trans} from "laravel-vue-i18n";

export const useResetPassword = () => {
    const state = reactive({
        email: '',
        token: '',
        password: '',
        passwordConfirmation: ''
    })

    const { redirectToRoute } = useRedirect()

    const route = useRoute()

    const { email: _email, token } = route.query
    state.email = _email
    state.token = token

    const { clientErrors, transformToErrorObject, validate } = useClientValidation()
    const { apiErrors, success, pending, fetchData } = useAPI()

    const rules = computed(() => ({
        email: {
            required: helpers.withMessage(({$property}) => trans('validation.required', { attribute: $property }), required),
            email: helpers.withMessage(({$property}) => trans('validation.email', { attribute: $property }), email),
            $lazy: true
        },
        token: {
            required: helpers.withMessage(({$property}) => trans('validation.required', { attribute: $property }), required),
            $lazy: true
        },
        password: {
            required: helpers.withMessage(({$property}) => trans('validation.required', { attribute: $property }), required),
            minLength: helpers.withMessage(({$property}) => trans('validation.min.string', { attribute: $property, min: '6' }), minLength(6)),
            sameAsRef: helpers.withMessage(({$property}) => trans('validation.confirmed', { attribute: $property }), sameAs(state.passwordConfirmation)),
            $lazy: true
        },
    }))

    const v$ = validate(rules, state)

    const resetPasswordProcess = async () => {
        const isFormCorrect = await v$.value.$validate()

        if (!isFormCorrect) {
            clientErrors.value = transformToErrorObject(v$.value)

            return
        }

        await resetPassword()
        clientErrors.value = null
    }

    const resetPassword = async () => {
        const resetPasswordMutation = gql`
            mutation ResetPassword($input: ResetPasswordInput!) {
                resetPassword(input: $input) {
                    status,
                    message
                }
            }
        `

        const variables = {
            input: {
                email: _email,
                token,
                password: state.password,
                password_confirmation: state.passwordConfirmation
            }
        }

        await fetchData(resetPasswordMutation, variables)

        if (success.value){
            const { status, message } = success.value.data.resetPassword

            if(status === 'PASSWORD_RESET'){
                return redirectToRoute('login', {
                    message
                })
            }
        }
    }

    return { state, apiErrors, success, pending, resetPassword, resetPasswordProcess, clientErrors }
}
