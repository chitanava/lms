<script setup>
import { reactive } from "vue";
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import TextInput from "@/components/auth/form/TextInput.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import { useAPI } from "@/use/useAPI.js";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth.js";

const router = useRouter()

const store = useAuthStore()

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

    await load(query)

    if (success.value && success.value.data.register.status === 'MUST_VERIFY_EMAIL'){
        store.verifyEmailAddress = state.email

        router.push({ name: 'verify-email' })
    }
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
                    :apiValidationError="apiErrors?.validation?.firstName"/>
                <TextInput
                    v-model="state.lastName"
                    label="Last name"
                    required
                    :apiValidationError="apiErrors?.validation?.lastName"/>
            </div>
            <TextInput
                v-model="state.email"
                label="Email"
                type="email"
                required
                :apiValidationError="apiErrors?.validation?.email"/>
            <PasswordInput
                v-model="state.password"
                label="Password"
                passwordMeter
                required
                :apiValidationError="apiErrors?.validation?.password"/>
            <PasswordInput v-model="state.passwordConfirmation" label="Password confirmation" required />
            <SubmitButton label="Register" :pending="pending"/>
            <LoginLink/>
        </AuthFormContent>
    </AuthFormLayout>
</template>
