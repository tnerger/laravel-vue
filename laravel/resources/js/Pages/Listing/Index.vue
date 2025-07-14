<template>
    <div v-for="listing in listings" :key="listing.id">
        <div>
            <Link :href="route('listing.show',listing)">
            <ListingAddress :listing></ListingAddress>
            </Link>
        </div>
        <div>
            <Link :href="route('listing.edit',listing)">Edit</Link>
        </div>
        <div>
            <Link :href="route('listing.destroy',listing)" method="DELETE">Delete</Link>
        </div>
    </div>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
import ListingAddress from '@/Components/ListingAddress.vue';

const props = defineProps({ listings: Array })
</script>
