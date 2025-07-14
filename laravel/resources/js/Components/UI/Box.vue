<template>
    <div class="shadow-sm p-4 border border-gray-200 dark:border-gray-800 rounded-md dark:text-gray-300">
        <div class="font-medium text-gray-500">
            <slot name="header"></slot>
        </div>
        <slot></slot>
    </div>
</template>
