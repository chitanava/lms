<script setup>
import { vNoAnimation } from "@/directives/noAnimation.js";

const props = defineProps({
    label: {
        type: String,
        default: 'Submit'
    }
})

const emit = defineEmits(['submit'])
</script>

<template>
    <button
        @click="$emit('submit')"
        class="btn btn-active btn-primary w-full no-animation"
        v-no-animation>{{ props.label }}</button>
</template>
