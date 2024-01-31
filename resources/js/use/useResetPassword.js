import {reactive} from "vue";
import {useAPI} from "@/use/useAPI.js";
import gql from 'graphql-tag';
import {useRoute} from "vue-router";
import {useRedirect} from "@/use/useRedirect.js";

export const useResetPassword = () => {
    const state = reactive({
        password: '',
        passwordConfirmation: ''
    })

    const { redirectToRoute } = useRedirect()

    const route = useRoute()

    const { email, token } = route.query

    const { apiErrors, success, pending, fetchData } = useAPI()

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
                email,
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

    return { state, apiErrors, success, pending, resetPassword }
}
