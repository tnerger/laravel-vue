<template>
    <div class="gap-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <Listing v-for="listing in listings" :listing :key="listing.id" />
    </div>
</template>
<script setup>
import Listing from '@/Pages/Listing/Index/Components/Listing.vue';

const props = defineProps({ listings: Array })
</script>
