<template>
    <h1 class="mb-4 text-3xl">Your Notifications</h1>
    <section v-if="notifications.data.length" class="text-gray-700 dark:text-gray-400">
        <div v-for="notification in notifications.data" class="flex justify-between items-center py-4 border-gray-200 dark:border-gray-800 border-b" :key="notification.id">
            <div>
                <span v-if="notification.type === 'App\\Notifications\\OfferMade'">
                    Offer <Price :price="notification.data.amount" /> for <Link class="text-red-600" :href="route('realtor.listing.show',{listing:notification.data.listing_id})">listing</Link>
                    was made!
                </span>
            </div>
            <div>
                <Link :href="route('notification.read',{notification})" method="put" v-if="!notification.read_at" class="btn-outline font-medium text-xs uppercase">Mark as read</Link>
            </div>
        </div>
    </section>
    <EmptyState v-else>No Notifications yet!</EmptyState>

    <section v-if="notifications.data.length" class="flex justify-center my-6 w-full">
        <Pagination :links="notifications.links" />
    </section>

</template>

<script setup>
import Price from '@/Components/Price.vue';
import { Link } from '@inertiajs/vue3';
import EmptyState from '@/Components/UI/EmptyState.vue';
import Pagination from '@/Components/UI/Pagination.vue';
const props = defineProps({ notifications: Object })
</script>
