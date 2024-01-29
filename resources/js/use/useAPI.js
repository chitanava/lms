import {ref} from "vue";
import axios from "axios";
import _camelCase from "lodash/camelCase"

export const useAPI = () => {
    const apiErrors = ref(null)
    const success = ref(null)
    const pending = ref(false)

    const load = async (query) => {
        try {
            pending.value = true

            // await new Promise(resolve => setTimeout(resolve, 2000));

            const response = await axios({
                url: import.meta.env.VITE_API_URL,
                method: 'post',
                headers: {
                    'Content-Type': 'application/json',
                },
                data: {
                    query
                }
            })

            const data = response.data

            if (validate(data.errors)) {
                success.value = data
            }

            pending.value = false

        } catch (e) {
            console.log(e.message)
        }
    }

    const validate = (errors) => {
        apiErrors.value = null
        success.value = null

        if(errors && Array.isArray(errors)) {
            apiErrors.value = {
                message: errors[0].message
            }
            const validationError = errors[0].extensions?.validation

            if (validationError) {
                for (const [key, [value]] of Object.entries(validationError)) {
                    apiErrors.value.validation = {
                        ...apiErrors.value?.validation,
                        [_camelCase(key.split('.').pop())]: value,
                    }
                }
            }

            return false
        }

        return true
    }

    return {
        apiErrors,
        success,
        pending,
        load
    }
}
