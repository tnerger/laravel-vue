<template>
    <header class="bg-white dark:bg-gray-800 border-gray-200 border-b dark:border-b-gray-700 w-full">
        <div class="mx-auto container">
            <nav class="flex justify-between items-center p-4">
                <div class="font-medium text-lg">
                    <Link :href="route('listing.index')">Listings</Link>
                </div>
                <div class="font-bold text-red-700 text-xl text-center">
                    <Link :href="route('listing.index')">HotPlaces</Link>
                </div>
                <div>
                    <Link :href="route('listing.create')"
                        class="btn-primary">+ New Listing
                    </Link>
                </div>
            </nav>
        </div>
    </header>
    <main class="mx-auto p-4 container">
        <div v-if="flashSuccess" class="bg-green-50 dark:bg-green-900 shadow-sm mb-4 p-2 border border-green-200 dark:border-green-800 rounded-md">
            {{ flashSuccess }}
        </div>
        <slot></slot>
    </main>

</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
const props = defineProps({ message: String })
// page.props.value.falsh.success = VERALTET!
// page.props.falsh.success = Neu, OHNE value in Vue 3
const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);
</script>
