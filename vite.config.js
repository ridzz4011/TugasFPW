import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: '0.0.0.0', // Listen on all public IPs
        port: 5173,      // The port Vite runs on
        hmr: {
            host: 'localhost', // This is the address your browser will use to connect to HMR
                               // It should resolve to your Docker host machine from the browser's perspective
            port: 5173,
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
