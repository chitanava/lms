import {computed, ref} from "vue";

export const usePasswordInputVisibily = () => {
    const showPassword = ref(false)

    const passwordInputType = computed(() => showPassword.value ? 'text' : 'password')

    const togglePasswordVisibility = () => {
        showPassword.value = !showPassword.value
    }

    return {
        showPassword,
        passwordInputType,
        togglePasswordVisibility
    }
}
