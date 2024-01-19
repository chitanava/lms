<script setup>

</script>

<template>
    <div class="container mx-auto">
        <ul class="menu menu-vertical lg:menu-horizontal bg-base-200 rounded-box mb-4">
            <li><router-link to="/">Go to Home</router-link></li>
            <li><router-link to="/about">Go to About</router-link></li>
        </ul>

        <router-view></router-view>
    </div>
</template>

<style scoped>

</style>
