<template>
    <Box>
        <Link :href="route('listing.show', listing)" class="grid grid-cols-6">
        <div class="flex justify-center items-center col-span-2 p-2 pl-0">
            <img v-if="listing.images.length" class="rounded-md max-h-30" :src="listing.images[0].sizes[0].src" alt="">
            <NoImage v-else class="fill-gray-400 w-10 h-10" />
        </div>
        <div class="col-span-4">
            <div class="flex items-baseline gap-1">
                <Price :price="listing.price" class="font-bold text-2xl" />
                <div class="text-gray-500 text-xs">
                    <Price :price="monthlyPayment" /> pm
                </div>
            </div>
            <ListingSpace :listing="listing" class="text-lg"></ListingSpace>
            <ListingAddress :listing="listing" class="text-gray-500"></ListingAddress>
        </div>
        </Link>
    </Box>
</template>

<script setup>
import NoImage from '@/Components/Images/NoImage.vue';
import ListingAddress from '@/Components/ListingAddress.vue';
import ListingSpace from '@/Components/ListingSpace.vue';
import Price from '@/Components/Price.vue';
import Box from '@/Components/UI/Box.vue';
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment';
import { Link } from '@inertiajs/vue3';
const props = defineProps({ listing: Object })
const { monthlyPayment } = useMonthlyPayment(props.listing?.price, 2.5, 25);

</script>
