<template>
    <div class="flex gap-1">
        <Link v-for="(link, index) in links" :key="index" class="px-4 py-2 rounded-md" :href="link.url ?? '#'"
            :class="{ 'bg-red-700 text-gray-300': link.active, 'pointer-events-none opacity-45': !link.url }" v-html="link.label">
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({ links: Array })
</script>
