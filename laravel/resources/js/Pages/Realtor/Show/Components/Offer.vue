<template>
    <Box>
        <template #header>Offer #{{ offer?.id }} <span class="bg-green-200 dark:bg-green-900 ml-2 p-1 rounded-md text-green-900 dark:text-green-200 text-xs uppercase" v-if="offer.accepted_at !== null">accepted</span> </template>
        <section class="flex justify-between items-center">
            <div>
                <Price :price="offer.amount" class="text-xl" />
                <div class="text-gray-500">
                    Difference :
                    <Price :price="difference" />
                </div>
                <div class="text-gray-500 text-sm">
                    Made by {{ offer.user.name }}
                </div>
                <div class="text-gray-500 text-sm">
                    Made on {{ new Date(offer.created_at).toDateString() }}
                </div>
            </div>
            <div>
                <Link v-if="!isSold" :href="route('realtor.offer.accept',offer)" class="btn-outline font-medium text-xs" method="put" as="button">Accept</Link>
            </div>

        </section>
    </Box>
</template>
<script setup>
import Box from '@/Components/UI/Box.vue';
import { Link } from '@inertiajs/vue3';
import Price from '@/Components/Price.vue';
import { computed } from 'vue';

const props = defineProps({ offer: Object, listingPrice: Number, isSold: Boolean });
const difference = computed(() => props.offer.amount - props.listingPrice)

</script>
