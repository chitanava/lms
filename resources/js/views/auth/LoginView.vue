<script setup>
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import TextInput from "@/components/auth/form/TextInput.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import RegisterLink from "@/components/auth/links/RegisterLink.vue";
import ForgotPasswordLink from "@/components/auth/links/ForgotPasswordLink.vue";
import {useLogin} from "@/use/useLogin.js";


const { state, apiErrors, success, pending, login } = useLogin()

const handleSubmit = async () => {
  await login()
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Login to your account</AuthFormHeader>
        <AuthFormContent @submit="handleSubmit" novalidate>
            <TextInput
                v-model="state.email"
                label="Email"
                type="email"
                required
                :apiValidationError="apiErrors?.validation ? apiErrors?.validation?.email : apiErrors?.message"/>
            <PasswordInput
                v-model="state.password"
                label="Password"
                required
                :apiValidationError="apiErrors?.validation?.password"/>
            <ForgotPasswordLink/>
            <SubmitButton label="Login" :pending="pending"/>
            <RegisterLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
