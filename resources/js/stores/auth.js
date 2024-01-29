import { defineStore } from 'pinia'
import {ref} from "vue";

export const useAuthStore = defineStore('auth', () => {
    const token = ref(null)
    const verifyEmailAddress = ref(null)

    return { token, verifyEmailAddress }
})
