<script setup>
import { vNoAnimation } from "@/directives/noAnimation.js";
import AuthFormHeader from "@/components/auth-form/AuthFormHeader.vue";
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

            <button class="btn btn-active btn-primary w-full no-animation" v-no-animation>Reset password</button>

            <div class="text-right">
                <router-link :to="{name: 'login'}">
                    <span class="text-xs hover:underline hover:underline-offset-4">Login to your account</span>
                </router-link>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
