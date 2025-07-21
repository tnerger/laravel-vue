<template>
    <Box>
        <template #header>Upload new Images</template>
        <form @submit.prevent="upload">
            <input type="file" name="images[]" @change="addFiles" multiple>
            <button class="btn-outline">Upload</button>
            <button type="reset" @click="reset" class="btn-outline">Reset</button>
        </form>
    </Box>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue';
import { useForm } from '@inertiajs/vue3';
const props = defineProps({ listing: Object })
const form = useForm({
    images: []
});

const upload = () => {
    form.post(
        route('realtor.listing.image.store', { listing: props.listing.id }, {
            onSuccess: () => form.reset('images'),
            forceFormData: true
        })
    )
}

const addFiles = (event) => {
    const addFiles = (event) => {
        form.images = Array.from(event.target.files);
    }
}

const reset = () => form.reset('images')
</script>
