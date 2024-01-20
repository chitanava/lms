<script setup>
import { usePasswordInputVisibily } from "@/use/usePasswordInputVisibily.js";
import { vNoAnimation } from "@/directives/noAnimation.js";
import AuthFormHeader from "@/components/auth-form/AuthFormHeader.vue";
import PasswordMeter from 'vue-simple-password-meter';
import {ref} from "vue";

const {showPassword, passwordInputType, togglePasswordVisibility} = usePasswordInputVisibily()

const password = ref('');
</script>

<template>
    <div class="space-y-8">
        <AuthFormHeader>Create new account</AuthFormHeader>
        <div class="space-y-6">
            <div class="flex gap-4">
                <label class="form-control flex-1">
                    <div class="label">
                        <span class="label-text">First name</span>
                    </div>
                    <input type="text" class="input input-bordered w-full" />
                </label>

                <label class="form-control flex-1">
                    <div class="label">
                        <span class="label-text">Last name</span>
                    </div>
                    <input type="text" class="input input-bordered w-full" />
                </label>
            </div>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Email</span>
                </div>
                <input type="text" class="input input-bordered w-full" />
            </label>

            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Password</span>
                </div>
                <div class="relative mb-1">
                    <input v-model="password" :type="passwordInputType" class="input input-bordered w-full" />
                    <div @click="togglePasswordVisibility" class="absolute top-1/2 -translate-y-1/2 right-3 cursor-pointer">
                        <span v-if="!showPassword">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-base-content/50">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </span>
                        <span v-else>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-base-content/50">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="mx-4"><password-meter :password="password" /></div>
            </label>

            <button class="btn btn-active btn-primary w-full no-animation" v-no-animation>Register</button>
            <div class="text-right">
                <router-link :to="{name: 'login'}">
                    <span class="text-xs hover:underline hover:underline-offset-4">Login to your account</span>
                </router-link>
            </div>
        </div>
    </div>
</template>
