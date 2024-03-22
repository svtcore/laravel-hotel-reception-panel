import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/main-style.css',
                'resources/css/bookings-style.css',
                'resources/js/booking/index.js',
                'resources/js/booking/search.js',
                'resources/js/booking/show.js'
            ],
            refresh: true,
        }),
    ],
});
