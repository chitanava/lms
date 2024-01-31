import {useAPI} from "@/use/useAPI.js";
import {reactive} from "vue";
import gql from 'graphql-tag';
import {useRedirect} from "@/use/useRedirect.js";

export const useRegister = () => {

    const state = reactive({
        firstName: '',
        lastName: '',
        email: '',
        password: '',
        passwordConfirmation: ''
    })

    const { redirectToRoute } = useRedirect()

    const { apiErrors, success, pending, fetchData } = useAPI()

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

    return { state, apiErrors, success, pending, register }
}
