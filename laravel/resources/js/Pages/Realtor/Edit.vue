<template>
    <ListingForm
        :initial-data="listing"
        submit-text="Edit"
        @submit="update"
    />
</template>

<script setup>
import ListingForm from './Components/ListingForm.vue';

const props = defineProps({
    listing: Object
});

const update = (form) => {
    form.put(route('realtor.listing.update', props.listing.id));
};
</script>
