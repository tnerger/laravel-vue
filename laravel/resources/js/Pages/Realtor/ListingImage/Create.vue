<template>
    <Box>
        <template #header>
            <span v-if="uploadPercentage == 0">Upload new Images</span>
            <span v-else>Uploading new Images ({{ uploadPercentage }}%)</span>
        </template>
        <form @submit.prevent="upload">
            <section class="flex items-center gap-2 mt-4 mb-4">
                <input
                    class="dark:file:bg-gray-700 file:bg-gray-100 file:hover:bg-gray-200 file:mr-4 file:px-4 file:py-2 border border-gray-200 dark:border-gray-700 file:border-0 rounded-md file:font-medium file:dark:text-gray-400 file:text-gray-700"
                    type="file" name="images[]" @change="addFiles" multiple>
                <button class="btn-outline" :disabled="canNotUpload">Upload</button>
                <button type="reset" @click="reset" class="btn-outline">Reset</button>
            </section>
        </form>
    </Box>

    <Box class="mt-4" v-if="listing?.images?.length">
        <template #header>Current Listing Images</template>
        <div class="gap-4 grid grid-cols-3 mt-4">
            <div v-for="image in listing.images" :key="image.id">
                <img :src="image.src" class="rounded-md" alt="">
            </div>
        </div>
    </Box>
</template>

<script setup>
import { computed, ref } from 'vue';
import Box from '@/Components/UI/Box.vue';
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({ listing: Object });
const uploadPercentage = ref(0);
router.on('progress', (event) => {
    // NProgress ersatz, klein, aber fein :-)
    uploadPercentage.value = event.detail.progress.percentage;
})
const form = useForm({
    images: []
});
const canNotUpload = computed(() => form.images.length ? false : true);
const upload = () => {
    form.post(
        route('realtor.listing.image.store', { listing: props.listing.id }, {
            onSuccess: () => form.reset('images'),
            forceFormData: true
        })
    )
}


const addFiles = (event) => {
    form.images = Array.from(event.target.files);
}


const reset = () => form.reset('images')
</script>
