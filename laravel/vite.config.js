import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                    // This is necessary to handle Vue components correctly
                    // when using Vite with Laravel.
                    // It ensures that asset URLs are transformed correctly
                    // in Vue single-file components.
                },
            },
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: true,
        hmr: {
            host: 'localhost'
        }
    },
});
