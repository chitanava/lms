import {useAPI} from "@/use/useAPI.js";
import {useAuthStore} from "@/stores/auth.js";
import {ref} from "vue";
import gql from 'graphql-tag';

export const useResendEmailVerification = () => {
    const store = useAuthStore()
    const showAlert = ref(false)
    const { apiErrors, success, pending, fetchData } = useAPI()

    const resendEmailVerification = async () => {
        showAlert.value = false

        const resendEmailVerificationMutation = gql`
            mutation ResendEmailVerification($input: ResendEmailVerificationInput!) {
                resendEmailVerification(input: $input) {
                    status
                }
            }
        `

        const variables = {
            input: {
                email: store.verifyEmailAddress,
                verification_url: {
                    url: "http://lms.test/verify-email?id=__ID__&token=__HASH__"
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

    return { apiErrors, success, pending, showAlert, resendEmailVerification }
}
