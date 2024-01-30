<script setup>
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import AuthFormError from "@/components/auth/misc/AuthFormError.vue";
import AuthFormAlert from "@/components/auth/misc/AuthFormAlert.vue";
import { useResendEmailVerification } from "@/use/useResendEmailVerification.js";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormIntroMessage from "@/components/auth/misc/AuthFormIntroMessage.vue";

const { apiErrors, pending, showAlert, resendEmailVerification } = useResendEmailVerification()

const handleSubmit = async () => {
    await resendEmailVerification()
}
</script>

<script>
import { useVerifyEmail } from "@/use/useVerifyEmail.js";

export default {
    async beforeRouteEnter(to, from, next) {
        await useVerifyEmail(to, next)
    }
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Verify Email</AuthFormHeader>
        <AuthFormContent :applyForm="false">
            <AuthFormIntroMessage>
                <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
            </AuthFormIntroMessage>
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
        </AuthFormContent>
    </AuthFormLayout>
</template>
