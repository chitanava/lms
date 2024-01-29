import { useAPI } from "@/use/useAPI.js";
import _isEmpty from "lodash/isEmpty.js";

export const useVerifyEmail = async (to, next) => {
    if (_isEmpty(to.query)) {
        return next()
    }

    const { id, token } = to.query

    if (!id || !token) {
        return next()
    }

    const { apiErrors, success, load } = useAPI()

    const query = `
            mutation {
                verifyEmail(input: {
                    id: "${id}"
                    hash: "${token}"
                }) {
                    status
                }
            }
        `

    await load(query)

    if (apiErrors.value) {
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
