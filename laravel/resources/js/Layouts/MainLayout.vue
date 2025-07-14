<template>
    <header class="border-b border-gray-200 bg-white dark:border-b-gray-700 dark:bg-gray-800 w-full">
        <div class="container mx-auto">
            <nav class="flex p-4 items-center justify-between">
                <div class="text-lg font-medium">
                    <Link :href="route('listing.index')">Listings</Link>
                </div>
                <div class="text-xl text-red-700 font-bold text-center">
                    <Link :href="route('listing.index')">HotPlaces</Link>
                </div>
                <div>
                    <Link :href="route('listing.create')"
                        class="bg-red-700 hover:bg-red-800 text-slate-900 font-medium p-2 rounded-md">+ New Listing
                    </Link>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4">
        <div v-if="flashSuccess" class="mb-4 border rounded-md shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2">
            {{ flashSuccess }}
        </div>
        <slot></slot>
    </main>

</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
const props = defineProps({ message: String })
// page.props.value.falsh.success = VERALTET!
// page.props.falsh.success = Neu, OHNE value in Vue 3
const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);
</script>
