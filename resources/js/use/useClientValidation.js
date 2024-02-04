import {ref} from "vue";
import {useVuelidate} from "@vuelidate/core";

export const useClientValidation = () => {
    const clientErrors = ref(null)

    const validate = (rules, state) => {
        return useVuelidate(rules, state)
    }

    const transformToErrorObject = (vValue) => {
        const filteredObject = Object.fromEntries(
            Object.entries(vValue).filter(([key]) => !key.startsWith('$'))
        );

        const resultObject = {};

        for (const [key, value] of Object.entries(filteredObject)) {
            resultObject[key] = value.$errors[0]?.$message;
        }

        return resultObject;
    }

    return { clientErrors, transformToErrorObject, validate}

}
