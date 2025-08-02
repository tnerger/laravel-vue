<template>
    <div>
        You need to be verified to see this page!
    </div>
    <div class="mt-4">
        <Link :href="route('verification.send')" class="btn-outline" method="post">Resent verfication Email.</Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
