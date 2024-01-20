<script setup>
    const props = defineProps(['image'])
</script>

<template>
    <img :src="props.image" alt="" class="object-cover object-center w-full h-full">
</template>
