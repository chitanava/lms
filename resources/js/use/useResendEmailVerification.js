import {useAPI} from "@/use/useAPI.js";
import {ref} from "vue";
import gql from 'graphql-tag';
import { useRedirect } from "@/use/useRedirect.js";
import {useClientValidation} from "@/use/useClientValidation.js";
import {email, helpers, required} from "@vuelidate/validators";

export const useResendEmailVerification = () => {
    const showAlert = ref(false)

    const { clientErrors, transformToErrorObject, validate } = useClientValidation()
    const { apiErrors, success, pending, fetchData } = useAPI()

    const { getRedirectData } = useRedirect()
    const { email: _email } = getRedirectData()

    const rules = {
        email: {
            required: helpers.withMessage(({$property}) => `v$ The ${$property} field is required.`, required),
            email: helpers.withMessage(({$property}) => `v$ The ${$property} field must be a valid email address.`, email),
            $lazy: true
        }
    }

    const v$ = validate(rules, {
        email: _email
    })

    const resendEmailVerificationProcess = async () => {
        showAlert.value = false

        const isFormCorrect = await v$.value.$validate()

        if (!isFormCorrect) {
            clientErrors.value = transformToErrorObject(v$.value)
            return
        }

        await resendEmailVerification()
        clientErrors.value = null
    }

    const resendEmailVerification = async () => {
        const resendEmailVerificationMutation = gql`
            mutation ResendEmailVerification($input: ResendEmailVerificationInput!) {
                resendEmailVerification(input: $input) {
                    status
                }
            }
        `

        const variables = {
            input: {
                email: _email,
                verification_url: {
                    url: import.meta.env.VITE_VERIFICATION_URL
                }
            }
        }

        await fetchData(resendEmailVerificationMutation, variables)

        if (success.value){
            const { status } = success.value.data.resendEmailVerification

            if(status === 'EMAIL_SENT'){
                showAlert.value = true
            }
        }
    }

    return { apiErrors, success, pending, showAlert, resendEmailVerification, resendEmailVerificationProcess, clientErrors }
}
