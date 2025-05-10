import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    resolve: {
        alias: {
            '@css': path.resolve(__dirname, './resources/css'), // Đường dẫn tới thư mục CSS
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
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
    ],
    define: {
        'process.env': {
            APP_URL: process.env.APP_URL, // Biến từ Laravel .env
            APP_NAME: process.env.APP_NAME,
        },
    },
});
