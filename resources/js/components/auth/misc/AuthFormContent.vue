<script setup>
const props = defineProps({
    novalidate: {
        type: Boolean,
        default: false
    }
})
const emit = defineEmits(['submit'])
</script>

<template>
    <form @submit.prevent="$emit('submit')" :novalidate="props.novalidate">
        <div class="space-y-6">
            <slot />
        </div>
    </form>
</template>
