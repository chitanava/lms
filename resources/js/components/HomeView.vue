<script setup>
import { useCounterStore } from '@/stores/counter'

const store = useCounterStore()
</script>

<template>
    <div class="card w-96 bg-base-100 shadow-xl">
        <figure><img src="https://daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg" alt="Shoes" /></figure>
        <div class="card-body">
            <h2 class="card-title">Shoes!</h2>
            <p>If a dog chews <span class="font-bold">{{store.count}}</span> shoes whose shoes does he choose?</p>
            <div class="card-actions justify-end">
                <button class="btn btn-primary" @click="store.increment()">Buy Now</button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
