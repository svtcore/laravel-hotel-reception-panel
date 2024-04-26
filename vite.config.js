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
                'resources/css/rooms-style.css',
                'resources/css/guests-style.css',
                'resources/js/booking/index.js',
                'resources/js/booking/search.js',
                'resources/js/booking/show.js',
                'resources/js/rooms/index.js',
                'resources/js/rooms/show.js',
                'resources/js/guests/index.js',
                'resources/js/guests/edit.js',
                'resources/js/guests/search.js',
                'resources/js/guests/create.js',
                'resources/js/employees/index.js',
                'resources/js/users/index.js',
                'resources/js/dashboard/income.js',
                'resources/js/dashboard/rooms.js',
                'resources/js/dashboard/rooms_availability.js',
                'resources/js/dashboard/bookings.js'
            ],
            refresh: true,
        }),
    ],
});
