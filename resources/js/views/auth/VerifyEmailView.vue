<script setup>
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import {useAuthStore} from "@/stores/auth.js";
import {useAPI} from "@/use/useAPI.js";
import {ref} from "vue";
import {useRouter} from "vue-router";
import AuthFormError from "@/components/auth/misc/AuthFormError.vue";
import AuthFormAlert from "@/components/auth/misc/AuthFormAlert.vue";

const store = useAuthStore()
const showAlert = ref(false)

const { apiErrors, success, pending, load } = useAPI()

const router = useRouter()

if(! store.verifyEmailAddress) {
    router.push({ name: 'login' })
}
const handleSubmit = async () => {
    showAlert.value = false

    const query = `
            mutation {
                resendEmailVerification(input: {
                    email: "${store.verifyEmailAddress}"
                    verification_url: {
                        url: "https://my-front-end.com/verify-email?id=__ID__&token=__HASH__"
                    }
                }) {
                    status
                }
            }
            `

    await load(query)

    if (success.value && success.value.data.resendEmailVerification.status === 'EMAIL_SENT'){
        showAlert.value = true
    }

}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Verify Email</AuthFormHeader>
        <div class="space-y-6">
            <div class="leading-7">
                <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
            </div>
            <AuthFormAlert v-if="showAlert">
                <h3 class="font-bold">We have just sent you an email!</h3>
                <div class="text-xs">A new verification link has been sent to the email address you provided during registration.</div>
            </AuthFormAlert>
            <div>
                <AuthFormError v-if="apiErrors?.validation?.email">{{ apiErrors.validation?.email }}</AuthFormError>
                <SubmitButton
                    :pending="pending"
                    label="Resend Verification Email"
                    @submit="handleSubmit"/>
            </div>
            <LoginLink/>
        </div>
    </AuthFormLayout>
</template>
