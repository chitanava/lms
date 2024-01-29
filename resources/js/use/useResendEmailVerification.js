import {useAPI} from "@/use/useAPI.js";
import {useAuthStore} from "@/stores/auth.js";
import {ref} from "vue";

export const useResendEmailVerification = () => {
    const store = useAuthStore()
    const showAlert = ref(false)
    const { apiErrors, success, pending, load } = useAPI()

    const resendEmailVerification = async () => {
        showAlert.value = false

        const query = `
            mutation {
                resendEmailVerification(input: {
                    email: "${store.verifyEmailAddress}"
                    verification_url: {
                        url: "http://lms.test/verify-email?id=__ID__&token=__HASH__"
                    }
                }) {
                    status
                }
            }
            `

        await load(query)

        if (success.value){
            const { status } = success.value.data.resendEmailVerification

            if(status === 'EMAIL_SENT'){
                showAlert.value = true
            }
        }
    }

    return { apiErrors, success, pending, showAlert, resendEmailVerification }
}
