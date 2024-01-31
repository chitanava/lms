<script setup>
    const props = defineProps({
        color: {
            type: String,
            default: null
        },
        message: {
            type: String,
            default: null
        }
    })
</script>

<template>
    <div
        role="alert"
        class="alert"
        :class="{
            'shadow-lg': !color,
            'alert-error': color === 'error'
        }">
        <svg v-if="!color" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <svg v-if="color === 'error'" xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>

        <div>
            <slot/>

            <span v-if="message">{{ props.message }}</span>
        </div>
    </div>
</template>
