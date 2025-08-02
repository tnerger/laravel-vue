<!-- filepath: /home/tobias/Dokumente/Kurse/laravel-vue/laravel/resources/js/Components/ImageZoom.vue -->
<template>
    <Teleport to="body">
        <div v-if="isOpen" class="z-50 fixed inset-0 flex justify-center items-center bg-black bg-opacity-90"
            @click="$emit('close')" @keydown.esc="$emit('close')">
            <button @click="$emit('close')" class="top-4 right-4 z-10 absolute text-white hover:text-gray-300 text-2xl">
                ✕
            </button>
            <div class="relative p-4 max-w-7xl max-h-screen">
                <!-- Close Button -->


                <!-- Navigation Arrows -->
                <button v-if="images.length > 1" @click.stop="previousImage"
                    class="top-1/2 left-4 z-10 absolute h-full text-white hover:text-gray-300 text-3xl -translate-y-1/2 cursor-pointer transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>

                </button>

                <button v-if="images.length > 1" @click.stop="nextImage"
                    class="top-1/2 right-4 z-10 absolute h-full text-white hover:text-gray-300 text-3xl -translate-y-1/2 cursor-pointer transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>

                </button>

                <!-- Main Image -->
                <img :src="currentImageSrc" :alt="image?.id" class="max-w-full max-h-full object-contain" @click.stop>

                <!-- Image Counter -->
                <div v-if="images.length > 1"
                    class="bottom-4 left-1/2 absolute bg-black bg-opacity-50 px-3 py-1 rounded text-white -translate-x-1/2 transform">
                    {{ currentIndex + 1 }} / {{ images.length }}
                </div>
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { computed, watch, ref } from 'vue';

const props = defineProps({
    image: Object,
    images: Array,
    isOpen: Boolean
});

const emit = defineEmits(['close']);

const currentIndex = ref(0);

// Finde Index des aktuellen Bildes
watch(() => props.image, (newImage) => {
    if (newImage && props.images) {
        const index = props.images.findIndex(img => img.id === newImage.id);
        if (index !== -1) {
            currentIndex.value = index;
        }
    }
});

const currentImage = computed(() => {
    return props.images?.[currentIndex.value] || props.image;
});

const currentImageSrc = computed(() => {
    // Verwende größere Bildversion für Zoom
    return currentImage.value?.sizes?.find(size => size.size === 'large')?.src ||
        currentImage.value?.sizes?.find(size => size.size === 'medium')?.src ||
        currentImage.value?.sizes?.[0]?.src;
});

const previousImage = () => {
    if (currentIndex.value > 0) {
        currentIndex.value--;
    } else {
        currentIndex.value = props.images.length - 1;
    }
};

const nextImage = () => {
    if (currentIndex.value < props.images.length - 1) {
        currentIndex.value++;
    } else {
        currentIndex.value = 0;
    }
};

// Keyboard Navigation
const handleKeydown = (event) => {
    if (!props.isOpen) return;

    switch (event.key) {
        case 'ArrowLeft':
            previousImage();
            break;
        case 'ArrowRight':
            nextImage();
            break;
        case 'Escape':
            emit('close');
            break;
    }
};

// Add/remove event listeners
watch(() => props.isOpen, (isOpen) => {
    if (isOpen) {
        document.addEventListener('keydown', handleKeydown);
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    } else {
        document.removeEventListener('keydown', handleKeydown);
        document.body.style.overflow = '';
    }
});
</script>
