import {reactive, ref} from "vue";
import {useAPI} from "@/use/useAPI.js";
import gql from 'graphql-tag';
import { useRedirect } from "@/use/useRedirect.js";
import {useClientValidation} from "@/use/useClientValidation.js";
import { required, email, helpers } from '@vuelidate/validators'
import {trans} from "laravel-vue-i18n";

export const useForgotPassword = () => {
    const showAlert = ref(false)
    const { redirectToRoute } = useRedirect()

    const state = reactive({
        email: ''
    })

    const { clientErrors, transformToErrorObject, validate } = useClientValidation()
    const { apiErrors, success, pending, fetchData } = useAPI()

    const rules = {
        email: {
            required: helpers.withMessage(({$property}) => trans('validation.required', { attribute: $property }), required),
            email: helpers.withMessage(({$property}) => trans('validation.email', { attribute: $property }), email),
            $lazy: true
        }
    }

    const v$ = validate(rules, state)

    const forgotPasswordProcess = async () => {
        showAlert.value = false

        const isFormCorrect = await v$.value.$validate()

        if (!isFormCorrect) {
            clientErrors.value = transformToErrorObject(v$.value)
            return
        }

        await forgotPassword()
        clientErrors.value = null
    }

    const forgotPassword = async () => {
        showAlert.value = false

        const forgotPasswordMutation = gql`
            mutation ForgotPassword($input: ForgotPasswordInput!) {
                forgotPassword(input: $input) {
                    status
                }
            }
        `

        const variables = {
            input: {
                email: state.email,
                reset_password_url: {
                    url: import.meta.env.VITE_RESET_PASSWORD_URL
                }
            }
        }

        await fetchData(forgotPasswordMutation, variables)

        if(apiErrors.value && !apiErrors.value.validation){
            redirectToRoute('not-found', {
                message: apiErrors.value.message,
                params: {
                    notFound: '404'
                }
            })
        }

        if (success.value){
            const { status } = success.value.data.forgotPassword

            if(status === 'EMAIL_SENT'){
                showAlert.value = true
            }

            state.email = ''
        }
    }

    return { showAlert, state, apiErrors, success, pending, forgotPassword, forgotPasswordProcess, clientErrors }
}
