<template>
    <form action="">
        <div class="flex flex-wrap gap-4 mt-4 mb-4">
            <div class="flex flex-nowrap items-center gap-2">
                <input v-model="filterForm.deleted" id="deleted" type="checkbox"
                    class="border-gray-300 rounded focus:ring-indigo-500 w-4 h-4 text-indigo-600"> <label
                    for="deleted">Deleted</label>
            </div>
            <div>
                <select v-model="filterForm.by" class="input-filter-l w-24">
                    <option value="created_at">Date</option>
                    <option value="price">Price</option>
                </select>
                <select v-model="filterForm.order" class="input-filter-r w-32">
                    <option v-for="opt in sortOptions" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
                </select>
            </div>

        </div>
    </form>
</template>

<script setup>
import { reactive, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3'
import { debounce } from 'lodash'
const props = defineProps({ filter: Array, sort: Array });
const filterForm = reactive({
    deleted: props.filter?.deleted ?? false,
    by: props.sort?.by ?? 'created_at',
    order: props.sort?.order ?? 'asc',
});



const sortLabels = {
    created_at: [
        {
            label: 'Latest',
            value: 'desc'
        },
        {
            label: 'Oldest',
            value: 'asc'
        }
    ],
    price: [
        {
            label: 'most expensive',
            value: 'desc'
        },
        {
            label: 'cheap',
            value: 'asc'
        }
    ]
}

const sortOptions = computed(() => sortLabels[filterForm.by]);

watch(
    filterForm, debounce(() => router.get(
        route('realtor.listing.index'),
        filterForm,
        { preserveState: true, preserveScroll: true }
    ), 1000)
);
</script>
