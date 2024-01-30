import { useAPI } from "@/use/useAPI.js";
import _isEmpty from "lodash/isEmpty.js";
import gql from 'graphql-tag';
import { abortMessage } from "@/use/useNotFound.js";

export const useVerifyEmail = async (to, next) => {

    if (_isEmpty(to.query)) {
        return next()
    }

    const { id, token } = to.query

    if (!id || !token) {
        return next()
    }

    const { apiErrors, success, fetchData } = useAPI()

    const verifyEmailMutation = gql`
        mutation VerifyEmail($input: VerifyEmailInput!) {
            verifyEmail(input: $input) {
                status
            }
        }
    `

    const variables = {
        input: {
            id,
            hash: token
        }
    }

    await fetchData(verifyEmailMutation, variables)

    if (apiErrors.value) {
        abortMessage.value = apiErrors.value.message
        return next({ name: 'not-found', params: { notFound: '404' } })
    }

    if (success.value) {
        const {status} = success.value.data.verifyEmail

        if (status === "VERIFIED") {
            return next({ name: 'login' })
        }
    }

    next()
}
