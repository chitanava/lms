import {ref} from "vue";
import axios from "axios";

export const useAPI = () => {
    const apiErrors = ref({})
    const success = ref(false)

    const load = async (query) => {
        try {
            const response = await axios({
                url: 'http://lms.test/graphql',
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

        } catch (e) {
            console.log(e.message)
        }
    }

    const validate = (errors) => {
        apiErrors.value = {}
        success.value = false

        if(errors && Array.isArray(errors)) {
            apiErrors.value = {
                message: errors[0].message
            }
            const validationError = errors[0].extensions?.validation

            if (validationError) {
                for (const [key, [value]] of Object.entries(validationError)) {
                    apiErrors.value.validation = {
                        ...apiErrors.value?.validation,
                        [key.split('.').pop()]: value,
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
        load
    }
}
