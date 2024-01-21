<script setup>
const model = defineModel()

const props = defineProps({
    label: {
        type: String,
        required: true,
    }
})
</script>

<template>
    <label class="form-control w-full">
        <div class="label">
            <span class="label-text">{{ props.label }}</span>
        </div>
        <input v-model="model" type="text" class="input input-bordered w-full" />
    </label>
</template>
