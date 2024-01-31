import {reactive} from "vue";
import {useAuthStore} from "@/stores/auth.js";
import {useAPI} from "@/use/useAPI.js";
import gql from 'graphql-tag';
import {useRedirect} from "@/use/useRedirect.js";

export const useLogin = () => {
    const state = reactive({
        email: '',
        password: ''
    })

    const store = useAuthStore()

    const { redirectToRoute } = useRedirect()

    const { apiErrors, success, pending, fetchData } = useAPI()

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

    return { state, apiErrors, success, pending, login }
}
