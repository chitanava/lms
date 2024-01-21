<script setup>
import { reactive } from "vue";
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import TextInput from "@/components/auth/form/TextInput.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";

const state = reactive({
    firstName: '',
    lastName: '',
    email: '',
    password: ''
})

const handleSubmit = () => {
    console.log('Form submitted successfully.')
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Create new account</AuthFormHeader>
        <AuthFormContent>
            <div class="flex gap-6">
                <TextInput v-model="state.firstName" label="First name"/>
                <TextInput v-model="state.lastName" label="Last name"/>
            </div>
            <TextInput v-model="state.email" label="Email"/>
            <PasswordInput v-model="state.password" label="Password" :passwordMeter="true"/>
            <SubmitButton label="Register" @submit="handleSubmit"/>
            <LoginLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
