<template>
    <Box >
        <div>
            <Link :href="route('listing.show', listing)">
            <div class="flex items-baseline gap-1">
                <Price :price="listing.price" class="font-bold text-2xl" />
                <div class="text-gray-500 text-xs">
                    <Price :price="monthlyPayment"/> pm
                </div>
            </div>
            <ListingSpace :listing="listing" class="text-lg"></ListingSpace>
            <ListingAddress :listing="listing" class="text-gray-500"></ListingAddress>
            </Link>
        </div>
        <div>
            <Link :href="route('listing.edit', listing)">Edit</Link>
        </div>
        <div>
            <Link :href="route('listing.destroy', listing)" method="DELETE">Delete</Link>
        </div>
    </Box>
</template>

<script setup>
import ListingAddress from '@/Components/ListingAddress.vue';
import ListingSpace from '@/Components/ListingSpace.vue';
import Price from '@/Components/Price.vue';
import Box from '@/Components/UI/Box.vue';
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment';
import { Link } from '@inertiajs/vue3';
const props = defineProps({ listing: Object })
const { monthlyPayment } = useMonthlyPayment(props.listing?.price, 2.5, 25);

</script>
