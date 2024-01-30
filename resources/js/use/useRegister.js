import {useAPI} from "@/use/useAPI.js";
import {reactive} from "vue";
import {useAuthStore} from "@/stores/auth.js";
import {useRouter} from "vue-router";
import gql from 'graphql-tag';

export const useRegister = () => {

    const state = reactive({
        firstName: '',
        lastName: '',
        email: '',
        password: '',
        passwordConfirmation: ''
    })

    const store = useAuthStore()
    const router = useRouter()
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
                    url: "http://lms.test/verify-email?id=__ID__&token=__HASH__"
                }
            }
        }

        // const query = `
        //     mutation {
        //         register(input: {
        //             first_name: "${state.firstName}"
        //             last_name: "${state.lastName}"
        //             email: "${state.email}"
        //             password: "${state.password}"
        //             password_confirmation: "${state.passwordConfirmation}"
        //             verification_url: {
        //                 url: "http://lms.test/verify-email?id=__ID__&token=__HASH__"
        //             }
        //         }) {
        //             token
        //             status
        //         }
        //     }
        //     `

        await fetchData(registerMutation, variables)

        if (success.value){
            const { status } = success.value.data.register

            if(status === 'MUST_VERIFY_EMAIL'){
                store.verifyEmailAddress = state.email
                return router.push({ name: 'verify-email' })
            }
        }
    }

    return { state, apiErrors, success, pending, register }
}
