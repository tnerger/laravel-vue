<template>

    <div class="flex justify-between items-start">
        <h1 class="mb-4 text-3xl"> Your Listings</h1>
        <Link :href="route('realtor.listing.create')" class="btn-primary" alt="Add a new listing">+ New Listing
        </Link>
    </div>
    <section v-if="listings.data.length">
        <RealtorFilters :filter="filter" :sort="sort"></RealtorFilters>
    </section>

    <section v-if="listings.data.length" class="gap-2 grid grid-cols-1 lg:grid-cols-2">
        <Box v-for="listing in listings.data" :key="listing.id"
            :class="{ 'border-dashed dark:border-red-900 border-red-900': listing.deleted_at }">
            <div class="flex md:flex-row flex-col justify-between md:items-center gap-2">
                <div :class="{ 'opacity-25': listing.deleted_at }">
                    <div v-if="listing.sold_at !== null"
                        class="inline-block mb-2 p-1 border border-green-300 dark:border-green-900 border-dashed rounded-md font-bold text-green-500 dark:text-green-900 text-xs uppercase">
                        Sold</div>
                    <div class="xl:flex items-center gap-2">
                        <Price :price="listing.price" class="font-medium text-2xl"></Price>
                        <ListingSpace :listing="listing"></ListingSpace>
                    </div>
                    <ListingAddress :listing="listing" class="text-gray-500"></ListingAddress>
                </div>
                <section>
                    <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
                        <a target="_blank" class="btn-outline font-medium text-xs"
                            :href="route('listing.show', listing)">
                            Preview
                        </a>
                        <Link class="btn-outline font-medium text-xs" :href="route('realtor.listing.edit', listing)">
                        Edit
                        </Link>
                        <Link class="btn-outline font-medium text-xs" v-if="!listing.deleted_at" method="DELETE"
                            :href="route('realtor.listing.destroy', [listing.id])">
                        Delete </Link>
                        <Link v-else class="btn-outline font-medium text-xs"
                            :href="route('realtor.listing.restore', listing)" method="PUT">Restore</Link>
                    </div>
                    <div class="mt-2">
                        <Link class="block btn-outline w-full font-medium text-xs text-center"
                            :href="route('realtor.listing.image.create', { listing })">
                        Edit Images <span v-if="listing.images_count">({{ listing.images_count }})</span>
                        </Link>
                    </div>
                    <div class="mt-2">
                        <Link class="block btn-outline w-full font-medium text-xs text-center"
                            :href="route('realtor.listing.show', { listing })">
                        See offers <span v-if="listing.offers_count">({{ listing.offers_count }})</span>
                        </Link>
                    </div>
                </section>
            </div>
        </Box>
    </section>
    <EmptyState v-else>You have no Listings, yet.</EmptyState>


    <section v-if="listings.total > listings.per_page" class="flex justify-center mt-4 mb-4 w-full">
        <Pagination :links="listings.links"></Pagination>
    </section>
</template>

<script setup>
import EmptyState from '@/Components/UI/EmptyState.vue';
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
