<template>
    <nav class="flex space-x-2 mb-4 px-2.5">
        <Link href="/">Index</Link>
        <Link href="/hello">Show</Link>
    </nav>
    <div>The page with time {{ timer }}</div>
    <slot></slot>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({ message: String })
import { ref } from 'vue'

const timer = ref(0);
setInterval(() => timer.value++, 999)
</script>

