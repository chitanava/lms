<script setup>
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import TextInput from "@/components/auth/form/TextInput.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import { useRegister } from "@/use/useRegister.js";

const { state, apiErrors, pending, registerProcess, clientErrors } = useRegister()

const handleSubmit = async () => {
    await registerProcess()
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Create new account</AuthFormHeader>
        <AuthFormContent @submit="handleSubmit" novalidate>
            <div class="flex gap-6">
                <TextInput
                    v-model="state.firstName"
                    label="First name"
                    required
                    :apiValidationError="clientErrors?.firstName || apiErrors?.validation?.firstName"/>
                <TextInput
                    v-model="state.lastName"
                    label="Last name"
                    required
                    :apiValidationError="clientErrors?.lastName || apiErrors?.validation?.lastName"/>
            </div>
            <TextInput
                v-model="state.email"
                label="Email"
                type="email"
                required
                :apiValidationError="clientErrors?.email || apiErrors?.validation?.email"/>
            <PasswordInput
                v-model="state.password"
                label="Password"
                passwordMeter
                required
                :apiValidationError="clientErrors?.password || apiErrors?.validation?.password"/>
            <PasswordInput v-model="state.passwordConfirmation" label="Password confirmation" required />
            <SubmitButton label="Register" :pending="pending"/>
            <LoginLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
