<template>
    <ListingForm
        submit-text="Create"
        @submit="create"
    />
</template>

<script setup>
import ListingForm from './Components/ListingForm.vue';

const create = (form) => {
    form.post(route('realtor.listing.store'));
};
</script>
