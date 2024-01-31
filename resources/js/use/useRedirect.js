import { ref } from 'vue'
import { useRouter } from 'vue-router'

const redirectMessage = ref('')
const redirectData = ref({})

export const useRedirect = () => {
    const router = useRouter()

    const getRedirectData = () => redirectData.value

    const getRedirectMessage = () => redirectMessage.value

    const setRedirectMessage = (message) => {
        redirectMessage.value = message
    }

    const redirectToRoute = (routeName, options = {}) => {
        const { message = '', data = {}, params } = options

        redirectMessage.value = message
        redirectData.value = data

        const payload = { name: routeName, params }

        return router.push(payload)
    };

    return {
        redirectToRoute,
        getRedirectData,
        getRedirectMessage,
        setRedirectMessage
    }
}
