<script setup>
import { reactive } from "vue";
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import TextInput from "@/components/auth/form/TextInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";

const state = reactive({
    email: '',
})

const handleSubmit = () => {
    console.log('Form submitted successfully.')
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Forgot password</AuthFormHeader>
        <AuthFormContent>
            <TextInput v-model="state.email" label="Email"/>
            <SubmitButton label="Reset password" @submit="handleSubmit"/>
            <LoginLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
