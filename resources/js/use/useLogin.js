import {reactive} from "vue";
import {useRouter} from "vue-router";
import {useAuthStore} from "@/stores/auth.js";
import {useAPI} from "@/use/useAPI.js";
import gql from 'graphql-tag';

export const useLogin = () => {
    const state = reactive({
        email: '',
        password: ''
    })

    const router = useRouter()
    const store = useAuthStore()

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
                store.verifyEmailAddress = state.email
                return router.push({ name: 'verify-email' })
            }

            store.token = token
            return router.push({ name: 'home' })
        }
    }

    return { state, apiErrors, success, pending, login }
}
