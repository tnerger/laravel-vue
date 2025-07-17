<template>
    <div class="gap-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <Listing v-for="listing in listings.data" :listing :key="listing.id" />
    </div>
    <div v-if="listings.links" class="flex justify-center mt-8 mb-8 w-full">
        <Pagination :links="listings.links"></Pagination>
    </div>
</template>
<script setup>
import Pagination from '@/Components/UI/Pagination.vue';
import Listing from '@/Pages/Listing/Index/Components/Listing.vue';

const props = defineProps({ listings: Object })
</script>
