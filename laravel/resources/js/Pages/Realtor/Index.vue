<template>
    <h1 class="mb-4 text-3xl">Your Listings</h1>
    <section>
        <RealtorFilters :filter="filter" :sort="sort"></RealtorFilters>
    </section>

    <section class="gap-2 grid grid-cols-1 lg:grid-cols-2">
        <Box v-for="listing in listings.data" :key="listing.id">
            <div class="flex md:flex-row flex-col justify-between md:items-center gap-2">
                <div>
                    <div class="xl:flex items-center gap-2">
                        <Price :price="listing.price" class="font-medium text-2xl"></Price>
                        <ListingSpace :listing="listing"></ListingSpace>
                    </div>
                    <ListingAddress :listing="listing" class="text-gray-500"></ListingAddress>
                </div>
                <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
                    <a target="_blank" class="btn-outline font-medium text-xs" :href="route('listing.show', listing)"> Preview
                    </a>
                    <Link class="btn-outline font-medium text-xs" :href="route('realtor.listing.edit', listing)"> Edit
                    </Link>
                    <Link class="btn-outline font-medium text-xs" v-if="listing.deleted_at === null" method="DELETE"
                        :href="route('realtor.listing.destroy', [listing.id])">
                    Delete </Link>
                </div>
            </div>
        </Box>

    </section>
    <section v-if="listings.links" class="flex justify-center mt-4 mb-4 w-full">
        <Pagination :links="listings.links"></Pagination>
    </section>
</template>

<script setup>
import ListingAddress from '@/Components/ListingAddress.vue';
import ListingSpace from '@/Components/ListingSpace.vue';
import Price from '@/Components/Price.vue';
import Box from '@/Components/UI/Box.vue';
import { Link } from '@inertiajs/vue3';
import RealtorFilters from './Index/Components/RealtorFilters.vue';
import Pagination from '@/Components/UI/Pagination.vue';

defineProps({ listings: Array, filter: Array, sort: Array })
</script>

<style lang="scss" scoped></style>
