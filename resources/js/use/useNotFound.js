import { ref } from "vue";
import { useRouter } from "vue-router";

const abortMessage = ref('')
const useNotFound = () => {
    const router = useRouter()

    const abort = (message = null) => {
        if(message) {
            abortMessage.value = message
        }

        return router.push({ name: 'not-found', params: { notFound: '404' } })
    }

    return { abort }
}

export { abortMessage, useNotFound }





