<template>
    <div class="items-start gap-4 grid grid-cols-12">
        <h1 class="col-span-12 row-start-1 text-bold text-xl">{{ listing.title }}</h1>
        <!-- md:row-start-1 ist dazu gedacht, dass die beiden Boxen vom wechsel
        sm <=> md die PLätze tauschen. Iwie besser, als wie im Kurs den
        Container von Grid zu Flex wechseln zu lassen    -->

        <Box v-if="listing.images.length" class="flex items-center col-span-12 md:col-span-7 md:row-start-2">
            <div class="gap-2 columns-2 sm:columns-3 lg:columns-2 xl:columns-3 w-full">
                <div class="mb-2 rounded-lg overflow-hidden break-inside-avoid" v-for="image in listing.images"
                    :key="image.id">
                    <img :src="image.sizes?.find((im) => im.size == 'small')?.src"
                         @click="openZoom(image)"
                         :alt="listing.id + ' - ' + image.id"
                         class="hover:opacity-90 w-full h-auto object-cover transition-opacity cursor-pointer">
                </div>
            </div>
        </Box>
        <EmptyState v-else class="flex items-center col-span-12 md:col-span-7 md:row-start-2">No Images</EmptyState>
        <div class="flex flex-col gap-4 col-span-12 md:col-span-5 row-start-2">
            <Box>
                <template #header>
                    Basic Info
                </template>
                <Price :price="listing.price" class="font-bold text-2xl" />
                <ListingSpace :listing class="text-lg"></ListingSpace>
                <ListingAddress :listing class="text-gray-500"></ListingAddress>
            </Box>
            <Box>
                {{ listing.description }}
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
                        <div>
                            <Price :price="totalPaid" class="font-medium" />
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div>Principal paid</div>
                        <div>
                            <Price :price="listing.price" class="font-medium" />
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div>Total Interest</div>
                        <div>
                            <Price :price="totalInterest" class="font-medium" />
                        </div>
                    </div>

                </div>
            </Box>
            <OfferMade :offer="offerMade" v-if="user?.id && offerMade?.amount" />
            <MakeOffer v-else-if="user?.id" :listing-id="listing.id" :price="listing.price"
                @offer-updated="offer = $event" />

        </div>
        <!-- Zoom Modal -->
        <ImageZoom
            :image="selectedImage"
            :images="listing.images"
            :is-open="showZoom"
            @close="closeZoom"
        />
    </div>
</template>

<script setup>
import EmptyState from '@/Components/UI/EmptyState.vue';
import OfferMade from '@/Pages/Listing/Show/Components/OfferMade.vue';
import MakeOffer from '@/Pages/Listing/Show/Components/MakeOffer.vue';
import ListingAddress from '@/Components/ListingAddress.vue';
import ListingSpace from '@/Components/ListingSpace.vue';
import Price from '@/Components/Price.vue';
import Box from '@/Components/UI/Box.vue';
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment';
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
const props = defineProps({ listing: Object, offerMade: Object })
const interstRate = ref(2.5);
const duration = ref(25);
const offer = ref(props.listing.price);
const { monthlyPayment, totalInterest, totalPaid } = useMonthlyPayment(offer, interstRate, duration);
const page = usePage();
const user = computed(() => page.props.user);

/*Zoom Functions*/
import ImageZoom from '@/Pages/Listing/Show/Components/ImageZoom.vue';
const selectedImage = ref(null);
const showZoom = ref(false);

const openZoom = (image) => {
    selectedImage.value = image;
    showZoom.value = true;
};

const closeZoom = () => {
    showZoom.value = false;
    selectedImage.value = null;
};
</script>
