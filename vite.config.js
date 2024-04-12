import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/base.css', 'resources/js/base.js'],
            refresh: true,
        }),
    ],
});
