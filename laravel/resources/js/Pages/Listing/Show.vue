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
                    Monthly Payment
                </template>
                <div>
                    <label for="interest-rate">Interest rate ({{ interstRate.toLocaleString() }}%)</label>
                    <input v-model.number="interstRate" id="interest-rate" class="input-range" type="range" min="0.1"
                        max="30" step="0.1">
                </div>
                <div>
                    <label for="duration">Duration ({{ duration }} years)</label>
                    <input v-model.number="duration" id="duration" class="input-range" type="range" min="3" max="35"
                        step="1">
                </div>
                <div class="mt-2 text-gray-600 dark:text-gray-300">
                    <div class="text-gray-400">Your monthly payment</div>
                    <Price :price="monthlyPayment" class="text-3xl"></Price>
                </div>
                <div class="mt-2 text-gray-500">
                    <div class="flex justify-between">
                        <div>Total paid</div>
                        <div> <Price :price="totalPaid" class="font-medium" /> </div>
                    </div>

                    <div class="flex justify-between">
                        <div>Principal paid</div>
                        <div> <Price :price="listing.price" class="font-medium" /> </div>
                    </div>

                    <div class="flex justify-between">
                        <div>Total Interest</div>
                        <div> <Price :price="totalInterest" class="font-medium" /> </div>
                    </div>

                </div>
            </Box>
        </div>
    </div>
</template>

<script setup>
import ListingAddress from '@/Components/ListingAddress.vue';
import ListingSpace from '@/Components/ListingSpace.vue';
import Price from '@/Components/Price.vue';
import Box from '@/Components/UI/Box.vue';
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment';
import { ref } from 'vue';
const interstRate = ref(2.5);
const duration = ref(25);
const props = defineProps({ listing: Object })
const { monthlyPayment, totalInterest, totalPaid } = useMonthlyPayment(props.listing.price, interstRate, duration);

</script>
