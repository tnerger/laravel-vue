<template>
    <div class="gap-4 grid grid-cols-12">
        <!-- md:row-start-1 ist dazu gedacht, dass die beiden Boxen vom wechsel
        sm <=> md die PLätze tauschen. Iwie besser, als wie im Kurs den
        Container von Grid zu Flex wechseln zu lassen    -->
        <Box class="flex items-center col-span-12 md:col-span-7 md:row-start-1">
            <div class="w-full font-medium text-gray-500 text-center">No Images</div>
        </Box>
        <div class="flex flex-col gap-4 col-span-12 md:col-span-5 row-start-1">
            <Box>
                <template #header>
                    Basic Info
                </template>
                <Price :price="listing.price" class="font-bold text-2xl" />
                <ListingSpace :listing class="text-lg"></ListingSpace>
                <ListingAddress :listing class="text-gray-500"></ListingAddress>
            </Box>
            <Box>
                <template #header>
                    Offer
                </template>
                Make an Offer!
            </Box>
        </div>
    </div>
</template>

<script setup>
import ListingAddress from '@/Components/ListingAddress.vue';
import ListingSpace from '@/Components/ListingSpace.vue';
import Price from '@/Components/Price.vue';
import Box from '@/Components/UI/Box.vue';
const props = defineProps({ listing: Object })
</script>
