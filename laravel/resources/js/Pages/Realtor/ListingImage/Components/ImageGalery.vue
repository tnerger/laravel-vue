<template>
    <Box class="mt-4" v-if="listing.images?.length">
        <template #header>Current Listing Images</template>
        <div class="gap-4 grid grid-cols-3 mt-4">
            <GaleryImage @image-updated="galeryUpdated" v-for="image in listing.images" :key="image.id" :image="image"
                :listing="listing" />
        </div>
    </Box>

    <EmptyState v-else class="mt-4 py-30" title="No Images" description="You can upload images for your listing here." >
        <NoImage class="fill-gray-500 mx-auto w-1/2" />
        <div class="text-2xl">No Images uploaded yet.</div>
    </EmptyState>

</template>

<script setup>
import EmptyState from '@/Components/UI/EmptyState.vue';
import NoImage from '@/Components/Images/NoImage.vue';
import GaleryImage from './GaleryImage.vue';
import Box from '@/Components/UI/Box.vue';
import { debounce } from 'lodash';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({ listing: Object });

const emit = defineEmits(['galeryUpdated']);

const galeryUpdated = () => {
    debounce(() => {
        emit('galeryUpdated');
    }, 500)();
};

</script>
