<script setup>
const props = defineProps({
    novalidate: {
        type: Boolean,
        default: false
    },
    applyForm: {
      type: Boolean,
      default: true
    }
})
const emit = defineEmits(['submit'])
</script>

<template>
    <form v-if="props.applyForm" @submit.prevent="$emit('submit')" :novalidate="props.novalidate">
        <div class="space-y-6">
            <slot />
        </div>
    </form>
    <div v-else class="space-y-6">
      <slot />
    </div>
</template>
