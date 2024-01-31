<script setup>
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import {useResetPassword} from "@/use/useResetPassword.js";
import AuthFormAlert from "@/components/auth/misc/AuthFormAlert.vue";

const { state, apiErrors, success, pending, resetPassword } = useResetPassword()

const handleSubmit = async () => {
    await resetPassword()
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Reset password</AuthFormHeader>
        <AuthFormContent @submit="handleSubmit" novalidate>
            <AuthFormAlert
                v-if="apiErrors?.validation?.email || apiErrors?.validation?.token"
                color="error"
                :message="apiErrors?.validation?.email || apiErrors?.validation?.token"/>
            <PasswordInput
                v-model="state.password"
                label="Password"
                passwordMeter
                :apiValidationError="apiErrors?.validation?.password"/>
            <PasswordInput v-model="state.passwordConfirmation" label="Password confirmation" requierd/>
            <SubmitButton label="Reset Password" :pending="pending"/>
            <LoginLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
