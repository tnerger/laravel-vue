<template>
    <nav class="flex space-x-2 mb-4 px-2.5">
        <Link href="/">Index</Link>
        <Link href="/hello">Show</Link>
    </nav>
    <!-- <div>The page with time {{ timer }}</div> -->
    <div v-if="flashSuccess" class="success">
        {{ flashSuccess }}
    </div>
    <slot></slot>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
const props = defineProps({ message: String })
// import { ref } from 'vue'
// page.props.value.falsh.success = VERALTET!
// page.props.falsh.success = Neu, OHNE value in Vue 3
const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);

// const timer = ref(0);
// setInterval(() => timer.value++, 999)
</script>

<style scoped>
.success {
    background-color: green;
    color: white;
}
</style>
