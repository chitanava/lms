<script setup>
import { vNoAnimation } from "@/directives/noAnimation.js";
</script>

<template>
    <router-link :to="{name: 'login'}">
        <span class="btn btn-outline btn-primary no-animation" v-no-animation>Return to the Login Page</span>
    </router-link>
</template>
