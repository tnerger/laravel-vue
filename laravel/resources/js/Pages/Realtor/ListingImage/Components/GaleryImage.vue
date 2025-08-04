<template>
    <div
        class="flex flex-col justify-end">

        <div class="h-full">
            <img :src="image.sizes[0].src" class="rounded-md" alt="">
        </div>
        <input type="numberhidden" name="sort" :v-model="image.sort">
        <div class="flex my-4">
            <label :for="'is_cover_' + image.id">
                is cover
            </label>
            <input :id="'is_cover_' + image.id" type="radio" name="is_cover" :value="1" v-model="form.is_cover"
             @change="updateImage"  >
        </div>
        <Link class="mt-2 btn-outline text-xs" :href="route('realtor.listing.image.destroy', [listing, image])"
            method="DELETE">
        Delete Image
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
const emit = defineEmits(['imageUpdated']);


const props = defineProps({
    listing: Object,
    image: Object
});
const form = useForm({
    sort: props.image.sort,
    is_cover: props.image.is_cover
});
const updateImage = () => {
        // Update the image using the form
        form.put(route('realtor.listing.image.update', { listing: props.listing.id, image: props.image.id }), {
            onSuccess: () => {
                // Emit an event to notify the parent component that the image has been updated
                emit('imageUpdated', props.image.id);
            },
            preserveScroll: true,
            preserveState: true,
        });
};


</script>
