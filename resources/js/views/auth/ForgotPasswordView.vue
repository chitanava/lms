<script setup>
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";

const handleSubmit = () => {
    console.log('Form submitted successfully.')
}
</script>

<template>
    <div class="space-y-8">
        <AuthFormHeader>Forgot password</AuthFormHeader>
        <div class="space-y-6">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Email</span>
                </div>
                <input type="text" class="input input-bordered w-full" />
            </label>

            <SubmitButton label="Reset password" @submit="handleSubmit"/>

            <LoginLink/>

        </div>
    </div>
</template>
