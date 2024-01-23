<script setup>
import LoginLinkButton from "@/components/auth/links/LoginLinkButton.vue";

const props = defineProps(['email'])
</script>

<template>
    <div class="text-center leading-7">
        <p class="mb-4">Congratulations! Your account has been successfully created.</p>
        <p>To access your account, please verify your email. We've just sent an email to <span class="underline underline-offset-4">{{ props.email }}</span>. Kindly check your inbox and follow the provided instructions to complete the verification process.</p>

        <div class="divider">OR</div>

        <LoginLinkButton />
    </div>
</template>
