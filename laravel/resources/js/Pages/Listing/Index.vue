<template>
    <div class="gap-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3">
        <Box v-for="listing in listings" :key="listing.id">
            <div>
                <Link :href="route('listing.show', listing)">
                <Price :price="listing.price" class="font-bold text-2xl" />
                <ListingSpace :listing class="text-lg"></ListingSpace>
                <ListingAddress :listing class="text-gray-500"></ListingAddress>
                </Link>
            </div>
            <div>
                <Link :href="route('listing.edit', listing)">Edit</Link>
            </div>
            <div>
                <Link :href="route('listing.destroy', listing)" method="DELETE">Delete</Link>
            </div>
        </Box>
    </div>
</template>
<script setup>
import ListingAddress from '@/Components/ListingAddress.vue';
import ListingSpace from '@/Components/ListingSpace.vue';
import Price from '@/Components/Price.vue';
import { Link } from '@inertiajs/vue3';

import Box from '@/Components/UI/Box.vue';

const props = defineProps({ listings: Array })
</script>
