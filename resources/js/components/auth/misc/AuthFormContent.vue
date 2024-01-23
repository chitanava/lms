<script setup>
const emit = defineEmits(['submit'])
</script>

<template>
    <form @submit.prevent="$emit('submit')">
        <div class="space-y-6">
            <slot />
        </div>
    </form>
</template>
