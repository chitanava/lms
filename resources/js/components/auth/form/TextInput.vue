<script setup>
import AuthFormError from "@/components/auth/misc/AuthFormError.vue";

const model = defineModel()

const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'text'
    },
    required: {
        type: Boolean,
        default: false
    },
    apiValidationError: {
        type: String,
        default: null
    }
})
</script>

<template>
    <label class="form-control w-full">
        <div class="label">
            <span class="label-text">{{ props.label }}</span>
        </div>
        <input v-model="model" :type="props.type" class="input input-bordered w-full" :required="props.required"/>
        <AuthFormError v-if="props.apiValidationError">{{ props.apiValidationError }}</AuthFormError>
    </label>
</template>
