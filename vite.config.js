import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/landing.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    // Separate Three.js into its own chunk for lazy loading
                    three: ['three'],
                    gsap: ['gsap'],
                    apexcharts: ['apexcharts'],
                },
            },
        },
    },
    optimizeDeps: {
        include: ['three', 'gsap', 'apexcharts', 'alpinejs'],
    },
});
