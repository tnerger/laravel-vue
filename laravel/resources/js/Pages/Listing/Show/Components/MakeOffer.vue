<template>
    <Box>
        <template #header>Make an Offer</template>
        <div>
            <form @submit.prevent="makeOffer">
                <input v-model.number="form.amount" class="input" type="text">
                <input v-model.number="form.amount" id="duration" class="mt-2 input-range" type="range" :min="price / 2"
                    :max="price * 2" :step="Number.parseInt((price * 2 - price / 2) / 100)">
                <button stype="submit" class="mt-2 w-full text-sm btn-otline">Make an Offer</button>
                <div class="input-error" v-if="form.errors.amount">
                    {{ form.errors.amount }}
                </div>
            </form>
        </div>
        <div class="flex justify-between mt-2 text-gray-500">
            <div>Differnce</div>
            <div>
                <Price :price="form.amount - props.price"></Price>
            </div>
        </div>
    </Box>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue';
import Price from '@/Components/Price.vue';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    listingId: Number,
    price: Number
})
const form = useForm({
    amount: props.price
})

const makeOffer = () => form.post(
    route('listing.offer.store', { listing: props.listingId }),
    {
        preserveScroll: true,
        preserveState: true
    }
)

const differnce = computed(() => form.amount - props.price);
</script>
