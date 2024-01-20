<script setup>
import AuthFormImage from "@/components/auth/misc/AuthFormImage.vue";
</script>

<template>
    <div class="fixed inset-y-0 left-0 w-1/2">
        <AuthFormImage image="temp/books-on.jpg"/>
    </div>
    <div class="flex justify-end items-center min-h-screen">
        <div class="w-1/2 p-28">
            <slot />
        </div>
    </div>
</template>
