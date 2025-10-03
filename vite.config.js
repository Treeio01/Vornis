import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from "@tailwindcss/vite";
import path from 'path'


export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',

            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        tailwindcss()
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '~': path.resolve(__dirname, 'resources'),
            '@components': path.resolve(__dirname, 'resources/js/Components'),
            '@pages': path.resolve(__dirname, 'resources/js/Pages'),
            '@composables': path.resolve(__dirname, 'resources/js/composables'),
            '@utils': path.resolve(__dirname, 'resources/js/utils'),
            '@layout': path.resolve(__dirname, 'resources/js/Components/layout'),
        },
    },
});
