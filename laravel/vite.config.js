import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import forms from '@tailwindcss/forms';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: ['resources/views/**', 'resources/js/**/*.vue', 'resources/js/app.js', 'app/**/*.php'],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
            script: {
                defineModel: true,
                propsDestructure: true
            }
        }),
        tailwindcss(
            { config: {
                content: [
                    './resources/views/**/*.blade.php',
                    './resources/js/**/*.vue',
                    './resources/js/**/*.js',
                    './storage/framework/views/*.php',
                ],
                theme: {
                    extend: {},
                },
                plugins: [
                    forms,
                ],
            }
        }
        ),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            ziggy: path.resolve('vendor/tightenco/ziggy/dist'),
        },
    },
    optimizeDeps: {
        include: ['@inertiajs/vue3']
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: true,
        hmr: {
            host: 'localhost',
            port: 5173,
        },
        watch: {
            usePolling: true,
            interval: 500,
            ignored: ['**/node_modules/**', '**/vendor/**']
        }
    },
});
