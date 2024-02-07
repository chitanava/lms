<script setup>
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import {useResetPassword} from "@/use/useResetPassword.js";
import AuthFormAlert from "@/components/auth/misc/AuthFormAlert.vue";

const { state, apiErrors, success, pending, resetPasswordProcess, clientErrors } = useResetPassword()

const handleSubmit = async () => {
    await resetPasswordProcess()
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Reset password</AuthFormHeader>
        <AuthFormContent @submit="handleSubmit" novalidate>
            <AuthFormAlert
                v-if="(clientErrors?.email || clientErrors?.token) || (apiErrors?.validation?.email || apiErrors?.validation?.token)"
                color="error"
                :message="(clientErrors?.email || clientErrors?.token) || (apiErrors?.validation?.email || apiErrors?.validation?.token)"/>
            <PasswordInput
                v-model="state.password"
                label="Password"
                passwordMeter
                :apiValidationError="clientErrors?.password || apiErrors?.validation?.password"/>
            <PasswordInput v-model="state.passwordConfirmation" label="Password confirmation" requierd/>
            <SubmitButton label="Reset Password" :pending="pending"/>
            <LoginLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
