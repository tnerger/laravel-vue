<template>
    {{ listing.street }}
    {{ listing.street_nr }}
    {{ listing.city }},
    for ${{ listing.price }}
</template>

<script setup>
defineProps({ listing: Object })
</script>
