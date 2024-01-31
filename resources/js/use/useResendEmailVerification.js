import {useAPI} from "@/use/useAPI.js";
import {ref} from "vue";
import gql from 'graphql-tag';
import { useRedirect } from "@/use/useRedirect.js";

export const useResendEmailVerification = () => {
    const showAlert = ref(false)

    const { apiErrors, success, pending, fetchData } = useAPI()

    const { getRedirectData } = useRedirect()
    const { email } = getRedirectData()

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
                email,
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
