<script setup>
    const props = defineProps(['image'])
</script>

<template>
    <div class="flex-1 bg-no-repeat bg-cover bg-center rounded-l-2xl" :class="`bg-[url('${props.image}')]`"></div>
</template>
