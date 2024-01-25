<script setup>
import { vNoAnimation } from "@/directives/noAnimation.js";

const props = defineProps({
    label: {
        type: String,
        default: 'Submit'
    },
    pending: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['submit'])
</script>

<template>
    <button
        @click="$emit('submit')"
        class="btn btn-active btn-primary w-full no-animation"
        :disabled="props.pending"
        v-no-animation>
            <span v-if="props.pending" class="loading loading-spinner"></span>
            {{ props.label }}
        </button>
</template>
