<template>
    <div class="mb-4">
        <Link :href="route('realtor.listing.index')">
        < Back</Link>
    </div>
    <section class="items-start gap-4 grid grid-cols-12">
        <Box v-if="!hasOffers" class="flex items-center col-span-12 md:col-span-7 md:row-start-1">
            <div class="w-full font-medium text-gray-500">
                No Offers
            </div>
        </Box>
        <div v-else class="flex flex-wrap items-start col-span-12 md:col-span-7 md:row-start-1">
            <Offer class="mb-4 w-full" v-for="offer in listing.offers" :listing-price="listing.price" :listing="listing"
                :offer="offer" :key="offer.id" :is-sold="listing.sold_at !== null" />
        </div>
        <Box class="flex flex-col gap-4 col-span-12 md:col-span-5 row-start-1">
            <template #header>Basic Info</template>
            <Price :price="listing.price" class="font-bold text-2xl" />

            <ListingSpace :listing="listing" class="text-lg" />
            <ListingAddress :listing="listing" class="text-gray-500" />
        </Box>
    </section>
</template>
<script setup>
import Offer from '@/Pages/Realtor/Show/Components/Offer.vue';
import Box from '@/Components/UI/Box.vue';
import { Link } from '@inertiajs/vue3';
import Price from '@/Components/Price.vue';
import ListingSpace from '@/Components/ListingSpace.vue';
import ListingAddress from '@/Components/ListingAddress.vue';
import { computed } from 'vue';
const props = defineProps({ listing: Object });
const hasOffers = computed(() => props.listing.offers.length)
</script>
