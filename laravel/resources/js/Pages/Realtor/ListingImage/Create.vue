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
            <div v-if="imageErros.length" class="input-error">
                <div v-for="(error, index) in imageErros" :key="index">{{ error }}</div>
            </div>
        </form>
    </Box>

    <Box class="mt-4" v-if="listing?.images?.length">
        <template #header>Current Listing Images</template>
        <div class="gap-4 grid grid-cols-3 mt-4">
            <div v-for="image in listing.images" :key="image.id" class="flex flex-col justify-between">
                <img :src="image.sizes[0].src" class="rounded-md" alt="">
                <Link class="mt-2 btn-outline text-xs" :href="route('realtor.listing.image.destroy', [listing, image])"
                    method="DELETE">
                Delete Image
                </Link>
            </div>
        </div>
    </Box>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
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
const imageErros = computed(() =>
    Object.entries(form.errors)
    // mit reduce ein Array draus machen
        .reduce((carry, [i, value]) => {
            // , dass nur die Image-Errors enthält
            if (i.indexOf('images.') !== -1) {
                carry.push(
                    // Zur Lesbarkaeit für den Nutzer das Feld von image.0 field zu Image 1 umbennen, sonst weiß keiner was los ist.
                    value.replace(/images\.([\d]+)(\sfield)?/gi, (completeExpression, imageIndex) => {
                        return 'image ' + (Number.parseInt(imageIndex) + 1)
                    })
                )
            }
            return carry;
        }, [])
)
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
