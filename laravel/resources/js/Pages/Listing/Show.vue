<template>
    <div>
       <ListingAddress :listing></ListingAddress>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import ListingAddress from '@/Components/ListingAddress.vue';
const props = defineProps({ listing: Object })
</script>
