<script setup>
import { ref, reactive } from "vue";
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormContent from "@/components/auth/misc/AuthFormContent.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import TextInput from "@/components/auth/form/TextInput.vue";
import PasswordInput from "@/components/auth/form/PasswordInput.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import axios from "axios";
import AccountCreatedMessage from "@/components/auth/misc/AccountCreatedMessage.vue";

const lighthouseValidationError = ref({})
const success = ref(false)

const state = reactive({
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    passwordConfirmation: ''
})

const handleSubmit = async () => {
    console.log('Form submitted successfully.')

    const query = `
      mutation ($input: RegisterInput!) {
            register (input: $input) {
                token,
                status
            }
        }`

    const variables = {
        input: {
            first_name: state.firstName,
            last_name: state.lastName,
            email: state.email,
            password: state.password,
            password_confirmation: state.passwordConfirmation,
            verification_url: {
                url: "https://my-front-end.com/verify-email?id=__ID__&token=__HASH__"
            }
        }
    }

    const response = await axios({
        url: 'http://lms.test/graphql',
        method: 'post',
        headers: {
            'Content-Type': 'application/json',
        },
        data: {
            query,
            variables
        }
    });

    lighthouseValidationError.value = {}
    success.value = false

    const data = response.data

    if(data.errors && Array.isArray(data.errors)) {
        const validationError = data.errors[0].extensions?.validation

        if (validationError) {
            for (const [key, [value]] of Object.entries(validationError)) {
                lighthouseValidationError.value = {
                    ...lighthouseValidationError.value,
                    [key.split('.').pop()]: value,
                }
            }
        }
    } else {
        success.value = data
    }
}

</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Create new account</AuthFormHeader>
        <AuthFormContent v-if="!success" @submit="handleSubmit">
            <div class="flex gap-6">
                <TextInput v-model="state.firstName" label="First name" required />
                <TextInput v-model="state.lastName" label="Last name" required/>
            </div>
            <TextInput
                v-model="state.email"
                label="Email"
                type="email"
                required
                :lighthouseValidationError="lighthouseValidationError.email"/>
            <PasswordInput
                v-model="state.password"
                label="Password"
                passwordMeter
                required
                :lighthouseValidationError="lighthouseValidationError.password"/>
            <PasswordInput v-model="state.passwordConfirmation" label="Password confirmation" required />
            <SubmitButton label="Register"/>
            <LoginLink/>
        </AuthFormContent>

        <AccountCreatedMessage v-else :email="state.email"/>
    </AuthFormLayout>
</template>
