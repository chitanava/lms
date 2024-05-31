import {reactive} from "vue";
import {useAuthStore} from "@/stores/auth.js";
import {useAPI} from "@/use/useAPI.js";
import gql from 'graphql-tag';
import {useRedirect} from "@/use/useRedirect.js";
import {useClientValidation} from "@/use/useClientValidation.js";
import {email, helpers, required} from "@vuelidate/validators";
import { trans } from 'laravel-vue-i18n';

export const useLogin = () => {
    const state = reactive({
        email: '',
        password: ''
    })

    const store = useAuthStore()

    const { redirectToRoute } = useRedirect()

    const { clientErrors, transformToErrorObject, validate } = useClientValidation()
    const { apiErrors, success, pending, fetchData } = useAPI()

    const rules = {
        email: {
            required: helpers.withMessage(({$property}) => trans('validation.required', { attribute: $property }), required),
            email: helpers.withMessage(({$property}) => trans('validation.email', { attribute: $property }), email),
            $lazy: true
        },
        password: {
            required: helpers.withMessage(({$property}) => trans('validation.required', { attribute: $property }), required),
            $lazy: true
        },
    }

    const v$ = validate(rules, state)

    const loginProcess = async () => {
        const isFormCorrect = await v$.value.$validate()

        if (!isFormCorrect) {
            clientErrors.value = transformToErrorObject(v$.value)
            // apiErrors.value = null
            return
        }

        await login()
        clientErrors.value = null
    }

    const login = async () => {
        const loginMutation = gql`
            mutation Login($input: LoginInput!) {
                login(input: $input) {
                    token
                    status
                }
            }
        `

        const variables = {
            input: {
                email: state.email,
                password: state.password
            }
        }

        await fetchData(loginMutation, variables)

        if (success.value){
            const { token, status } = success.value.data.login

            if(!token && status === 'MUST_VERIFY_EMAIL'){
                return redirectToRoute('verify-email', {
                    data: {
                        email: state.email
                    }
                })
            }

            store.token = token
            return redirectToRoute('home')
        }
    }

    return { state, apiErrors, success, pending, login, loginProcess, clientErrors }
}
