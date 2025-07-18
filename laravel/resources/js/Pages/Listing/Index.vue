<template>
    <Filters :filters="filters" />
    <div class="gap-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <Listing v-for="listing in listings.data" :listing :key="listing.id" />
    </div>
    <div v-if="listings.links" class="flex justify-center mt-4 mb-4 w-full">
        <Pagination :links="listings.links"></Pagination>
    </div>
</template>
<script setup>
import Pagination from '@/Components/UI/Pagination.vue';
import Listing from '@/Pages/Listing/Index/Components/Listing.vue';
import Filters from './Index/Components/Filters.vue';

const props = defineProps({ listings: Object, filters: Object })
</script>
