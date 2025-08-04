<template>
    <Box class="mt-4" v-if="listing.images?.length">
        <template #header>Current Listing Images</template>
        <div class="gap-4 grid grid-cols-3 mt-4">
            <GaleryImage @image-updated="galeryUpdated" v-for="image in listing.images" :key="image.id" :image="image" :listing="listing" />
        </div>
    </Box>
</template>

<script setup>
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
