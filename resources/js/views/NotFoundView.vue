<script setup>
import { useRedirect } from "@/use/useRedirect.js";

const { getRedirectMessage } = useRedirect()
const abortMessage = getRedirectMessage()
</script>

<template>
    <h3>Not Found</h3>
    <p>{{ abortMessage }}</p>
</template>
