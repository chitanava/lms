<script setup>
import { reactive } from "vue";
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";

const state = reactive({
    password: '',
    passwordConfirmation: ''
})

const handleSubmit = () => {
    console.log('Form submitted successfully.')
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Reset password</AuthFormHeader>
        <AuthFormContent>
            <PasswordInput v-model="state.password" label="Password" :passwordMeter="true"/>
            <PasswordInput v-model="state.passwordConfirmation" label="Password confirmation"/>
            <SubmitButton label="Reset password" @submit="handleSubmit"/>
            <LoginLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
