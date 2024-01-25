<script setup>
import AuthFormLayout from "@/components/auth/misc/AuthFormLayout.vue";
import AuthFormHeader from "@/components/auth/misc/AuthFormHeader.vue";
import SubmitButton from "@/components/auth/form/SubmitButton.vue";
import LoginLink from "@/components/auth/links/LoginLink.vue";
</script>

<template>
    <AuthFormLayout>
        <AuthFormHeader>Verify Email</AuthFormHeader>
        <div class="space-y-6">
            <div class="leading-7">
                <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
            </div>
<!--            <div class="divider">OR</div>-->
            <div role="alert" class="alert shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h3 class="font-bold">We have just sent you an email!</h3>
                    <div class="text-xs">A new verification link has been sent to the email address you provided during registration.</div>
                </div>
            </div>
            <SubmitButton label="Resend Verification Email"/>
            <LoginLink/>
        </div>
    </AuthFormLayout>
</template>
