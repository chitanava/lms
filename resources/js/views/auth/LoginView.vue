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
import {useRedirect} from "@/use/useRedirect.js";
import AuthFormAlert from "@/components/auth/misc/AuthFormAlert.vue";
import {ref} from "vue";

const { state, apiErrors, success, pending, loginProcess, clientErrors } = useLogin()

const resetPasswordMessage = ref('')

const { getRedirectMessage } = useRedirect()
resetPasswordMessage.value = getRedirectMessage()

const handleSubmit = async () => {
    resetPasswordMessage.value = ''

    await loginProcess()
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Login to your account</AuthFormHeader>
        <AuthFormContent @submit="handleSubmit" novalidate>
            <AuthFormAlert v-if="resetPasswordMessage" :message="resetPasswordMessage" />
            <TextInput
                v-model="state.email"
                label="Email"
                type="email"
                required
                :apiValidationError="clientErrors?.email || (apiErrors?.validation ? apiErrors?.validation?.email : apiErrors?.message)"/>
            <PasswordInput
                v-model="state.password"
                label="Password"
                required
                :apiValidationError="clientErrors?.password || apiErrors?.validation?.password"/>
            <ForgotPasswordLink/>
            <SubmitButton label="Login" :pending="pending"/>
            <RegisterLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
