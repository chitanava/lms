import {reactive, ref} from "vue";
import {useRouter} from "vue-router";
import {useAPI} from "@/use/useAPI.js";
import gql from 'graphql-tag';
import {useNotFound} from "@/use/useNotFound.js";

export const useForgotPassword = () => {
    const showAlert = ref(false)

    const { abort } = useNotFound()

    const state = reactive({
        email: ''
    })

    const router = useRouter()

    const { apiErrors, success, pending, fetchData } = useAPI()

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
                    url: "https://lms.test/reset-password?email=__EMAIL__&token=__TOKEN__"
                }
            }
        }

        await fetchData(forgotPasswordMutation, variables)

        if(apiErrors.value && !apiErrors.value.validation){
            abort(apiErrors.value.message)
        }

        if (success.value){
            const { status } = success.value.data.forgotPassword

            if(status === 'EMAIL_SENT'){
                showAlert.value = true
            }

            state.email = ''
        }
    }

    return { showAlert, state, apiErrors, success, pending, forgotPassword }
}
