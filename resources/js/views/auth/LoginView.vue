<script setup>
import { reactive } from "vue";
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import TextInput from "@/components/auth/form/TextInput.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import RegisterLink from "@/components/auth/links/RegisterLink.vue";
import ForgotPasswordLink from "@/components/auth/links/ForgotPasswordLink.vue";

const state = reactive({
    email: '',
    password: ''
})

const handleSubmit = () => {
    console.log('Form submitted successfully.')
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Login to your account</AuthFormHeader>
        <AuthFormContent>
            <TextInput v-model="state.email" label="Email"/>
            <PasswordInput v-model="state.password" label="Password"/>
            <ForgotPasswordLink/>
            <SubmitButton label="Login" @submit="handleSubmit"/>
            <RegisterLink/>
        </AuthFormContent>
    </AuthFormLayout>

</template>
