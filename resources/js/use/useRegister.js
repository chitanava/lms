import {useAPI} from "@/use/useAPI.js";
import {computed, reactive} from "vue";
import gql from 'graphql-tag';
import {useRedirect} from "@/use/useRedirect.js";
import {useClientValidation} from "@/use/useClientValidation.js";
import {email, helpers, required, minLength, sameAs} from "@vuelidate/validators";
import _startCase from "lodash/startCase"
import {trans} from "laravel-vue-i18n";

export const useRegister = () => {

    const state = reactive({
        firstName: '',
        lastName: '',
        email: '',
        password: '',
        passwordConfirmation: ''
    })

    const { redirectToRoute } = useRedirect()

    const { clientErrors, transformToErrorObject, validate } = useClientValidation()
    const { apiErrors, success, pending, fetchData } = useAPI()

    const rules = computed(() => ({
        firstName: {
            required: helpers.withMessage(({$property}) => trans('validation.required', { attribute: $property }), required),
                $lazy: true
        },
        lastName: {
            required: helpers.withMessage(({$property}) => trans('validation.required', { attribute: $property }), required),
                $lazy: true
        },
        email: {
            required: helpers.withMessage(({$property}) => trans('validation.required', { attribute: $property }), required),
                email: helpers.withMessage(({$property}) => trans('validation.email', { attribute: $property }), email),
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

    const registerProcess = async () => {
        const isFormCorrect = await v$.value.$validate()

        if (!isFormCorrect) {
            clientErrors.value = transformToErrorObject(v$.value)

            return
        }

        await register()
        clientErrors.value = null
    }

    const register = async () => {

        const registerMutation = gql`
            mutation Register($input: RegisterInput!) {
                register(input: $input) {
                    token
                    status
                }
            }
        `

        const variables = {
            input: {
                first_name: state.firstName,
                last_name: state.lastName,
                email: state.email,
                password: state.password,
                password_confirmation: state.passwordConfirmation,
                verification_url: {
                    url: import.meta.env.VITE_VERIFICATION_URL
                }
            }
        }

        await fetchData(registerMutation, variables)

        if (success.value){
            const { status } = success.value.data.register

            if(status === 'MUST_VERIFY_EMAIL'){
                return redirectToRoute('verify-email', {
                    data: {
                        email: state.email
                    }
                })
            }
        }
    }

    return { state, apiErrors, success, pending, register, registerProcess, clientErrors }
}
