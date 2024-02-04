<script setup>
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import TextInput from "@/components/auth/form/TextInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import AuthFormIntroMessage from "@/components/auth/misc/AuthFormIntroMessage.vue";
import {useForgotPassword} from "@/use/useForgotPassword.js";
import AuthFormAlert from "@/components/auth/misc/AuthFormAlert.vue";

const { state, clientErrors, apiErrors, showAlert, pending, forgotPasswordProcess } = useForgotPassword()

const handleSubmit = async () => {
    await forgotPasswordProcess()
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Forgot password</AuthFormHeader>
        <AuthFormContent @submit="handleSubmit" novalidate>
            <AuthFormIntroMessage>
              <p>Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
            </AuthFormIntroMessage>
            <AuthFormAlert v-if="showAlert">
              <h3 class="font-bold">We have just sent you an email!</h3>
              <div class="text-xs">We have emailed your password reset link.</div>
            </AuthFormAlert>
            <TextInput
                v-model="state.email"
                label="Email"
                type="email"
                required
                :apiValidationError="clientErrors?.email || apiErrors?.validation?.email"/>
            <SubmitButton
                label="Email Password Reset Link"
                :pending="pending"/>
            <LoginLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
