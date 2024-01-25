<script setup>
import { reactive } from "vue";
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import TextInput from "@/components/auth/form/TextInput.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import AccountCreatedMessage from "@/components/auth/misc/AccountCreatedMessage.vue";
import { useAPI } from "@/use/useAPI.js";

const state = reactive({
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    passwordConfirmation: ''
})

const { apiErrors, success, pending, load } = useAPI()

const handleSubmit = async () => {
    const query = `
            mutation {
                register(input: {
                    first_name: "${state.firstName}"
                    last_name: "${state.lastName}"
                    email: "${state.email}"
                    password: "${state.password}"
                    password_confirmation: "${state.passwordConfirmation}"
                    verification_url: {
                        url: "https://my-front-end.com/verify-email?id=__ID__&token=__HASH__"
                    }
                }) {
                    token
                    status
                }
            }
            `

    load(query)
}
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Create new account</AuthFormHeader>
        <AuthFormContent v-if="!success" @submit="handleSubmit" novalidate>
            <div class="flex gap-6">
                <TextInput
                    v-model="state.firstName"
                    label="First name"
                    required
                    :apiValidationError="apiErrors.validation?.first_name"/>
                <TextInput
                    v-model="state.lastName"
                    label="Last name"
                    required
                    :apiValidationError="apiErrors.validation?.last_name"/>
            </div>
            <TextInput
                v-model="state.email"
                label="Email"
                type="email"
                required
                :apiValidationError="apiErrors.validation?.email"/>
            <PasswordInput
                v-model="state.password"
                label="Password"
                passwordMeter
                required
                :apiValidationError="apiErrors.validation?.password"/>
            <PasswordInput v-model="state.passwordConfirmation" label="Password confirmation" required />
            <SubmitButton label="Register" :pending="pending"/>
            <LoginLink/>
        </AuthFormContent>

        <AccountCreatedMessage v-else :email="state.email"/>
    </AuthFormLayout>
</template>
